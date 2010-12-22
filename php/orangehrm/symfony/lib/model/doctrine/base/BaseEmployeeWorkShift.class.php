<?php

/**
 * BaseEmployeeWorkShift
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $workshift_id
 * @property integer $emp_number
 * @property WorkShift $WorkShift
 * @property Employee $Employee
 * 
 * @method integer           getWorkshiftId()  Returns the current record's "workshift_id" value
 * @method integer           getEmpNumber()    Returns the current record's "emp_number" value
 * @method WorkShift         getWorkShift()    Returns the current record's "WorkShift" value
 * @method Employee          getEmployee()     Returns the current record's "Employee" value
 * @method EmployeeWorkShift setWorkshiftId()  Sets the current record's "workshift_id" value
 * @method EmployeeWorkShift setEmpNumber()    Sets the current record's "emp_number" value
 * @method EmployeeWorkShift setWorkShift()    Sets the current record's "WorkShift" value
 * @method EmployeeWorkShift setEmployee()     Sets the current record's "Employee" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployeeWorkShift extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_employee_workshift');
        $this->hasColumn('workshift_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('WorkShift', array(
             'local' => 'workshift_id',
             'foreign' => 'workshift_id'));

        $this->hasOne('Employee', array(
             'local' => 'emp_number',
             'foreign' => 'empNumber'));
    }
}