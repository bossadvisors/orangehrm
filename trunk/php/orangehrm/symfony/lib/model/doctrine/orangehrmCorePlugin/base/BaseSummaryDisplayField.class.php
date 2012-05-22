<?php

/**
 * BaseSummaryDisplayField
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $summaryDisplayFieldId
 * @property string $function
 * @property string $label
 * @property string $fieldAlias
 * @property string $isSortable
 * @property string $sortOrder
 * @property string $sortField
 * @property string $elementType
 * @property string $elementProperty
 * @property string $width
 * @property string $isExportable
 * @property string $textAlignmentStyle
 * @property boolean $isValueList
 * @property integer $display_field_group_id
 * @property string $defaultValue
 * @property Doctrine_Collection $SelectedGroupField
 * 
 * @method integer             getSummaryDisplayFieldId()  Returns the current record's "summaryDisplayFieldId" value
 * @method string              getFunction()               Returns the current record's "function" value
 * @method string              getLabel()                  Returns the current record's "label" value
 * @method string              getFieldAlias()             Returns the current record's "fieldAlias" value
 * @method string              getIsSortable()             Returns the current record's "isSortable" value
 * @method string              getSortOrder()              Returns the current record's "sortOrder" value
 * @method string              getSortField()              Returns the current record's "sortField" value
 * @method string              getElementType()            Returns the current record's "elementType" value
 * @method string              getElementProperty()        Returns the current record's "elementProperty" value
 * @method string              getWidth()                  Returns the current record's "width" value
 * @method string              getIsExportable()           Returns the current record's "isExportable" value
 * @method string              getTextAlignmentStyle()     Returns the current record's "textAlignmentStyle" value
 * @method boolean             getIsValueList()            Returns the current record's "isValueList" value
 * @method integer             getDisplayFieldGroupId()    Returns the current record's "display_field_group_id" value
 * @method string              getDefaultValue()           Returns the current record's "defaultValue" value
 * @method Doctrine_Collection getSelectedGroupField()     Returns the current record's "SelectedGroupField" collection
 * @method SummaryDisplayField setSummaryDisplayFieldId()  Sets the current record's "summaryDisplayFieldId" value
 * @method SummaryDisplayField setFunction()               Sets the current record's "function" value
 * @method SummaryDisplayField setLabel()                  Sets the current record's "label" value
 * @method SummaryDisplayField setFieldAlias()             Sets the current record's "fieldAlias" value
 * @method SummaryDisplayField setIsSortable()             Sets the current record's "isSortable" value
 * @method SummaryDisplayField setSortOrder()              Sets the current record's "sortOrder" value
 * @method SummaryDisplayField setSortField()              Sets the current record's "sortField" value
 * @method SummaryDisplayField setElementType()            Sets the current record's "elementType" value
 * @method SummaryDisplayField setElementProperty()        Sets the current record's "elementProperty" value
 * @method SummaryDisplayField setWidth()                  Sets the current record's "width" value
 * @method SummaryDisplayField setIsExportable()           Sets the current record's "isExportable" value
 * @method SummaryDisplayField setTextAlignmentStyle()     Sets the current record's "textAlignmentStyle" value
 * @method SummaryDisplayField setIsValueList()            Sets the current record's "isValueList" value
 * @method SummaryDisplayField setDisplayFieldGroupId()    Sets the current record's "display_field_group_id" value
 * @method SummaryDisplayField setDefaultValue()           Sets the current record's "defaultValue" value
 * @method SummaryDisplayField setSelectedGroupField()     Sets the current record's "SelectedGroupField" collection
 * 
 * @package    orangehrm
 * @subpackage model\core\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSummaryDisplayField extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_summary_display_field');
        $this->hasColumn('summary_display_field_id as summaryDisplayFieldId', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('function', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('label', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('field_alias as fieldAlias', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('is_sortable as isSortable', 'string', 10, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 10,
             ));
        $this->hasColumn('sort_order as sortOrder', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('sort_field as sortField', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('element_type as elementType', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('element_property as elementProperty', 'string', 1000, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 1000,
             ));
        $this->hasColumn('width', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('is_exportable as isExportable', 'string', 10, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 10,
             ));
        $this->hasColumn('text_alignment_style as textAlignmentStyle', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('is_value_list as isValueList', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));
        $this->hasColumn('display_field_group_id', 'integer', null, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => false,
             ));
        $this->hasColumn('default_value as defaultValue', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('SelectedGroupField', array(
             'local' => 'summaryDisplayFieldId',
             'foreign' => 'summary_display_field_id'));
    }
}