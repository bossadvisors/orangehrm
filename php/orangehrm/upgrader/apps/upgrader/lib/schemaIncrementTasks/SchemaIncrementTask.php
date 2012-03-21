<?php

abstract class SchemaIncrementTask {
    
    protected $userInputs;
    protected $upgradeUtility;
    protected $sql;
    protected $transactionComplete = true;
    protected $version;
    protected $incrementNumber;
    
    public function execute() {
        $this->upgradeUtility = new UpgradeUtility();
        $this->upgradeUtility->connectDatabase();
        $this->createOhrmUpgradeInfo($this->incrementNumber, $this->version);
        $this->loadSql();
    }
    
    abstract public function loadSql();
    abstract public function getUserInputWidgets();
    abstract public function setUserInputs();
    
    public function getProgress(){
        if($this->transactionComplete) {
            return 100;
        } else {
            return 0;
        }
    }
    
    public function checkTransactionComplete($results) {
        foreach($results as $result) {
            if(!$result) {
                $this->transactionComplete = false;
            }
        }
    }
    
    public function createOhrmUpgradeInfo($id, $version) {
        $sql= "CREATE TABLE IF NOT EXISTS `ohrm_upgrade_info` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `version` varchar(250) NOT NULL,
                  `status` varchar(250) NOT NULL,
                  PRIMARY KEY (`id`)
                ) engine=innodb default charset=utf8;";
        
        $result = $this->upgradeUtility->executeSql($sql);
        
        $valueString = "'".$id."', '". $version."' , 'started'";
        $sql= "INSERT INTO ohrm_upgrade_info
                            (id, version, status) 
                            VALUES($valueString);";
        
        $result = $this->upgradeUtility->executeSql($sql);
    }
    
    public function updateOhrmUpgradeInfo($transactionComplete, $id) {
        if ($transactionComplete) {
            $sql = "UPDATE ohrm_upgrade_info 
                        SET status = 'completed' WHERE id = '$id'";
           
            $result = $this->upgradeUtility->executeSql($sql);
        }
    }
}