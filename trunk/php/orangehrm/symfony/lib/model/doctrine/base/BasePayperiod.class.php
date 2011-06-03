<?php

/**
 * BasePayperiod
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $code
 * @property string $name
 * @property Doctrine_Collection $EmpUsTaxExemption
 * 
 * @method string              getCode()              Returns the current record's "code" value
 * @method string              getName()              Returns the current record's "name" value
 * @method Doctrine_Collection getEmpUsTaxExemption() Returns the current record's "EmpUsTaxExemption" collection
 * @method Payperiod           setCode()              Sets the current record's "code" value
 * @method Payperiod           setName()              Sets the current record's "name" value
 * @method Payperiod           setEmpUsTaxExemption() Sets the current record's "EmpUsTaxExemption" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePayperiod extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_payperiod');
        $this->hasColumn('payperiod_code as code', 'string', 13, array(
             'type' => 'string',
             'primary' => true,
             'length' => 13,
             ));
        $this->hasColumn('payperiod_name as name', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('EmpUsTaxExemption', array(
             'local' => 'payperiod_code',
             'foreign' => 'payperiod_code'));
    }
}