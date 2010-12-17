<?php

/**
 * BaseMembershipType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $membtype_code
 * @property string $membtype_name
 * @property Doctrine_Collection $Membership
 * @property Doctrine_Collection $EmployeeMemberDetail
 * 
 * @method string              getMembtypeCode()         Returns the current record's "membtype_code" value
 * @method string              getMembtypeName()         Returns the current record's "membtype_name" value
 * @method Doctrine_Collection getMembership()           Returns the current record's "Membership" collection
 * @method Doctrine_Collection getEmployeeMemberDetail() Returns the current record's "EmployeeMemberDetail" collection
 * @method MembershipType      setMembtypeCode()         Sets the current record's "membtype_code" value
 * @method MembershipType      setMembtypeName()         Sets the current record's "membtype_name" value
 * @method MembershipType      setMembership()           Sets the current record's "Membership" collection
 * @method MembershipType      setEmployeeMemberDetail() Sets the current record's "EmployeeMemberDetail" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMembershipType extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_membership_type');
        $this->hasColumn('membtype_code', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => 13,
             ));
        $this->hasColumn('membtype_name', 'string', 120, array(
             'type' => 'string',
             'length' => 120,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Membership', array(
             'local' => 'membtype_code',
             'foreign' => 'membtype_code'));

        $this->hasMany('EmployeeMemberDetail', array(
             'local' => 'membtype_code',
             'foreign' => 'membtype_code'));
    }
}