<?php

/**
 * BaseEmailSubscriber
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $notificationId
 * @property string $name
 * @property string $email
 * @property EmailNotification $EmailNotification
 * 
 * @method integer           getId()                Returns the current record's "id" value
 * @method integer           getNotificationId()    Returns the current record's "notificationId" value
 * @method string            getName()              Returns the current record's "name" value
 * @method string            getEmail()             Returns the current record's "email" value
 * @method EmailNotification getEmailNotification() Returns the current record's "EmailNotification" value
 * @method EmailSubscriber   setId()                Sets the current record's "id" value
 * @method EmailSubscriber   setNotificationId()    Sets the current record's "notificationId" value
 * @method EmailSubscriber   setName()              Sets the current record's "name" value
 * @method EmailSubscriber   setEmail()             Sets the current record's "email" value
 * @method EmailSubscriber   setEmailNotification() Sets the current record's "EmailNotification" value
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmailSubscriber extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_email_subscriber');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('notification_id as notificationId', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('EmailNotification', array(
             'local' => 'notificationId',
             'foreign' => 'id'));
    }
}