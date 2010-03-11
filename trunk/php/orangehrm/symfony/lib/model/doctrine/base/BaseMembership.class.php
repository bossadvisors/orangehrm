<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseMembership extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_membership');
        $this->hasColumn('membship_code', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => '13',
             ));
        $this->hasColumn('membtype_code', 'string', 13, array(
             'type' => 'string',
             'length' => '13',
             ));
        $this->hasColumn('membship_name', 'string', 120, array(
             'type' => 'string',
             'length' => '120',
             ));
    }

    public function setUp()
    {
        $this->hasOne('MembershipType', array(
             'local' => 'membtype_code',
             'foreign' => 'membtype_code'));

        $this->hasMany('EmployeeMemberDetail', array(
             'local' => 'membship_code',
             'foreign' => 'membship_code'));
    }
}