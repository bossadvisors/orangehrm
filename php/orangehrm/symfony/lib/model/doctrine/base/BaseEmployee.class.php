<?php

/**
 * BaseEmployee
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $empNumber
 * @property string $lastName
 * @property string $firstName
 * @property string $middleName
 * @property string $nickName
 * @property integer $smoker
 * @property string $ssn
 * @property string $sin
 * @property string $otherId
 * @property string $licenseNo
 * @property string $militaryService
 * @property string $street1
 * @property string $street2
 * @property string $city
 * @property string $country
 * @property string $province
 * @property string $employeeId
 * @property string $ethnic_race_code
 * @property date $emp_birthday
 * @property string $nation_code
 * @property integer $emp_gender
 * @property string $emp_marital_status
 * @property date $emp_dri_lice_exp_date
 * @property string $emp_status
 * @property string $job_title_code
 * @property string $eeo_cat_code
 * @property integer $work_station
 * @property string $emp_zipcode
 * @property string $emp_hm_telephone
 * @property string $emp_mobile
 * @property string $emp_work_telephone
 * @property string $emp_work_email
 * @property string $sal_grd_code
 * @property date $joined_date
 * @property string $emp_oth_email
 * @property date $terminated_date
 * @property string $termination_reason
 * @property string $custom1
 * @property string $custom2
 * @property string $custom3
 * @property string $custom4
 * @property string $custom5
 * @property string $custom6
 * @property string $custom7
 * @property string $custom8
 * @property string $custom9
 * @property string $custom10
 * @property CompanyStructure $subDivision
 * @property JobTitle $jobTitle
 * @property EmployeeStatus $employeeStatus
 * @property Doctrine_Collection $supervisors
 * @property Doctrine_Collection $locations
 * @property Doctrine_Collection $dependents
 * @property Doctrine_Collection $children
 * @property Doctrine_Collection $emergencyContacts
 * @property Doctrine_Collection $immigrationDocuments
 * @property Doctrine_Collection $workExperience
 * @property Doctrine_Collection $education
 * @property Doctrine_Collection $skills
 * @property Doctrine_Collection $languages
 * @property Doctrine_Collection $licenses
 * @property Doctrine_Collection $memberships
 * @property Doctrine_Collection $salary
 * @property Doctrine_Collection $directDebit
 * @property Doctrine_Collection $EmployeeLeaveEntitlement
 * @property Doctrine_Collection $LeaveRequest
 * @property Doctrine_Collection $subordinates
 * @property EmpUsTax $usTax
 * @property Doctrine_Collection $ReportTo
 * @property JobCategory $JobCategory
 * @property Doctrine_Collection $EmployeeLicenses
 * @property Nationality $Nationality
 * @property EthnicRace $EthnicRace
 * @property Doctrine_Collection $ProjectAdmin
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $EmployeeWorkShift
 * @property Doctrine_Collection $PerformanceReview
 * @property Doctrine_Collection $PerformanceReviewComment
 * 
 * @method integer             getEmpNumber()                Returns the current record's "empNumber" value
 * @method string              getLastName()                 Returns the current record's "lastName" value
 * @method string              getFirstName()                Returns the current record's "firstName" value
 * @method string              getMiddleName()               Returns the current record's "middleName" value
 * @method string              getNickName()                 Returns the current record's "nickName" value
 * @method integer             getSmoker()                   Returns the current record's "smoker" value
 * @method string              getSsn()                      Returns the current record's "ssn" value
 * @method string              getSin()                      Returns the current record's "sin" value
 * @method string              getOtherId()                  Returns the current record's "otherId" value
 * @method string              getLicenseNo()                Returns the current record's "licenseNo" value
 * @method string              getMilitaryService()          Returns the current record's "militaryService" value
 * @method string              getStreet1()                  Returns the current record's "street1" value
 * @method string              getStreet2()                  Returns the current record's "street2" value
 * @method string              getCity()                     Returns the current record's "city" value
 * @method string              getCountry()                  Returns the current record's "country" value
 * @method string              getProvince()                 Returns the current record's "province" value
 * @method string              getEmployeeId()               Returns the current record's "employeeId" value
 * @method string              getEthnicRaceCode()           Returns the current record's "ethnic_race_code" value
 * @method date                getEmpBirthday()              Returns the current record's "emp_birthday" value
 * @method string              getNationCode()               Returns the current record's "nation_code" value
 * @method integer             getEmpGender()                Returns the current record's "emp_gender" value
 * @method string              getEmpMaritalStatus()         Returns the current record's "emp_marital_status" value
 * @method date                getEmpDriLiceExpDate()        Returns the current record's "emp_dri_lice_exp_date" value
 * @method string              getEmpStatus()                Returns the current record's "emp_status" value
 * @method string              getJobTitleCode()             Returns the current record's "job_title_code" value
 * @method string              getEeoCatCode()               Returns the current record's "eeo_cat_code" value
 * @method integer             getWorkStation()              Returns the current record's "work_station" value
 * @method string              getEmpZipcode()               Returns the current record's "emp_zipcode" value
 * @method string              getEmpHmTelephone()           Returns the current record's "emp_hm_telephone" value
 * @method string              getEmpMobile()                Returns the current record's "emp_mobile" value
 * @method string              getEmpWorkTelephone()         Returns the current record's "emp_work_telephone" value
 * @method string              getEmpWorkEmail()             Returns the current record's "emp_work_email" value
 * @method string              getSalGrdCode()               Returns the current record's "sal_grd_code" value
 * @method date                getJoinedDate()               Returns the current record's "joined_date" value
 * @method string              getEmpOthEmail()              Returns the current record's "emp_oth_email" value
 * @method date                getTerminatedDate()           Returns the current record's "terminated_date" value
 * @method string              getTerminationReason()        Returns the current record's "termination_reason" value
 * @method string              getCustom1()                  Returns the current record's "custom1" value
 * @method string              getCustom2()                  Returns the current record's "custom2" value
 * @method string              getCustom3()                  Returns the current record's "custom3" value
 * @method string              getCustom4()                  Returns the current record's "custom4" value
 * @method string              getCustom5()                  Returns the current record's "custom5" value
 * @method string              getCustom6()                  Returns the current record's "custom6" value
 * @method string              getCustom7()                  Returns the current record's "custom7" value
 * @method string              getCustom8()                  Returns the current record's "custom8" value
 * @method string              getCustom9()                  Returns the current record's "custom9" value
 * @method string              getCustom10()                 Returns the current record's "custom10" value
 * @method CompanyStructure    getSubDivision()              Returns the current record's "subDivision" value
 * @method JobTitle            getJobTitle()                 Returns the current record's "jobTitle" value
 * @method EmployeeStatus      getEmployeeStatus()           Returns the current record's "employeeStatus" value
 * @method Doctrine_Collection getSupervisors()              Returns the current record's "supervisors" collection
 * @method Doctrine_Collection getLocations()                Returns the current record's "locations" collection
 * @method Doctrine_Collection getDependents()               Returns the current record's "dependents" collection
 * @method Doctrine_Collection getChildren()                 Returns the current record's "children" collection
 * @method Doctrine_Collection getEmergencyContacts()        Returns the current record's "emergencyContacts" collection
 * @method Doctrine_Collection getImmigrationDocuments()     Returns the current record's "immigrationDocuments" collection
 * @method Doctrine_Collection getWorkExperience()           Returns the current record's "workExperience" collection
 * @method Doctrine_Collection getEducation()                Returns the current record's "education" collection
 * @method Doctrine_Collection getSkills()                   Returns the current record's "skills" collection
 * @method Doctrine_Collection getLanguages()                Returns the current record's "languages" collection
 * @method Doctrine_Collection getLicenses()                 Returns the current record's "licenses" collection
 * @method Doctrine_Collection getMemberships()              Returns the current record's "memberships" collection
 * @method Doctrine_Collection getSalary()                   Returns the current record's "salary" collection
 * @method Doctrine_Collection getDirectDebit()              Returns the current record's "directDebit" collection
 * @method Doctrine_Collection getEmployeeLeaveEntitlement() Returns the current record's "EmployeeLeaveEntitlement" collection
 * @method Doctrine_Collection getLeaveRequest()             Returns the current record's "LeaveRequest" collection
 * @method Doctrine_Collection getSubordinates()             Returns the current record's "subordinates" collection
 * @method EmpUsTax            getUsTax()                    Returns the current record's "usTax" value
 * @method Doctrine_Collection getReportTo()                 Returns the current record's "ReportTo" collection
 * @method JobCategory         getJobCategory()              Returns the current record's "JobCategory" value
 * @method Doctrine_Collection getEmployeeLicenses()         Returns the current record's "EmployeeLicenses" collection
 * @method Nationality         getNationality()              Returns the current record's "Nationality" value
 * @method EthnicRace          getEthnicRace()               Returns the current record's "EthnicRace" value
 * @method Doctrine_Collection getProjectAdmin()             Returns the current record's "ProjectAdmin" collection
 * @method Doctrine_Collection getUsers()                    Returns the current record's "Users" collection
 * @method Doctrine_Collection getEmployeeWorkShift()        Returns the current record's "EmployeeWorkShift" collection
 * @method Doctrine_Collection getPerformanceReview()        Returns the current record's "PerformanceReview" collection
 * @method Doctrine_Collection getPerformanceReviewComment() Returns the current record's "PerformanceReviewComment" collection
 * @method Employee            setEmpNumber()                Sets the current record's "empNumber" value
 * @method Employee            setLastName()                 Sets the current record's "lastName" value
 * @method Employee            setFirstName()                Sets the current record's "firstName" value
 * @method Employee            setMiddleName()               Sets the current record's "middleName" value
 * @method Employee            setNickName()                 Sets the current record's "nickName" value
 * @method Employee            setSmoker()                   Sets the current record's "smoker" value
 * @method Employee            setSsn()                      Sets the current record's "ssn" value
 * @method Employee            setSin()                      Sets the current record's "sin" value
 * @method Employee            setOtherId()                  Sets the current record's "otherId" value
 * @method Employee            setLicenseNo()                Sets the current record's "licenseNo" value
 * @method Employee            setMilitaryService()          Sets the current record's "militaryService" value
 * @method Employee            setStreet1()                  Sets the current record's "street1" value
 * @method Employee            setStreet2()                  Sets the current record's "street2" value
 * @method Employee            setCity()                     Sets the current record's "city" value
 * @method Employee            setCountry()                  Sets the current record's "country" value
 * @method Employee            setProvince()                 Sets the current record's "province" value
 * @method Employee            setEmployeeId()               Sets the current record's "employeeId" value
 * @method Employee            setEthnicRaceCode()           Sets the current record's "ethnic_race_code" value
 * @method Employee            setEmpBirthday()              Sets the current record's "emp_birthday" value
 * @method Employee            setNationCode()               Sets the current record's "nation_code" value
 * @method Employee            setEmpGender()                Sets the current record's "emp_gender" value
 * @method Employee            setEmpMaritalStatus()         Sets the current record's "emp_marital_status" value
 * @method Employee            setEmpDriLiceExpDate()        Sets the current record's "emp_dri_lice_exp_date" value
 * @method Employee            setEmpStatus()                Sets the current record's "emp_status" value
 * @method Employee            setJobTitleCode()             Sets the current record's "job_title_code" value
 * @method Employee            setEeoCatCode()               Sets the current record's "eeo_cat_code" value
 * @method Employee            setWorkStation()              Sets the current record's "work_station" value
 * @method Employee            setEmpZipcode()               Sets the current record's "emp_zipcode" value
 * @method Employee            setEmpHmTelephone()           Sets the current record's "emp_hm_telephone" value
 * @method Employee            setEmpMobile()                Sets the current record's "emp_mobile" value
 * @method Employee            setEmpWorkTelephone()         Sets the current record's "emp_work_telephone" value
 * @method Employee            setEmpWorkEmail()             Sets the current record's "emp_work_email" value
 * @method Employee            setSalGrdCode()               Sets the current record's "sal_grd_code" value
 * @method Employee            setJoinedDate()               Sets the current record's "joined_date" value
 * @method Employee            setEmpOthEmail()              Sets the current record's "emp_oth_email" value
 * @method Employee            setTerminatedDate()           Sets the current record's "terminated_date" value
 * @method Employee            setTerminationReason()        Sets the current record's "termination_reason" value
 * @method Employee            setCustom1()                  Sets the current record's "custom1" value
 * @method Employee            setCustom2()                  Sets the current record's "custom2" value
 * @method Employee            setCustom3()                  Sets the current record's "custom3" value
 * @method Employee            setCustom4()                  Sets the current record's "custom4" value
 * @method Employee            setCustom5()                  Sets the current record's "custom5" value
 * @method Employee            setCustom6()                  Sets the current record's "custom6" value
 * @method Employee            setCustom7()                  Sets the current record's "custom7" value
 * @method Employee            setCustom8()                  Sets the current record's "custom8" value
 * @method Employee            setCustom9()                  Sets the current record's "custom9" value
 * @method Employee            setCustom10()                 Sets the current record's "custom10" value
 * @method Employee            setSubDivision()              Sets the current record's "subDivision" value
 * @method Employee            setJobTitle()                 Sets the current record's "jobTitle" value
 * @method Employee            setEmployeeStatus()           Sets the current record's "employeeStatus" value
 * @method Employee            setSupervisors()              Sets the current record's "supervisors" collection
 * @method Employee            setLocations()                Sets the current record's "locations" collection
 * @method Employee            setDependents()               Sets the current record's "dependents" collection
 * @method Employee            setChildren()                 Sets the current record's "children" collection
 * @method Employee            setEmergencyContacts()        Sets the current record's "emergencyContacts" collection
 * @method Employee            setImmigrationDocuments()     Sets the current record's "immigrationDocuments" collection
 * @method Employee            setWorkExperience()           Sets the current record's "workExperience" collection
 * @method Employee            setEducation()                Sets the current record's "education" collection
 * @method Employee            setSkills()                   Sets the current record's "skills" collection
 * @method Employee            setLanguages()                Sets the current record's "languages" collection
 * @method Employee            setLicenses()                 Sets the current record's "licenses" collection
 * @method Employee            setMemberships()              Sets the current record's "memberships" collection
 * @method Employee            setSalary()                   Sets the current record's "salary" collection
 * @method Employee            setDirectDebit()              Sets the current record's "directDebit" collection
 * @method Employee            setEmployeeLeaveEntitlement() Sets the current record's "EmployeeLeaveEntitlement" collection
 * @method Employee            setLeaveRequest()             Sets the current record's "LeaveRequest" collection
 * @method Employee            setSubordinates()             Sets the current record's "subordinates" collection
 * @method Employee            setUsTax()                    Sets the current record's "usTax" value
 * @method Employee            setReportTo()                 Sets the current record's "ReportTo" collection
 * @method Employee            setJobCategory()              Sets the current record's "JobCategory" value
 * @method Employee            setEmployeeLicenses()         Sets the current record's "EmployeeLicenses" collection
 * @method Employee            setNationality()              Sets the current record's "Nationality" value
 * @method Employee            setEthnicRace()               Sets the current record's "EthnicRace" value
 * @method Employee            setProjectAdmin()             Sets the current record's "ProjectAdmin" collection
 * @method Employee            setUsers()                    Sets the current record's "Users" collection
 * @method Employee            setEmployeeWorkShift()        Sets the current record's "EmployeeWorkShift" collection
 * @method Employee            setPerformanceReview()        Sets the current record's "PerformanceReview" collection
 * @method Employee            setPerformanceReviewComment() Sets the current record's "PerformanceReviewComment" collection
 * 
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployee extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_employee');
        $this->hasColumn('emp_number as empNumber', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('emp_lastname as lastName', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('emp_firstname as firstName', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('emp_middle_name as middleName', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('emp_nick_name as nickName', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('emp_smoker as smoker', 'integer', 2, array(
             'type' => 'integer',
             'default' => '0',
             'length' => 2,
             ));
        $this->hasColumn('emp_ssn_num as ssn', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('emp_sin_num as sin', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('emp_other_id as otherId', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('emp_dri_lice_num as licenseNo', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('emp_military_service as militaryService', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('emp_street1 as street1', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('emp_street2 as street2', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('city_code as city', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('coun_code as country', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('provin_code as province', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('employee_id as employeeId', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('ethnic_race_code', 'string', 13, array(
             'type' => 'string',
             'length' => 13,
             ));
        $this->hasColumn('emp_birthday', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('nation_code', 'string', 13, array(
             'type' => 'string',
             'length' => 13,
             ));
        $this->hasColumn('emp_gender', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             ));
        $this->hasColumn('emp_marital_status', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('emp_dri_lice_exp_date', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('emp_status', 'string', 13, array(
             'type' => 'string',
             'length' => 13,
             ));
        $this->hasColumn('job_title_code', 'string', 13, array(
             'type' => 'string',
             'length' => 13,
             ));
        $this->hasColumn('eeo_cat_code', 'string', 13, array(
             'type' => 'string',
             'length' => 13,
             ));
        $this->hasColumn('work_station', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('emp_zipcode', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             ));
        $this->hasColumn('emp_hm_telephone', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('emp_mobile', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('emp_work_telephone', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('emp_work_email', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('sal_grd_code', 'string', 13, array(
             'type' => 'string',
             'length' => 13,
             ));
        $this->hasColumn('joined_date', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('emp_oth_email', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('terminated_date', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('termination_reason', 'string', 256, array(
             'type' => 'string',
             'length' => 256,
             ));
        $this->hasColumn('custom1', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom2', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom3', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom4', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom5', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom6', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom7', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom8', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom9', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('custom10', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CompanyStructure as subDivision', array(
             'local' => 'work_station',
             'foreign' => 'id'));

        $this->hasOne('JobTitle as jobTitle', array(
             'local' => 'job_title_code',
             'foreign' => 'jobtit_code'));

        $this->hasOne('EmployeeStatus as employeeStatus', array(
             'local' => 'emp_status',
             'foreign' => 'estat_code'));

        $this->hasMany('Employee as supervisors', array(
             'refClass' => 'ReportTo',
             'local' => 'erep_sub_emp_number',
             'foreign' => 'erep_sup_emp_number'));

        $this->hasMany('Location as locations', array(
             'refClass' => 'EmpLocations',
             'local' => 'emp_number',
             'foreign' => 'loc_code'));

        $this->hasMany('EmpDependents as dependents', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmpChildren as children', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmpEmergencyContacts as emergencyContacts', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmpPassport as immigrationDocuments', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmpWorkExperience as workExperience', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmployeeEducation as education', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmployeeSkill as skills', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmployeeLanguage as languages', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmployeeLicenses as licenses', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmployeeMemberDetail as memberships', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmpBasicsalary as salary', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmpDirectdebit as directDebit', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmployeeLeaveEntitlement', array(
             'local' => 'empNumber',
             'foreign' => 'employee_id'));

        $this->hasMany('LeaveRequest', array(
             'local' => 'empNumber',
             'foreign' => 'empNumber'));

        $this->hasMany('Employee as subordinates', array(
             'refClass' => 'ReportTo',
             'local' => 'erep_sup_emp_number',
             'foreign' => 'erep_sub_emp_number'));

        $this->hasOne('EmpUsTax as usTax', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('ReportTo', array(
             'local' => 'emp_number',
             'foreign' => 'erep_sup_emp_number'));

        $this->hasOne('JobCategory', array(
             'local' => 'eeo_cat_code',
             'foreign' => 'eec_code'));

        $this->hasMany('EmployeeLicenses', array(
             'local' => 'empNumber',
             'foreign' => 'empNumber'));

        $this->hasOne('Nationality', array(
             'local' => 'nation_code',
             'foreign' => 'nat_code'));

        $this->hasOne('EthnicRace', array(
             'local' => 'ethnic_race_code',
             'foreign' => 'ethnic_race_code'));

        $this->hasMany('ProjectAdmin', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('Users', array(
             'local' => 'emp_number',
             'foreign' => 'emp_number'));

        $this->hasMany('EmployeeWorkShift', array(
             'local' => 'empNumber',
             'foreign' => 'emp_number'));

        $this->hasMany('PerformanceReview', array(
             'local' => 'emp_number',
             'foreign' => 'employeeId'));

        $this->hasMany('PerformanceReviewComment', array(
             'local' => 'emp_number',
             'foreign' => 'employeeId'));
    }
}