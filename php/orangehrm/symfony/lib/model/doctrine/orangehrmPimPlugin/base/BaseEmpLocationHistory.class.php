<?php

/**
 * BaseEmpLocationHistory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $emp_number
 * @property string $code
 * @property string $name
 * @property timestamp $start_date
 * @property timestamp $end_date
 * @property Employee $Employee
 * 
 * @method integer            getId()         Returns the current record's "id" value
 * @method integer            getEmpNumber()  Returns the current record's "emp_number" value
 * @method string             getCode()       Returns the current record's "code" value
 * @method string             getName()       Returns the current record's "name" value
 * @method timestamp          getStartDate()  Returns the current record's "start_date" value
 * @method timestamp          getEndDate()    Returns the current record's "end_date" value
 * @method Employee           getEmployee()   Returns the current record's "Employee" value
 * @method EmpLocationHistory setId()         Sets the current record's "id" value
 * @method EmpLocationHistory setEmpNumber()  Sets the current record's "emp_number" value
 * @method EmpLocationHistory setCode()       Sets the current record's "code" value
 * @method EmpLocationHistory setName()       Sets the current record's "name" value
 * @method EmpLocationHistory setStartDate()  Sets the current record's "start_date" value
 * @method EmpLocationHistory setEndDate()    Sets the current record's "end_date" value
 * @method EmpLocationHistory setEmployee()   Sets the current record's "Employee" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmpLocationHistory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_location_history');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('code', 'string', 15, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 15,
             ));
        $this->hasColumn('name', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('start_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
        $this->hasColumn('end_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Employee', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));
    }
}