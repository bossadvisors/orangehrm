<?php

/**
 * EmailNotificationTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EmailNotificationTable extends PluginEmailNotificationTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object EmailNotificationTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('EmailNotification');
    }
}