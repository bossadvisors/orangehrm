<?php

/**
 * BaseFilterField
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $filterFieldId
 * @property integer $reportGroupId
 * @property string $name
 * @property clob $whereClausePart
 * @property string $filterFieldWidget
 * @property integer $conditionNo
 * @property string $type
 * @property string $required
 * @property ReportGroup $ReportGroup
 * @property Doctrine_Collection $SelectedFilterField
 * 
 * @method integer             getFilterFieldId()       Returns the current record's "filterFieldId" value
 * @method integer             getReportGroupId()       Returns the current record's "reportGroupId" value
 * @method string              getName()                Returns the current record's "name" value
 * @method clob                getWhereClausePart()     Returns the current record's "whereClausePart" value
 * @method string              getFilterFieldWidget()   Returns the current record's "filterFieldWidget" value
 * @method integer             getConditionNo()         Returns the current record's "conditionNo" value
 * @method string              getType()                Returns the current record's "type" value
 * @method string              getRequired()            Returns the current record's "required" value
 * @method ReportGroup         getReportGroup()         Returns the current record's "ReportGroup" value
 * @method Doctrine_Collection getSelectedFilterField() Returns the current record's "SelectedFilterField" collection
 * @method FilterField         setFilterFieldId()       Sets the current record's "filterFieldId" value
 * @method FilterField         setReportGroupId()       Sets the current record's "reportGroupId" value
 * @method FilterField         setName()                Sets the current record's "name" value
 * @method FilterField         setWhereClausePart()     Sets the current record's "whereClausePart" value
 * @method FilterField         setFilterFieldWidget()   Sets the current record's "filterFieldWidget" value
 * @method FilterField         setConditionNo()         Sets the current record's "conditionNo" value
 * @method FilterField         setType()                Sets the current record's "type" value
 * @method FilterField         setRequired()            Sets the current record's "required" value
 * @method FilterField         setReportGroup()         Sets the current record's "ReportGroup" value
 * @method FilterField         setSelectedFilterField() Sets the current record's "SelectedFilterField" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFilterField extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_filter_field');
        $this->hasColumn('filter_field_id as filterFieldId', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('report_group_id as reportGroupId', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('where_clause_part as whereClausePart', 'clob', null, array(
             'type' => 'clob',
             'notnull' => true,
             ));
        $this->hasColumn('filter_field_widget as filterFieldWidget', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('condition_no as conditionNo', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('type', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('required', 'string', 10, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 10,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ReportGroup', array(
             'local' => 'report_group_id',
             'foreign' => 'reportGroupId'));

        $this->hasMany('SelectedFilterField', array(
             'local' => 'filterFieldId',
             'foreign' => 'filter_field_id'));
    }
}