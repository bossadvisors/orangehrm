<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseSalaryCurrencyDetail extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_pr_salary_currency_detail');
        $this->hasColumn('sal_grd_code', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => '13',
             ));
        $this->hasColumn('currency_id', 'string', 6, array(
             'type' => 'string',
             'primary' => true,
             'length' => '6',
             ));
        $this->hasColumn('salcurr_dtl_minsalary as min_salary', 'float', 2147483647, array(
             'type' => 'float',
             'length' => '2147483647',
             ));
        $this->hasColumn('salcurr_dtl_stepsalary as salary_step', 'float', 2147483647, array(
             'type' => 'float',
             'length' => '2147483647',
             ));
        $this->hasColumn('salcurr_dtl_maxsalary as max_salary', 'float', 2147483647, array(
             'type' => 'float',
             'length' => '2147483647',
             ));
    }

    public function setUp()
    {
        $this->hasOne('CurrencyType', array(
             'local' => 'currency_id',
             'foreign' => 'currency_id'));

        $this->hasOne('SalaryGrade', array(
             'local' => 'sal_grd_code',
             'foreign' => 'sal_grd_code'));
    }
}