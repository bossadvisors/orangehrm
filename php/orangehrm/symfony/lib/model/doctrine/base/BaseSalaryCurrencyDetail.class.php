<?php

/**
 * BaseSalaryCurrencyDetail
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $sal_grd_code
 * @property string $currency_id
 * @property float $min_salary
 * @property float $salary_step
 * @property float $max_salary
 * @property CurrencyType $CurrencyType
 * @property SalaryGrade $SalaryGrade
 * 
 * @method string               getSalGrdCode()   Returns the current record's "sal_grd_code" value
 * @method string               getCurrencyId()   Returns the current record's "currency_id" value
 * @method float                getMinSalary()    Returns the current record's "min_salary" value
 * @method float                getSalaryStep()   Returns the current record's "salary_step" value
 * @method float                getMaxSalary()    Returns the current record's "max_salary" value
 * @method CurrencyType         getCurrencyType() Returns the current record's "CurrencyType" value
 * @method SalaryGrade          getSalaryGrade()  Returns the current record's "SalaryGrade" value
 * @method SalaryCurrencyDetail setSalGrdCode()   Sets the current record's "sal_grd_code" value
 * @method SalaryCurrencyDetail setCurrencyId()   Sets the current record's "currency_id" value
 * @method SalaryCurrencyDetail setMinSalary()    Sets the current record's "min_salary" value
 * @method SalaryCurrencyDetail setSalaryStep()   Sets the current record's "salary_step" value
 * @method SalaryCurrencyDetail setMaxSalary()    Sets the current record's "max_salary" value
 * @method SalaryCurrencyDetail setCurrencyType() Sets the current record's "CurrencyType" value
 * @method SalaryCurrencyDetail setSalaryGrade()  Sets the current record's "SalaryGrade" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSalaryCurrencyDetail extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_pr_salary_currency_detail');
        $this->hasColumn('sal_grd_code', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => 13,
             ));
        $this->hasColumn('currency_id', 'string', 6, array(
             'type' => 'string',
             'primary' => true,
             'length' => 6,
             ));
        $this->hasColumn('salcurr_dtl_minsalary as min_salary', 'float', 2147483647, array(
             'type' => 'float',
             'length' => 2147483647,
             ));
        $this->hasColumn('salcurr_dtl_stepsalary as salary_step', 'float', 2147483647, array(
             'type' => 'float',
             'length' => 2147483647,
             ));
        $this->hasColumn('salcurr_dtl_maxsalary as max_salary', 'float', 2147483647, array(
             'type' => 'float',
             'length' => 2147483647,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CurrencyType', array(
             'local' => 'currency_id',
             'foreign' => 'currency_id'));

        $this->hasOne('SalaryGrade', array(
             'local' => 'sal_grd_code',
             'foreign' => 'sal_grd_code'));
    }
}