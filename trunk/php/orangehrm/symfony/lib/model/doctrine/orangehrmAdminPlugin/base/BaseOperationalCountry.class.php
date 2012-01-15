<?php

/**
 * BaseOperationalCountry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $country_code
 * @property Country $Country
 * @property Doctrine_Collection $LeaveType
 * @property Doctrine_Collection $WorkWeek
 * 
 * @method integer             getId()           Returns the current record's "id" value
 * @method string              getCountryCode()  Returns the current record's "country_code" value
 * @method Country             getCountry()      Returns the current record's "Country" value
 * @method Doctrine_Collection getLeaveType()    Returns the current record's "LeaveType" collection
 * @method Doctrine_Collection getWorkWeek()     Returns the current record's "WorkWeek" collection
 * @method OperationalCountry  setId()           Sets the current record's "id" value
 * @method OperationalCountry  setCountryCode()  Sets the current record's "country_code" value
 * @method OperationalCountry  setCountry()      Sets the current record's "Country" value
 * @method OperationalCountry  setLeaveType()    Sets the current record's "LeaveType" collection
 * @method OperationalCountry  setWorkWeek()     Sets the current record's "WorkWeek" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOperationalCountry extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_operational_country');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'autoincrement' => true,
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('country_code', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Country', array(
             'local' => 'country_code',
             'foreign' => 'cou_code'));

        $this->hasMany('LeaveType', array(
             'local' => 'id',
             'foreign' => 'operational_country_id'));

        $this->hasMany('WorkWeek', array(
             'local' => 'id',
             'foreign' => 'operational_country_id'));
    }
}