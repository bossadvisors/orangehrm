<?php

/**
 * EmailProcessorTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EmailProcessorTable extends PluginEmailProcessorTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object EmailProcessorTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('EmailProcessor');
    }
}