<?php

/**
 * BaseEmployeeImmigrationRecord
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $empNumber
 * @property decimal $recordId
 * @property string $number
 * @property string $status
 * @property timestamp $issuedDate
 * @property timestamp $expiryDate
 * @property string $notes
 * @property integer $type
 * @property date $reviewDate
 * @property string $countryCode
 * @property Employee $Employee
 * 
 * @method integer                   getEmpNumber()   Returns the current record's "empNumber" value
 * @method decimal                   getRecordId()    Returns the current record's "recordId" value
 * @method string                    getNumber()      Returns the current record's "number" value
 * @method string                    getStatus()      Returns the current record's "status" value
 * @method timestamp                 getIssuedDate()  Returns the current record's "issuedDate" value
 * @method timestamp                 getExpiryDate()  Returns the current record's "expiryDate" value
 * @method string                    getNotes()       Returns the current record's "notes" value
 * @method integer                   getType()        Returns the current record's "type" value
 * @method date                      getReviewDate()  Returns the current record's "reviewDate" value
 * @method string                    getCountryCode() Returns the current record's "countryCode" value
 * @method Employee                  getEmployee()    Returns the current record's "Employee" value
 * @method EmployeeImmigrationRecord setEmpNumber()   Sets the current record's "empNumber" value
 * @method EmployeeImmigrationRecord setRecordId()    Sets the current record's "recordId" value
 * @method EmployeeImmigrationRecord setNumber()      Sets the current record's "number" value
 * @method EmployeeImmigrationRecord setStatus()      Sets the current record's "status" value
 * @method EmployeeImmigrationRecord setIssuedDate()  Sets the current record's "issuedDate" value
 * @method EmployeeImmigrationRecord setExpiryDate()  Sets the current record's "expiryDate" value
 * @method EmployeeImmigrationRecord setNotes()       Sets the current record's "notes" value
 * @method EmployeeImmigrationRecord setType()        Sets the current record's "type" value
 * @method EmployeeImmigrationRecord setReviewDate()  Sets the current record's "reviewDate" value
 * @method EmployeeImmigrationRecord setCountryCode() Sets the current record's "countryCode" value
 * @method EmployeeImmigrationRecord setEmployee()    Sets the current record's "Employee" value
 * 
 * @package    orangehrm
 * @subpackage model\pim\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployeeImmigrationRecord extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_passport');
        $this->hasColumn('emp_number as empNumber', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('ep_seqno as recordId', 'decimal', 2, array(
             'type' => 'decimal',
             'primary' => true,
             'length' => 2,
             ));
        $this->hasColumn('ep_passport_num as number', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('ep_i9_status as status', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('ep_passportissueddate as issuedDate', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('ep_passportexpiredate as expiryDate', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('ep_comments as notes', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('ep_passport_type_flg as type', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             ));
        $this->hasColumn('ep_i9_review_date as reviewDate', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('cou_code as countryCode', 'string', 6, array(
             'type' => 'string',
             'length' => 6,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Employee', array(
             'local' => 'empNumber',
             'foreign' => 'empNumber'));
    }
}