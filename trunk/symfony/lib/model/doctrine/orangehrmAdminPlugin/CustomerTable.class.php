<?php

/**
 * CustomerTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CustomerTable extends PluginCustomerTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object CustomerTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Customer');
    }
}