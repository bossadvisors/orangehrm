<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCompanyStructure extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_compstructtree');
        $this->hasColumn('title', 'string', 2147483647, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '2147483647',
             ));
        $this->hasColumn('description', 'string', 2147483647, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '2147483647',
             ));
        $this->hasColumn('lft', 'integer', 4, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('rgt', 'integer', 4, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('parnt', 'integer', 4, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('loc_code', 'string', 13, array(
             'type' => 'string',
             'length' => '13',
             ));
        $this->hasColumn('dept_id', 'string', 32, array(
             'type' => 'string',
             'length' => '32',
             ));
    }

    public function setUp()
    {
        $this->hasMany('Employee as employees', array(
             'local' => 'id',
             'foreign' => 'work_station'));

        $this->hasOne('Location as location', array(
             'local' => 'loc_code',
             'foreign' => 'loc_code'));

        $this->hasMany('PerformanceReview', array(
             'local' => 'id',
             'foreign' => 'subDivisionId'));
    }
}