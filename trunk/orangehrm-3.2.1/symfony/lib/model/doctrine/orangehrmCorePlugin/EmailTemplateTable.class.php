<?php

/**
 * EmailTemplateTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EmailTemplateTable extends PluginEmailTemplateTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object EmailTemplateTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('EmailTemplate');
    }
}