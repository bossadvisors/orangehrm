<?php

/**
 * BaseCompositeDisplayField
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $compositeDisplayFieldId
 * @property string $name
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
 * @property Doctrine_Collection $SelectedCompositeDisplayField
 * 
 * @method integer               getCompositeDisplayFieldId()       Returns the current record's "compositeDisplayFieldId" value
 * @method string                getName()                          Returns the current record's "name" value
 * @method string                getLabel()                         Returns the current record's "label" value
 * @method string                getFieldAlias()                    Returns the current record's "fieldAlias" value
 * @method string                getIsSortable()                    Returns the current record's "isSortable" value
 * @method string                getSortOrder()                     Returns the current record's "sortOrder" value
 * @method string                getSortField()                     Returns the current record's "sortField" value
 * @method string                getElementType()                   Returns the current record's "elementType" value
 * @method string                getElementProperty()               Returns the current record's "elementProperty" value
 * @method string                getWidth()                         Returns the current record's "width" value
 * @method string                getIsExportable()                  Returns the current record's "isExportable" value
 * @method string                getTextAlignmentStyle()            Returns the current record's "textAlignmentStyle" value
 * @method Doctrine_Collection   getSelectedCompositeDisplayField() Returns the current record's "SelectedCompositeDisplayField" collection
 * @method CompositeDisplayField setCompositeDisplayFieldId()       Sets the current record's "compositeDisplayFieldId" value
 * @method CompositeDisplayField setName()                          Sets the current record's "name" value
 * @method CompositeDisplayField setLabel()                         Sets the current record's "label" value
 * @method CompositeDisplayField setFieldAlias()                    Sets the current record's "fieldAlias" value
 * @method CompositeDisplayField setIsSortable()                    Sets the current record's "isSortable" value
 * @method CompositeDisplayField setSortOrder()                     Sets the current record's "sortOrder" value
 * @method CompositeDisplayField setSortField()                     Sets the current record's "sortField" value
 * @method CompositeDisplayField setElementType()                   Sets the current record's "elementType" value
 * @method CompositeDisplayField setElementProperty()               Sets the current record's "elementProperty" value
 * @method CompositeDisplayField setWidth()                         Sets the current record's "width" value
 * @method CompositeDisplayField setIsExportable()                  Sets the current record's "isExportable" value
 * @method CompositeDisplayField setTextAlignmentStyle()            Sets the current record's "textAlignmentStyle" value
 * @method CompositeDisplayField setSelectedCompositeDisplayField() Sets the current record's "SelectedCompositeDisplayField" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCompositeDisplayField extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_composite_display_field');
        $this->hasColumn('composite_display_field_id as compositeDisplayFieldId', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('name', 'string', 1000, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 1000,
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('SelectedCompositeDisplayField', array(
             'local' => 'compositeDisplayFieldId',
             'foreign' => 'composite_display_field_id'));
    }
}