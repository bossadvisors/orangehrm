<?php

/**
 * BasePerformanceTrackerLog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $performance_track_id
 * @property string $log
 * @property string $comment
 * @property integer $status
 * @property integer $achievement
 * @property timestamp $added_date
 * @property timestamp $modified_date
 * @property integer $reviewer_id
 * @property integer $user_id
 * @property PerformanceTrack $PerformanceTrack
 * @property Employee $Employee
 * @property SystemUser $SystemUser
 * 
 * @method integer               getId()                   Returns the current record's "id" value
 * @method integer               getPerformanceTrackId()   Returns the current record's "performance_track_id" value
 * @method string                getLog()                  Returns the current record's "log" value
 * @method string                getComment()              Returns the current record's "comment" value
 * @method integer               getStatus()               Returns the current record's "status" value
 * @method integer               getAchievement()          Returns the current record's "achievement" value
 * @method timestamp             getAddedDate()            Returns the current record's "added_date" value
 * @method timestamp             getModifiedDate()         Returns the current record's "modified_date" value
 * @method integer               getReviewerId()           Returns the current record's "reviewer_id" value
 * @method integer               getUserId()               Returns the current record's "user_id" value
 * @method PerformanceTrack      getPerformanceTrack()     Returns the current record's "PerformanceTrack" value
 * @method Employee              getEmployee()             Returns the current record's "Employee" value
 * @method SystemUser            getSystemUser()           Returns the current record's "SystemUser" value
 * @method PerformanceTrackerLog setId()                   Sets the current record's "id" value
 * @method PerformanceTrackerLog setPerformanceTrackId()   Sets the current record's "performance_track_id" value
 * @method PerformanceTrackerLog setLog()                  Sets the current record's "log" value
 * @method PerformanceTrackerLog setComment()              Sets the current record's "comment" value
 * @method PerformanceTrackerLog setStatus()               Sets the current record's "status" value
 * @method PerformanceTrackerLog setAchievement()          Sets the current record's "achievement" value
 * @method PerformanceTrackerLog setAddedDate()            Sets the current record's "added_date" value
 * @method PerformanceTrackerLog setModifiedDate()         Sets the current record's "modified_date" value
 * @method PerformanceTrackerLog setReviewerId()           Sets the current record's "reviewer_id" value
 * @method PerformanceTrackerLog setUserId()               Sets the current record's "user_id" value
 * @method PerformanceTrackerLog setPerformanceTrack()     Sets the current record's "PerformanceTrack" value
 * @method PerformanceTrackerLog setEmployee()             Sets the current record's "Employee" value
 * @method PerformanceTrackerLog setSystemUser()           Sets the current record's "SystemUser" value
 * 
 * @package    orangehrm
 * @subpackage model\performancetracker\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePerformanceTrackerLog extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_performance_tracker_log');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('performance_track_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('log', 'string', 500, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 500,
             ));
        $this->hasColumn('comment', 'string', 3000, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 3000,
             ));
        $this->hasColumn('status', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 2,
             ));
        $this->hasColumn('achievement', 'integer', 2, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 2,
             ));
        $this->hasColumn('added_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('modified_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('reviewer_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 10, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 10,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('PerformanceTrack', array(
             'local' => 'performance_track_id',
             'foreign' => 'id'));

        $this->hasOne('Employee', array(
             'local' => 'reviewer_id',
             'foreign' => 'emp_number'));

        $this->hasOne('SystemUser', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}