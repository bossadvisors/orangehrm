<?php

/**
 * BaseLeavePeriod
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $leavePeriodId
 * @property date $startDate
 * @property date $endDate
 * @property Doctrine_Collection $EmployeeLeaveEntitlement
 * @property Doctrine_Collection $LeaveRequest
 * 
 * @method integer             getLeavePeriodId()            Returns the current record's "leavePeriodId" value
 * @method date                getStartDate()                Returns the current record's "startDate" value
 * @method date                getEndDate()                  Returns the current record's "endDate" value
 * @method Doctrine_Collection getEmployeeLeaveEntitlement() Returns the current record's "EmployeeLeaveEntitlement" collection
 * @method Doctrine_Collection getLeaveRequest()             Returns the current record's "LeaveRequest" collection
 * @method LeavePeriod         setLeavePeriodId()            Sets the current record's "leavePeriodId" value
 * @method LeavePeriod         setStartDate()                Sets the current record's "startDate" value
 * @method LeavePeriod         setEndDate()                  Sets the current record's "endDate" value
 * @method LeavePeriod         setEmployeeLeaveEntitlement() Sets the current record's "EmployeeLeaveEntitlement" collection
 * @method LeavePeriod         setLeaveRequest()             Sets the current record's "LeaveRequest" collection
 * 
 * @package    orangehrm
 * @subpackage model\coreleave\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLeavePeriod extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_leave_period');
        $this->hasColumn('leave_period_id as leavePeriodId', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('leave_period_start_date as startDate', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('leave_period_end_date as endDate', 'date', null, array(
             'type' => 'date',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('EmployeeLeaveEntitlement', array(
             'local' => 'leavePeriodId',
             'foreign' => 'leave_period_id'));

        $this->hasMany('LeaveRequest', array(
             'local' => 'leavePeriodId',
             'foreign' => 'leave_period_id'));
    }
}