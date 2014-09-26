<?php

/**
 * BaseEmployeeAttachment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $emp_number
 * @property integer $attach_id
 * @property integer $size
 * @property string $description
 * @property string $filename
 * @property blob $attachment
 * @property string $file_type
 * @property string $screen
 * @property integer $attached_by
 * @property string $attached_by_name
 * @property timestamp $attached_time
 * @property Employee $Employee
 * 
 * @method integer            getEmpNumber()        Returns the current record's "emp_number" value
 * @method integer            getAttachId()         Returns the current record's "attach_id" value
 * @method integer            getSize()             Returns the current record's "size" value
 * @method string             getDescription()      Returns the current record's "description" value
 * @method string             getFilename()         Returns the current record's "filename" value
 * @method blob               getAttachment()       Returns the current record's "attachment" value
 * @method string             getFileType()         Returns the current record's "file_type" value
 * @method string             getScreen()           Returns the current record's "screen" value
 * @method integer            getAttachedBy()       Returns the current record's "attached_by" value
 * @method string             getAttachedByName()   Returns the current record's "attached_by_name" value
 * @method timestamp          getAttachedTime()     Returns the current record's "attached_time" value
 * @method Employee           getEmployee()         Returns the current record's "Employee" value
 * @method EmployeeAttachment setEmpNumber()        Sets the current record's "emp_number" value
 * @method EmployeeAttachment setAttachId()         Sets the current record's "attach_id" value
 * @method EmployeeAttachment setSize()             Sets the current record's "size" value
 * @method EmployeeAttachment setDescription()      Sets the current record's "description" value
 * @method EmployeeAttachment setFilename()         Sets the current record's "filename" value
 * @method EmployeeAttachment setAttachment()       Sets the current record's "attachment" value
 * @method EmployeeAttachment setFileType()         Sets the current record's "file_type" value
 * @method EmployeeAttachment setScreen()           Sets the current record's "screen" value
 * @method EmployeeAttachment setAttachedBy()       Sets the current record's "attached_by" value
 * @method EmployeeAttachment setAttachedByName()   Sets the current record's "attached_by_name" value
 * @method EmployeeAttachment setAttachedTime()     Sets the current record's "attached_time" value
 * @method EmployeeAttachment setEmployee()         Sets the current record's "Employee" value
 * 
 * @package    orangehrm
 * @subpackage model\pim\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployeeAttachment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_attachment');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('eattach_id as attach_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('eattach_size as size', 'integer', 4, array(
             'type' => 'integer',
             'default' => '0',
             'length' => 4,
             ));
        $this->hasColumn('eattach_desc as description', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('eattach_filename as filename', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('eattach_attachment as attachment', 'blob', 2147483647, array(
             'type' => 'blob',
             'length' => 2147483647,
             ));
        $this->hasColumn('eattach_type as file_type', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('screen', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('attached_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('attached_by_name', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             ));
        $this->hasColumn('attached_time', 'timestamp', null, array(
             'type' => 'timestamp',
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