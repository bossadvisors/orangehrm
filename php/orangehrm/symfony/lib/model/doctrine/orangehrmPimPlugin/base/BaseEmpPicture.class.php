<?php

/**
 * BaseEmpPicture
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $emp_number
 * @property blob $picture
 * @property string $filename
 * @property string $file_type
 * @property string $size
 * @property Employee $Employee
 * 
 * @method integer    getEmpNumber()  Returns the current record's "emp_number" value
 * @method blob       getPicture()    Returns the current record's "picture" value
 * @method string     getFilename()   Returns the current record's "filename" value
 * @method string     getFileType()   Returns the current record's "file_type" value
 * @method string     getSize()       Returns the current record's "size" value
 * @method Employee   getEmployee()   Returns the current record's "Employee" value
 * @method EmpPicture setEmpNumber()  Sets the current record's "emp_number" value
 * @method EmpPicture setPicture()    Sets the current record's "picture" value
 * @method EmpPicture setFilename()   Sets the current record's "filename" value
 * @method EmpPicture setFileType()   Sets the current record's "file_type" value
 * @method EmpPicture setSize()       Sets the current record's "size" value
 * @method EmpPicture setEmployee()   Sets the current record's "Employee" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmpPicture extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_picture');
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('epic_picture as picture', 'blob', 2147483647, array(
             'type' => 'blob',
             'length' => 2147483647,
             ));
        $this->hasColumn('epic_filename as filename', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('epic_type as file_type', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('epic_file_size as size', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
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