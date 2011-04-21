<?php

/**
 * BaseEmployeeLicense
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $empNumber
 * @property string $code
 * @property date $date
 * @property date $renewal_date
 * @property Employee $Employee
 * @property Licenses $license
 * 
 * @method integer         getEmpNumber()    Returns the current record's "empNumber" value
 * @method string          getCode()         Returns the current record's "code" value
 * @method date            getDate()         Returns the current record's "date" value
 * @method date            getRenewalDate()  Returns the current record's "renewal_date" value
 * @method Employee        getEmployee()     Returns the current record's "Employee" value
 * @method Licenses        getLicense()      Returns the current record's "license" value
 * @method EmployeeLicense setEmpNumber()    Sets the current record's "empNumber" value
 * @method EmployeeLicense setCode()         Sets the current record's "code" value
 * @method EmployeeLicense setDate()         Sets the current record's "date" value
 * @method EmployeeLicense setRenewalDate()  Sets the current record's "renewal_date" value
 * @method EmployeeLicense setEmployee()     Sets the current record's "Employee" value
 * @method EmployeeLicense setLicense()      Sets the current record's "license" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployeeLicense extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_licenses');
        $this->hasColumn('emp_number as emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('licenses_code as code', 'string', 100, array(
             'type' => 'string',
             'primary' => true,
             'length' => 100,
             ));
        $this->hasColumn('licenses_date as date', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('licenses_renewal_date as renewal_date', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Employee', array(
             'local' => 'empNumber',
             'foreign' => 'empNumber'));

        $this->hasOne('Licenses as license', array(
             'local' => 'licenses_code',
             'foreign' => 'licenses_code'));
    }
}