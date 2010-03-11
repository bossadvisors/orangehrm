<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseEmpPassport extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_passport');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('ep_seqno as seqno', 'decimal', 2, array(
             'type' => 'decimal',
             'primary' => true,
             'length' => '2',
             ));
        $this->hasColumn('ep_passport_num as number', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'notnull' => true,
             'length' => '100',
             ));
        $this->hasColumn('ep_i9_status as i9_status', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => '100',
             ));
        $this->hasColumn('ep_passportissueddate as passport_issue_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('ep_passportexpiredate as passport_expire_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => '25',
             ));
        $this->hasColumn('ep_comments as comments', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('ep_passport_type_flg as type_flag', 'integer', 2, array(
             'type' => 'integer',
             'length' => '2',
             ));
        $this->hasColumn('ep_i9_review_date as i9_review_date', 'date', 25, array(
             'type' => 'date',
             'length' => '25',
             ));
        $this->hasColumn('cou_code as country', 'string', 6, array(
             'type' => 'string',
             'length' => '6',
             ));
    }

    public function setUp()
    {
        $this->hasOne('Employee', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));
    }
}