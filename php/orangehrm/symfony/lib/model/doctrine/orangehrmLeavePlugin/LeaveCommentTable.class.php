<?php

/**
 * LeaveCommentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LeaveCommentTable extends PluginLeaveCommentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object LeaveCommentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('LeaveComment');
    }
}