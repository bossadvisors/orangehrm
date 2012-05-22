<?php

/**
 * BaseLeaveType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $leaveTypeId
 * @property string $leaveTypeName
 * @property integer $availableFlag
 * @property integer $operationalCountryId
 * @property OperationalCountry $OperationalCountry
 * @property Doctrine_Collection $EmployeeLeaveEntitlement
 * @property Doctrine_Collection $LeaveRequest
 * 
 * @method string              getLeaveTypeId()              Returns the current record's "leaveTypeId" value
 * @method string              getLeaveTypeName()            Returns the current record's "leaveTypeName" value
 * @method integer             getAvailableFlag()            Returns the current record's "availableFlag" value
 * @method integer             getOperationalCountryId()     Returns the current record's "operationalCountryId" value
 * @method OperationalCountry  getOperationalCountry()       Returns the current record's "OperationalCountry" value
 * @method Doctrine_Collection getEmployeeLeaveEntitlement() Returns the current record's "EmployeeLeaveEntitlement" collection
 * @method Doctrine_Collection getLeaveRequest()             Returns the current record's "LeaveRequest" collection
 * @method LeaveType           setLeaveTypeId()              Sets the current record's "leaveTypeId" value
 * @method LeaveType           setLeaveTypeName()            Sets the current record's "leaveTypeName" value
 * @method LeaveType           setAvailableFlag()            Sets the current record's "availableFlag" value
 * @method LeaveType           setOperationalCountryId()     Sets the current record's "operationalCountryId" value
 * @method LeaveType           setOperationalCountry()       Sets the current record's "OperationalCountry" value
 * @method LeaveType           setEmployeeLeaveEntitlement() Sets the current record's "EmployeeLeaveEntitlement" collection
 * @method LeaveType           setLeaveRequest()             Sets the current record's "LeaveRequest" collection
 * 
 * @package    orangehrm
 * @subpackage model\coreleave\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLeaveType extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_leavetype');
        $this->hasColumn('leave_type_id as leaveTypeId', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => 13,
             ));
        $this->hasColumn('leave_type_name as leaveTypeName', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('available_flag as availableFlag', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             ));
        $this->hasColumn('operational_country_id as operationalCountryId', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('OperationalCountry', array(
             'local' => 'operational_country_id',
             'foreign' => 'id'));

        $this->hasMany('EmployeeLeaveEntitlement', array(
             'local' => 'leaveTypeId',
             'foreign' => 'leave_type_id'));

        $this->hasMany('LeaveRequest', array(
             'local' => 'leaveTypeId',
             'foreign' => 'leave_type_id'));
    }
}