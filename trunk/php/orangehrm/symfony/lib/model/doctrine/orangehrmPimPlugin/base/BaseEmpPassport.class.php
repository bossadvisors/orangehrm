<?php

/**
 * BaseEmpPassport
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $emp_number
 * @property decimal $seqno
 * @property string $number
 * @property string $i9_status
 * @property timestamp $passport_issue_date
 * @property timestamp $passport_expire_date
 * @property string $comments
 * @property integer $type_flag
 * @property date $i9_review_date
 * @property string $country
 * @property Employee $Employee
 * 
 * @method integer     getEmpNumber()            Returns the current record's "emp_number" value
 * @method decimal     getSeqno()                Returns the current record's "seqno" value
 * @method string      getNumber()               Returns the current record's "number" value
 * @method string      getI9Status()             Returns the current record's "i9_status" value
 * @method timestamp   getPassportIssueDate()    Returns the current record's "passport_issue_date" value
 * @method timestamp   getPassportExpireDate()   Returns the current record's "passport_expire_date" value
 * @method string      getComments()             Returns the current record's "comments" value
 * @method integer     getTypeFlag()             Returns the current record's "type_flag" value
 * @method date        getI9ReviewDate()         Returns the current record's "i9_review_date" value
 * @method string      getCountry()              Returns the current record's "country" value
 * @method Employee    getEmployee()             Returns the current record's "Employee" value
 * @method EmpPassport setEmpNumber()            Sets the current record's "emp_number" value
 * @method EmpPassport setSeqno()                Sets the current record's "seqno" value
 * @method EmpPassport setNumber()               Sets the current record's "number" value
 * @method EmpPassport setI9Status()             Sets the current record's "i9_status" value
 * @method EmpPassport setPassportIssueDate()    Sets the current record's "passport_issue_date" value
 * @method EmpPassport setPassportExpireDate()   Sets the current record's "passport_expire_date" value
 * @method EmpPassport setComments()             Sets the current record's "comments" value
 * @method EmpPassport setTypeFlag()             Sets the current record's "type_flag" value
 * @method EmpPassport setI9ReviewDate()         Sets the current record's "i9_review_date" value
 * @method EmpPassport setCountry()              Sets the current record's "country" value
 * @method EmpPassport setEmployee()             Sets the current record's "Employee" value
 * 
 * @package    orangehrm
 * @subpackage model\pim\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmpPassport extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_passport');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('ep_seqno as seqno', 'decimal', 2, array(
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
        $this->hasColumn('ep_i9_status as i9_status', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('ep_passportissueddate as passport_issue_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('ep_passportexpiredate as passport_expire_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('ep_comments as comments', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('ep_passport_type_flg as type_flag', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             ));
        $this->hasColumn('ep_i9_review_date as i9_review_date', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('cou_code as country', 'string', 6, array(
             'type' => 'string',
             'length' => 6,
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