<?php

/**
 * BaseUsers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $id
 * @property string $user_name
 * @property string $is_admin
 * @property string $receive_notification
 * @property integer $deleted
 * @property string $user_password
 * @property string $first_name
 * @property string $last_name
 * @property integer $emp_number
 * @property string $user_hash
 * @property string $description
 * @property timestamp $date_entered
 * @property timestamp $date_modified
 * @property string $modified_user_id
 * @property string $created_by
 * @property string $title
 * @property string $department
 * @property string $phone_home
 * @property string $phone_mobile
 * @property string $phone_work
 * @property string $phone_other
 * @property string $phone_fax
 * @property string $email1
 * @property string $email2
 * @property string $status
 * @property string $address_street
 * @property string $address_city
 * @property string $address_state
 * @property string $address_country
 * @property string $address_postalcode
 * @property string $user_preferences
 * @property string $employee_status
 * @property string $userg_id
 * @property Users $modifiedUser
 * @property Doctrine_Collection $createdUser
 * @property UserGroup $userGroup
 * @property Employee $employee
 * @property Doctrine_Collection $MailNotification
 * @property Doctrine_Collection $TimesheetActionLog
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $PerformanceReview
 * 
 * @method string              getId()                   Returns the current record's "id" value
 * @method string              getUserName()             Returns the current record's "user_name" value
 * @method string              getIsAdmin()              Returns the current record's "is_admin" value
 * @method string              getReceiveNotification()  Returns the current record's "receive_notification" value
 * @method integer             getDeleted()              Returns the current record's "deleted" value
 * @method string              getUserPassword()         Returns the current record's "user_password" value
 * @method string              getFirstName()            Returns the current record's "first_name" value
 * @method string              getLastName()             Returns the current record's "last_name" value
 * @method integer             getEmpNumber()            Returns the current record's "emp_number" value
 * @method string              getUserHash()             Returns the current record's "user_hash" value
 * @method string              getDescription()          Returns the current record's "description" value
 * @method timestamp           getDateEntered()          Returns the current record's "date_entered" value
 * @method timestamp           getDateModified()         Returns the current record's "date_modified" value
 * @method string              getModifiedUserId()       Returns the current record's "modified_user_id" value
 * @method string              getCreatedBy()            Returns the current record's "created_by" value
 * @method string              getTitle()                Returns the current record's "title" value
 * @method string              getDepartment()           Returns the current record's "department" value
 * @method string              getPhoneHome()            Returns the current record's "phone_home" value
 * @method string              getPhoneMobile()          Returns the current record's "phone_mobile" value
 * @method string              getPhoneWork()            Returns the current record's "phone_work" value
 * @method string              getPhoneOther()           Returns the current record's "phone_other" value
 * @method string              getPhoneFax()             Returns the current record's "phone_fax" value
 * @method string              getEmail1()               Returns the current record's "email1" value
 * @method string              getEmail2()               Returns the current record's "email2" value
 * @method string              getStatus()               Returns the current record's "status" value
 * @method string              getAddressStreet()        Returns the current record's "address_street" value
 * @method string              getAddressCity()          Returns the current record's "address_city" value
 * @method string              getAddressState()         Returns the current record's "address_state" value
 * @method string              getAddressCountry()       Returns the current record's "address_country" value
 * @method string              getAddressPostalcode()    Returns the current record's "address_postalcode" value
 * @method string              getUserPreferences()      Returns the current record's "user_preferences" value
 * @method string              getEmployeeStatus()       Returns the current record's "employee_status" value
 * @method string              getUsergId()              Returns the current record's "userg_id" value
 * @method Users               getModifiedUser()         Returns the current record's "modifiedUser" value
 * @method Doctrine_Collection getCreatedUser()          Returns the current record's "createdUser" collection
 * @method UserGroup           getUserGroup()            Returns the current record's "userGroup" value
 * @method Employee            getEmployee()             Returns the current record's "employee" value
 * @method Doctrine_Collection getMailNotification()     Returns the current record's "MailNotification" collection
 * @method Doctrine_Collection getTimesheetActionLog()   Returns the current record's "TimesheetActionLog" collection
 * @method Doctrine_Collection getUsers()                Returns the current record's "Users" collection
 * @method Doctrine_Collection getPerformanceReview()    Returns the current record's "PerformanceReview" collection
 * @method Users               setId()                   Sets the current record's "id" value
 * @method Users               setUserName()             Sets the current record's "user_name" value
 * @method Users               setIsAdmin()              Sets the current record's "is_admin" value
 * @method Users               setReceiveNotification()  Sets the current record's "receive_notification" value
 * @method Users               setDeleted()              Sets the current record's "deleted" value
 * @method Users               setUserPassword()         Sets the current record's "user_password" value
 * @method Users               setFirstName()            Sets the current record's "first_name" value
 * @method Users               setLastName()             Sets the current record's "last_name" value
 * @method Users               setEmpNumber()            Sets the current record's "emp_number" value
 * @method Users               setUserHash()             Sets the current record's "user_hash" value
 * @method Users               setDescription()          Sets the current record's "description" value
 * @method Users               setDateEntered()          Sets the current record's "date_entered" value
 * @method Users               setDateModified()         Sets the current record's "date_modified" value
 * @method Users               setModifiedUserId()       Sets the current record's "modified_user_id" value
 * @method Users               setCreatedBy()            Sets the current record's "created_by" value
 * @method Users               setTitle()                Sets the current record's "title" value
 * @method Users               setDepartment()           Sets the current record's "department" value
 * @method Users               setPhoneHome()            Sets the current record's "phone_home" value
 * @method Users               setPhoneMobile()          Sets the current record's "phone_mobile" value
 * @method Users               setPhoneWork()            Sets the current record's "phone_work" value
 * @method Users               setPhoneOther()           Sets the current record's "phone_other" value
 * @method Users               setPhoneFax()             Sets the current record's "phone_fax" value
 * @method Users               setEmail1()               Sets the current record's "email1" value
 * @method Users               setEmail2()               Sets the current record's "email2" value
 * @method Users               setStatus()               Sets the current record's "status" value
 * @method Users               setAddressStreet()        Sets the current record's "address_street" value
 * @method Users               setAddressCity()          Sets the current record's "address_city" value
 * @method Users               setAddressState()         Sets the current record's "address_state" value
 * @method Users               setAddressCountry()       Sets the current record's "address_country" value
 * @method Users               setAddressPostalcode()    Sets the current record's "address_postalcode" value
 * @method Users               setUserPreferences()      Sets the current record's "user_preferences" value
 * @method Users               setEmployeeStatus()       Sets the current record's "employee_status" value
 * @method Users               setUsergId()              Sets the current record's "userg_id" value
 * @method Users               setModifiedUser()         Sets the current record's "modifiedUser" value
 * @method Users               setCreatedUser()          Sets the current record's "createdUser" collection
 * @method Users               setUserGroup()            Sets the current record's "userGroup" value
 * @method Users               setEmployee()             Sets the current record's "employee" value
 * @method Users               setMailNotification()     Sets the current record's "MailNotification" collection
 * @method Users               setTimesheetActionLog()   Sets the current record's "TimesheetActionLog" collection
 * @method Users               setUsers()                Sets the current record's "Users" collection
 * @method Users               setPerformanceReview()    Sets the current record's "PerformanceReview" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUsers extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_users');
        $this->hasColumn('id', 'string', 36, array(
             'type' => 'string',
             'primary' => true,
             'length' => 36,
             ));
        $this->hasColumn('user_name', 'string', 20, array(
             'type' => 'string',
             'default' => '',
             'length' => 20,
             ));
        $this->hasColumn('is_admin', 'string', 3, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 3,
             ));
        $this->hasColumn('receive_notification', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 1,
             ));
        $this->hasColumn('deleted', 'integer', 1, array(
             'type' => 'integer',
             'default' => '0',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('user_password', 'string', 32, array(
             'type' => 'string',
             'length' => 32,
             ));
        $this->hasColumn('first_name', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('last_name', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('emp_number', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('user_hash', 'string', 32, array(
             'type' => 'string',
             'length' => 32,
             ));
        $this->hasColumn('description', 'string', 2147483647, array(
             'type' => 'string',
             'length' => 2147483647,
             ));
        $this->hasColumn('date_entered', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
        $this->hasColumn('date_modified', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
        $this->hasColumn('modified_user_id', 'string', 36, array(
             'type' => 'string',
             'length' => 36,
             ));
        $this->hasColumn('created_by', 'string', 36, array(
             'type' => 'string',
             'length' => 36,
             ));
        $this->hasColumn('title', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('department', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('phone_home', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('phone_mobile', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('phone_work', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('phone_other', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('phone_fax', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             ));
        $this->hasColumn('email1', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('email2', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('status', 'string', 25, array(
             'type' => 'string',
             'length' => 25,
             ));
        $this->hasColumn('address_street', 'string', 150, array(
             'type' => 'string',
             'length' => 150,
             ));
        $this->hasColumn('address_city', 'string', 150, array(
             'type' => 'string',
             'length' => 150,
             ));
        $this->hasColumn('address_state', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('address_country', 'string', 25, array(
             'type' => 'string',
             'length' => 25,
             ));
        $this->hasColumn('address_postalcode', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             ));
        $this->hasColumn('user_preferences', 'string', 2147483647, array(
             'type' => 'string',
             'length' => 2147483647,
             ));
        $this->hasColumn('employee_status', 'string', 25, array(
             'type' => 'string',
             'length' => 25,
             ));
        $this->hasColumn('userg_id', 'string', 36, array(
             'type' => 'string',
             'length' => 36,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Users as modifiedUser', array(
             'local' => 'modified_user_id',
             'foreign' => 'id'));

        $this->hasMany('Users as createdUser', array(
             'local' => 'id',
             'foreign' => 'created_by'));

        $this->hasOne('UserGroup as userGroup', array(
             'local' => 'userg_id',
             'foreign' => 'userg_id'));

        $this->hasOne('Employee as employee', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('MailNotification', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('TimesheetActionLog', array(
             'local' => 'id',
             'foreign' => 'performed_by'));

        $this->hasMany('Users', array(
             'local' => 'id',
             'foreign' => 'modified_user_id'));

        $this->hasMany('PerformanceReview', array(
             'local' => 'id',
             'foreign' => 'creatorId'));
    }
}