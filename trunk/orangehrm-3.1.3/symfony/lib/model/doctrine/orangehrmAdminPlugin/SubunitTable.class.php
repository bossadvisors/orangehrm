<?php

/**
 * SubunitTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SubunitTable extends PluginSubunitTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object SubunitTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Subunit');
    }
}