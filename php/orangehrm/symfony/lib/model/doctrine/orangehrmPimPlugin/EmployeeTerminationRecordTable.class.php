<?php

/**
 * EmployeeTerminationRecordTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EmployeeTerminationRecordTable extends PluginEmployeeTerminationRecordTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object EmployeeTerminationRecordTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('EmployeeTerminationRecord');
    }
}