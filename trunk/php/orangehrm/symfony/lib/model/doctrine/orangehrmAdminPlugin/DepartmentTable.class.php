<?php

/**
 * DepartmentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DepartmentTable extends PluginDepartmentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object DepartmentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Department');
    }
}