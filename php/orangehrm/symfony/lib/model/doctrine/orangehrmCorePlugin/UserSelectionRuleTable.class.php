<?php

/**
 * UserSelectionRuleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UserSelectionRuleTable extends PluginUserSelectionRuleTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object UserSelectionRuleTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('UserSelectionRule');
    }
}