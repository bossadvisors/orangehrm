<?php

/**
 * BasePerformanceReview
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $employeeId
 * @property integer $reviewerId
 * @property string $creatorId
 * @property string $jobTitleCode
 * @property integer $subDivisionId
 * @property date $creationDate
 * @property date $periodFrom
 * @property date $periodTo
 * @property date $dueDate
 * @property integer $state
 * @property string $kpis
 * @property Employee $Employee
 * @property Employee $Reviewer
 * @property SystemUser $Creator
 * @property Doctrine_Collection $PerformanceReviewComment
 * @property JobTitle $JobTitle
 * @property Subunit $SubDivision
 * 
 * @method integer             getId()                       Returns the current record's "id" value
 * @method integer             getEmployeeId()               Returns the current record's "employeeId" value
 * @method integer             getReviewerId()               Returns the current record's "reviewerId" value
 * @method string              getCreatorId()                Returns the current record's "creatorId" value
 * @method string              getJobTitleCode()             Returns the current record's "jobTitleCode" value
 * @method integer             getSubDivisionId()            Returns the current record's "subDivisionId" value
 * @method date                getCreationDate()             Returns the current record's "creationDate" value
 * @method date                getPeriodFrom()               Returns the current record's "periodFrom" value
 * @method date                getPeriodTo()                 Returns the current record's "periodTo" value
 * @method date                getDueDate()                  Returns the current record's "dueDate" value
 * @method integer             getState()                    Returns the current record's "state" value
 * @method string              getKpis()                     Returns the current record's "kpis" value
 * @method Employee            getEmployee()                 Returns the current record's "Employee" value
 * @method Employee            getReviewer()                 Returns the current record's "Reviewer" value
 * @method SystemUser          getCreator()                  Returns the current record's "Creator" value
 * @method Doctrine_Collection getPerformanceReviewComment() Returns the current record's "PerformanceReviewComment" collection
 * @method JobTitle            getJobTitle()                 Returns the current record's "JobTitle" value
 * @method Subunit             getSubDivision()              Returns the current record's "SubDivision" value
 * @method PerformanceReview   setId()                       Sets the current record's "id" value
 * @method PerformanceReview   setEmployeeId()               Sets the current record's "employeeId" value
 * @method PerformanceReview   setReviewerId()               Sets the current record's "reviewerId" value
 * @method PerformanceReview   setCreatorId()                Sets the current record's "creatorId" value
 * @method PerformanceReview   setJobTitleCode()             Sets the current record's "jobTitleCode" value
 * @method PerformanceReview   setSubDivisionId()            Sets the current record's "subDivisionId" value
 * @method PerformanceReview   setCreationDate()             Sets the current record's "creationDate" value
 * @method PerformanceReview   setPeriodFrom()               Sets the current record's "periodFrom" value
 * @method PerformanceReview   setPeriodTo()                 Sets the current record's "periodTo" value
 * @method PerformanceReview   setDueDate()                  Sets the current record's "dueDate" value
 * @method PerformanceReview   setState()                    Sets the current record's "state" value
 * @method PerformanceReview   setKpis()                     Sets the current record's "kpis" value
 * @method PerformanceReview   setEmployee()                 Sets the current record's "Employee" value
 * @method PerformanceReview   setReviewer()                 Sets the current record's "Reviewer" value
 * @method PerformanceReview   setCreator()                  Sets the current record's "Creator" value
 * @method PerformanceReview   setPerformanceReviewComment() Sets the current record's "PerformanceReviewComment" collection
 * @method PerformanceReview   setJobTitle()                 Sets the current record's "JobTitle" value
 * @method PerformanceReview   setSubDivision()              Sets the current record's "SubDivision" value
 * 
 * @package    orangehrm
 * @subpackage model\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePerformanceReview extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_performance_review');
        $this->hasColumn('id as id', 'integer', 13, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 13,
             ));
        $this->hasColumn('employee_id as employeeId', 'integer', 13, array(
             'type' => 'integer',
             'length' => 13,
             ));
        $this->hasColumn('reviewer_id as reviewerId', 'integer', 13, array(
             'type' => 'integer',
             'length' => 13,
             ));
        $this->hasColumn('creator_id as creatorId', 'string', 36, array(
             'type' => 'string',
             'length' => 36,
             ));
        $this->hasColumn('job_title_code as jobTitleCode', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             ));
        $this->hasColumn('sub_division_id as subDivisionId', 'integer', 13, array(
             'type' => 'integer',
             'length' => 13,
             ));
        $this->hasColumn('creation_date as creationDate', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('period_from as periodFrom', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('period_to as periodTo', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('due_date as dueDate', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('state as state', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             ));
        $this->hasColumn('kpis as kpis', 'string', null, array(
             'type' => 'string',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Employee', array(
             'local' => 'employeeId',
             'foreign' => 'emp_number'));

        $this->hasOne('Employee as Reviewer', array(
             'local' => 'reviewerId',
             'foreign' => 'emp_number'));

        $this->hasOne('SystemUser as Creator', array(
             'local' => 'creatorId',
             'foreign' => 'id'));

        $this->hasMany('PerformanceReviewComment', array(
             'local' => 'id',
             'foreign' => 'pr_id'));

        $this->hasOne('JobTitle', array(
             'local' => 'jobTitleCode',
             'foreign' => 'id'));

        $this->hasOne('Subunit as SubDivision', array(
             'local' => 'subDivisionId',
             'foreign' => 'id'));
    }
}