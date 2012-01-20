<?php

/**
 * BaseEmployeeSkill
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $emp_number
 * @property integer $skillId
 * @property decimal $years_of_exp
 * @property string $comments
 * @property Employee $Employee
 * @property Skill $Skill
 * 
 * @method integer       getEmpNumber()    Returns the current record's "emp_number" value
 * @method integer       getSkillId()      Returns the current record's "skillId" value
 * @method decimal       getYearsOfExp()   Returns the current record's "years_of_exp" value
 * @method string        getComments()     Returns the current record's "comments" value
 * @method Employee      getEmployee()     Returns the current record's "Employee" value
 * @method Skill         getSkill()        Returns the current record's "Skill" value
 * @method EmployeeSkill setEmpNumber()    Sets the current record's "emp_number" value
 * @method EmployeeSkill setSkillId()      Sets the current record's "skillId" value
 * @method EmployeeSkill setYearsOfExp()   Sets the current record's "years_of_exp" value
 * @method EmployeeSkill setComments()     Sets the current record's "comments" value
 * @method EmployeeSkill setEmployee()     Sets the current record's "Employee" value
 * @method EmployeeSkill setSkill()        Sets the current record's "Skill" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployeeSkill extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_skill');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('skill_id as skillId', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('years_of_exp', 'decimal', 2, array(
             'type' => 'decimal',
             'default' => '0',
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('comments', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'notnull' => true,
             'length' => 100,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Employee', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasOne('Skill', array(
             'local' => 'skillId',
             'foreign' => 'id'));
    }
}