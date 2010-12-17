<?php

/**
 * BaseJobTitle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $comments
 * @property string $salaryGradeId
 * @property string $jobspecId
 * @property integer $isActive
 * @property Doctrine_Collection $employees
 * @property SalaryGrade $SalaryGrade
 * @property JobSpecifications $JobSpecifications
 * @property Doctrine_Collection $JobTitleEmployeeStatus
 * @property Doctrine_Collection $definekpi
 * @property Doctrine_Collection $DefineKpi
 * @property Doctrine_Collection $PerformanceReview
 * 
 * @method string              getId()                     Returns the current record's "id" value
 * @method string              getName()                   Returns the current record's "name" value
 * @method string              getDescription()            Returns the current record's "description" value
 * @method string              getComments()               Returns the current record's "comments" value
 * @method string              getSalaryGradeId()          Returns the current record's "salaryGradeId" value
 * @method string              getJobspecId()              Returns the current record's "jobspecId" value
 * @method integer             getIsActive()               Returns the current record's "isActive" value
 * @method Doctrine_Collection getEmployees()              Returns the current record's "employees" collection
 * @method SalaryGrade         getSalaryGrade()            Returns the current record's "SalaryGrade" value
 * @method JobSpecifications   getJobSpecifications()      Returns the current record's "JobSpecifications" value
 * @method Doctrine_Collection getJobTitleEmployeeStatus() Returns the current record's "JobTitleEmployeeStatus" collection
 * @method Doctrine_Collection getDefinekpi()              Returns the current record's "definekpi" collection
 * @method Doctrine_Collection getDefineKpi()              Returns the current record's "DefineKpi" collection
 * @method Doctrine_Collection getPerformanceReview()      Returns the current record's "PerformanceReview" collection
 * @method JobTitle            setId()                     Sets the current record's "id" value
 * @method JobTitle            setName()                   Sets the current record's "name" value
 * @method JobTitle            setDescription()            Sets the current record's "description" value
 * @method JobTitle            setComments()               Sets the current record's "comments" value
 * @method JobTitle            setSalaryGradeId()          Sets the current record's "salaryGradeId" value
 * @method JobTitle            setJobspecId()              Sets the current record's "jobspecId" value
 * @method JobTitle            setIsActive()               Sets the current record's "isActive" value
 * @method JobTitle            setEmployees()              Sets the current record's "employees" collection
 * @method JobTitle            setSalaryGrade()            Sets the current record's "SalaryGrade" value
 * @method JobTitle            setJobSpecifications()      Sets the current record's "JobSpecifications" value
 * @method JobTitle            setJobTitleEmployeeStatus() Sets the current record's "JobTitleEmployeeStatus" collection
 * @method JobTitle            setDefinekpi()              Sets the current record's "definekpi" collection
 * @method JobTitle            setDefineKpi()              Sets the current record's "DefineKpi" collection
 * @method JobTitle            setPerformanceReview()      Sets the current record's "PerformanceReview" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseJobTitle extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_job_title');
        $this->hasColumn('jobtit_code as id', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => 13,
             ));
        $this->hasColumn('jobtit_name as name', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('jobtit_desc as description', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('jobtit_comm as comments', 'string', 400, array(
             'type' => 'string',
             'length' => 400,
             ));
        $this->hasColumn('sal_grd_code as salaryGradeId', 'string', 13, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 13,
             ));
        $this->hasColumn('jobspec_id as jobspecId', 'string', 13, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 13,
             ));
        $this->hasColumn('is_active as isActive', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Employee as employees', array(
             'local' => 'jobtit_code',
             'foreign' => 'job_title_code'));

        $this->hasOne('SalaryGrade', array(
             'local' => 'salaryGradeId',
             'foreign' => 'sal_grd_code'));

        $this->hasOne('JobSpecifications', array(
             'local' => 'jobspecId',
             'foreign' => 'jobspec_id'));

        $this->hasMany('JobTitleEmployeeStatus', array(
             'local' => 'id',
             'foreign' => 'jobtit_code'));

        $this->hasMany('DefineKpi as definekpi', array(
             'local' => 'jobtit_code',
             'foreign' => 'job_title_code'));

        $this->hasMany('DefineKpi', array(
             'local' => 'id',
             'foreign' => 'jobtitlecode'));

        $this->hasMany('PerformanceReview', array(
             'local' => 'id',
             'foreign' => 'jobTitleCode'));
    }
}