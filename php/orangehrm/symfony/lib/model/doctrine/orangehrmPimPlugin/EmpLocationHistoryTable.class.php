<?php

/**
 * EmpLocationHistoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EmpLocationHistoryTable extends PluginEmpLocationHistoryTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object EmpLocationHistoryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('EmpLocationHistory');
    }
}