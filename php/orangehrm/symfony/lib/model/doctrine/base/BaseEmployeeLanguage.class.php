<?php

/**
 * BaseEmployeeLanguage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $emp_number
 * @property string $code
 * @property integer $lang_type
 * @property integer $competency
 * @property Employee $Employee
 * @property Language $Language
 * 
 * @method integer          getEmpNumber()  Returns the current record's "emp_number" value
 * @method string           getCode()       Returns the current record's "code" value
 * @method integer          getLangType()   Returns the current record's "lang_type" value
 * @method integer          getCompetency() Returns the current record's "competency" value
 * @method Employee         getEmployee()   Returns the current record's "Employee" value
 * @method Language         getLanguage()   Returns the current record's "Language" value
 * @method EmployeeLanguage setEmpNumber()  Sets the current record's "emp_number" value
 * @method EmployeeLanguage setCode()       Sets the current record's "code" value
 * @method EmployeeLanguage setLangType()   Sets the current record's "lang_type" value
 * @method EmployeeLanguage setCompetency() Sets the current record's "competency" value
 * @method EmployeeLanguage setEmployee()   Sets the current record's "Employee" value
 * @method EmployeeLanguage setLanguage()   Sets the current record's "Language" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployeeLanguage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_language');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('lang_code as code', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => 13,
             ));
        $this->hasColumn('elang_type as lang_type', 'integer', 2, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 2,
             ));
        $this->hasColumn('competency', 'integer', 2, array(
             'type' => 'integer',
             'default' => '0',
             'length' => 2,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Employee', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasOne('Language', array(
             'local' => 'lang_code',
             'foreign' => 'lang_code'));
    }
}