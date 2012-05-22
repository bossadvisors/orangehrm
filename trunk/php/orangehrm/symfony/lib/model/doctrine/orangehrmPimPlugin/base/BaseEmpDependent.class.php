<?php

/**
 * BaseEmpDependent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $emp_number
 * @property decimal $seqno
 * @property string $name
 * @property enum $relationship_type
 * @property string $relationship
 * @property date $date_of_birth
 * @property Employee $Employee
 * 
 * @method integer      getEmpNumber()         Returns the current record's "emp_number" value
 * @method decimal      getSeqno()             Returns the current record's "seqno" value
 * @method string       getName()              Returns the current record's "name" value
 * @method enum         getRelationshipType()  Returns the current record's "relationship_type" value
 * @method string       getRelationship()      Returns the current record's "relationship" value
 * @method date         getDateOfBirth()       Returns the current record's "date_of_birth" value
 * @method Employee     getEmployee()          Returns the current record's "Employee" value
 * @method EmpDependent setEmpNumber()         Sets the current record's "emp_number" value
 * @method EmpDependent setSeqno()             Sets the current record's "seqno" value
 * @method EmpDependent setName()              Sets the current record's "name" value
 * @method EmpDependent setRelationshipType()  Sets the current record's "relationship_type" value
 * @method EmpDependent setRelationship()      Sets the current record's "relationship" value
 * @method EmpDependent setDateOfBirth()       Sets the current record's "date_of_birth" value
 * @method EmpDependent setEmployee()          Sets the current record's "Employee" value
 * 
 * @package    orangehrm
 * @subpackage model\pim\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmpDependent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_dependents');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('ed_seqno as seqno', 'decimal', 2, array(
             'type' => 'decimal',
             'primary' => true,
             'length' => 2,
             ));
        $this->hasColumn('ed_name as name', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('ed_relationship_type as relationship_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'child',
              1 => 'other',
             ),
             ));
        $this->hasColumn('ed_relationship as relationship', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('ed_date_of_birth as date_of_birth', 'date', 25, array(
             'type' => 'date',
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