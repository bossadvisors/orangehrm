<?php

/**
 * JobTitleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class JobTitleTable extends PluginJobTitleTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object JobTitleTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('JobTitle');
    }
}