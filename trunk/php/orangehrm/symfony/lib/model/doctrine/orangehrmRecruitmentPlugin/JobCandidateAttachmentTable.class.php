<?php

/**
 * JobCandidateAttachmentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class JobCandidateAttachmentTable extends PluginJobCandidateAttachmentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object JobCandidateAttachmentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('JobCandidateAttachment');
    }
}