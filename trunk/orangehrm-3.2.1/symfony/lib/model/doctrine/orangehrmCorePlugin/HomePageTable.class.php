<?php

/**
 * HomePageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class HomePageTable extends PluginHomePageTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object HomePageTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('HomePage');
    }
}