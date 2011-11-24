<?php
/*
 *
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */

class TestDataService {

    private static $dbConnection;
    private static $data;
    private static $tableNames;
    private static $lastFixture = null;
    private static $insertQueryCache = null;
    
    public static function populate($fixture) {
        
        self::_populateUsingPdoTransaction($fixture);
        //self::_populateUsingDoctrineObjects($fixture);

    }
    
    private static function _populateUsingDoctrineObjects($fixture) {
 
        self::_setData($fixture);       

        self::_disableConstraints();

        self::_truncateTables();
        
        foreach (self::$data as $tableName => $tableData) {

            $count = 0;

            foreach ($tableData as $key => $dataRow) {

                $rowObject = new $tableName;
                $rowObject->fromArray($dataRow);
                $rowObject->save();

                $count++;

            }

            if ($count > 0) {
                self::adjustUniqueId($tableName, $count, true);
            }

        }

        self::_enableConstraints();        
        
    }

    private static function _populateUsingPdoTransaction($fixture) {
        
        // Don't reload already loaded fixtures
        $useCache = true;
        if (self::$lastFixture != $fixture) {
            
            self::_setData($fixture);
            self::$lastFixture = $fixture;
            $useCache = false;
            self::$insertQueryCache = NULL;
        }         

        self::_disableConstraints();

        self::_truncateTables();        
        
        $pdo = self::_getDbConnection();
        $query = "";
        try {
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();
            
            if ($useCache) {
                foreach (self::$insertQueryCache as $query) {
                    $pdo->exec($query);
                }
            } else {
                self::$insertQueryCache = array();
                
                foreach (self::$data as $tableName => $tableData) {

                    $queryArray = self::_generatePdoInsertQueryArray($tableName, $tableData);
                    self::$insertQueryCache = array_merge(self::$insertQueryCache, $queryArray);
                    
                    foreach ($queryArray as $query) { 
                        $pdo->exec($query);
                    }

                }       
            }
            
            $pdo->commit();
            
        } catch (Exception $e) {
            
            $pdo->rollBack();
            echo __FILE__ .  ':' . __LINE__ . "\n Transaction failed: " . $e->getMessage() .
             "\nQuery: [" . $query . "]\n" . "Fixture: " . $fixture . "\n\n";
            
        }
        
        self::_enableConstraints();        
       
    }
    
    private static function _generatePdoInsertQueryArray($tableAlias, $tableData) {
        
       return self::_generateMultipleInsertQueryArray($tableAlias, $tableData);
       
       /* Multiple inserts have to be used since some fixtures contains different no
        * of columns for same data set */
        
    } 
    
    public static function _generateMultipleInsertQueryArray($tableAlias, $tableData) {
        
        $tableObject = self::_getTableObject($tableAlias);
        $tableName = $tableObject->getTableName();
        $queryArray = array();
        
        foreach ($tableData as $item) {
            
            $columnString = self::_generateInsetQueryColumnString($item, $tableObject);
            $queryArray[] = "INSERT INTO `$tableName` $columnString VALUES ('" . implode("', '", $item) . "')";

        }

        $queryArray[] = "UPDATE `hs_hr_unique_id` SET `last_id` = " . count($tableData) . " WHERE `table_name` = '$tableName'";
        
        return $queryArray;     
        
    }    
    
    private static function _generateInsetQueryColumnString($dataArray, $tableObject) {
        
        $columnString = "(";
        
        $count = count($dataArray);
        $i = 1;
        
        foreach ($dataArray as $key => $value) {
            
            $columnName = $tableObject->getColumnName($key);

            /* Had to remove backtick (`) since hs_hr_config's "key" column contains them */
            if ($i < $count) {
                $columnString .= "$columnName, ";
            } else {
                $columnString .= "$columnName";
            }
            
            $i++;
            
        }        
        
        $columnString .= ")";
        
        return $columnString;
        
    }
    
    private static function _getTableObject($tableAlias) {

        $ormObject = new $tableAlias;
        return $ormObject->getTable();
        
    }

    public static function adjustUniqueId($tableName, $count, $isAlias = false) {

        if ($isAlias) {
            $tableName = Doctrine::getTable($tableName)->getTableName();
        }

        $q = Doctrine_Query::create()
        ->from('UniqueId ui')
        ->where('ui.table_name = ?', $tableName);

        $uniqueIdObject = $q->fetchOne();

        if ($uniqueIdObject instanceof UniqueId) {

            $uniqueIdObject->setLastId($count);
            $uniqueIdObject->save();
            
        }

    }

    private static function _setData($fixture) {
        
        self::$data = sfYaml::load($fixture);
        self::_setTableNames();
    }

    private static function _setTableNames() {

        foreach (self::$data as $key => $value) {

            $table = Doctrine::getTable($key)->getTableName();
            if (!empty($table)) {
                self::$tableNames[] = $table;
            } else {
                echo __FILE__ .  ':' .__LINE__ . ") Skipping unknown table alias: " . $alias . 
                        "\n" . "Fixture: " . self::$lastFixture . "\n\n"; 
            }            
        }

    }

    private static function _disableConstraints() {

        // ToDo: disable database constraints
    
    }

    private static function _enableConstraints() {

        // ToDo: enable database constraints
    
    }

    private static function _truncateTables() {

        if (count(self::$tableNames) > 0) {
            $pdo = self::_getDbConnection();
            self::_disableConstraints();
            $query = '';
            
            try {

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->beginTransaction();

                foreach (self::$tableNames as $tableName) {
                    $query = 'DELETE FROM ' .  $tableName;
                    $pdo->query($query); 
                }

                $query = "UPDATE hs_hr_unique_id SET last_id = 0 WHERE table_name in ('" . 
                        implode("','", self::$tableNames) ."')";
                $pdo->exec($query);
                
                $pdo->commit();
            
            } catch (Exception $e) {
                $pdo->rollBack();
                echo __FILE__ .  ':' . __LINE__ . "\n Transaction failed: " . $e->getMessage() . 
                        "\nQuery: [" . $query . "]\n" . "Fixture: " . self::$lastFixture . "\n\n";
            }            
            
            self::_enableConstraints();
        }
    }

    /**
     *
     * @return PDO 
     */
    private static function _getDbConnection() {
        
        if (empty(self::$dbConnection)) {
            
            self::$dbConnection = Doctrine_Manager::getInstance()
                                                    ->getCurrentConnection()
                                                    ->getDbh();
            
            return self::$dbConnection;

        } else {

            return self::$dbConnection;

        }

    }

    public static function truncateTables($aliasArray) {

        foreach ($aliasArray as $alias) {
            $table = Doctrine::getTable($alias)->getTableName();
            if (!empty($table)) {
                self::$tableNames[] = $table;
            } else {
                echo __FILE__ . ':' . __LINE__ . ") Skipping unknown table alias: " . $alias . "\n";
            }
        }

        self::_truncateTables();

    }

    public static function fetchLastInsertedRecords($alias, $count) {

        $wholeCount = Doctrine::getTable($alias)->findAll()->count();
        $offset = $wholeCount - $count;

        $q = Doctrine_Query::create()
             ->from("$alias a")
             ->offset($offset)
             ->limit($count);

        return $q->execute();

    }
    
    public static function fetchLastInsertedRecord($alias, $orderBy) {

        $q = Doctrine_Query::create()
             ->from("$alias a")
             ->orderBy("$orderBy DESC");

        return $q->fetchOne();

    }    

    public static function fetchObject($alias, $primaryKey) {

        return Doctrine::getTable($alias)->find($primaryKey);

    }

    public static function loadObjectList($alias, $fixture, $key) {

        $objectList = array();
        $data = sfYaml::load($fixture);

        foreach ($data[$key] as $row) {
            $object = new $alias;
            $object->fromArray($row);
            $objectList[] = $object;
        }

        return $objectList;

    }
    
    public static function getRecords($query) {
        return self::_getDbConnection()->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

}


