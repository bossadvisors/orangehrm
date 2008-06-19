<?php
// Call RecruitmentMailNotifierTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "RecruitmentMailNotifierTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";
require_once ROOT_PATH."/lib/confs/Conf.php";
require_once ROOT_PATH."/lib/confs/sysConf.php";
require_once ROOT_PATH."/lib/models/recruitment/JobApplication.php";
require_once ROOT_PATH."/lib/models/recruitment/JobVacancy.php";
require_once ROOT_PATH."/lib/common/UniqueIDGenerator.php";
require_once ROOT_PATH . '/lib/models/eimadmin/EmailNotificationConfiguration.php';

require_once 'RecruitmentMailNotifier.php';

/**
 * Test class for RecruitmentMailNotifier.
 * Generated by PHPUnit_Util_Skeleton on 2008-02-15 at 16:39:38.
 */
class RecruitmentMailNotifierTest extends PHPUnit_Framework_TestCase {

	private $jobApplications;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("RecruitmentMailNotifierTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$conf = new Conf();
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
        mysql_select_db($conf->dbname);
		$this->_deleteTables();

		// Insert job titles
		$this->_runQuery("INSERT INTO hs_hr_job_title(jobtit_code, jobtit_name, jobtit_desc, jobtit_comm, sal_grd_code) " .
				"VALUES('JOB001', 'Manager', 'Manager job title', 'no comments', null)");
		$this->_runQuery("INSERT INTO hs_hr_job_title(jobtit_code, jobtit_name, jobtit_desc, jobtit_comm, sal_grd_code) " .
				"VALUES('JOB002', 'Driver', 'Driver job title', 'no comments', null)");

		// Insert employees (managers)
        $this->_runQuery("INSERT INTO hs_hr_employee(emp_number, employee_id, emp_lastname, emp_firstname, emp_middle_name, job_title_code, emp_work_email) " .
        			"VALUES(11, '0011', 'Rajasinghe', 'Saman', 'Marlon', 'JOB001', 'aruna@company.com')");
        $this->_runQuery("INSERT INTO hs_hr_employee(emp_number, employee_id, emp_lastname, emp_firstname, emp_middle_name, job_title_code, emp_work_email) " .
        			"VALUES(12, '0022', 'Jayasinghe', 'Aruna', 'Shantha', 'JOB001', 'aruna@company.com')");

		// Insert Job Vacancies
		$this->_runQuery("INSERT INTO hs_hr_job_vacancy(vacancy_id, jobtit_code, manager_id, active, description) " .
                         "VALUES(1, 'JOB001', 11, " . JobVacancy::STATUS_ACTIVE . ", 'Job vacancy 1')");
		$this->_runQuery("INSERT INTO hs_hr_job_vacancy(vacancy_id, jobtit_code, manager_id, active, description) " .
                         "VALUES(2, 'JOB002', 12, " . JobVacancy::STATUS_INACTIVE . ", 'Job vacancy 2')");

		// Insert Job Applications
		$application = $this->_getJobApplication(1, 1, 'Janaka', 'T', 'Kulathunga', '111 Main Street', 'Apt X2',
				'Colombo', 'Western', '2222', 'Sri Lanka', '01121111121', '077282828282', 'janaka@example.com',
				'aaa bbb');
		$this->jobApplications[1] = $application;

		$this->_createJobApplications($this->jobApplications);
		UniqueIDGenerator::getInstance()->resetIDs();
    }

    /**
     * Tears down the fixture, removed database entries created during test.
     *
     * @access protected
     */
    protected function tearDown() {
		$this->_deleteTables();
		UniqueIDGenerator::getInstance()->resetIDs();
    }

	private function _deleteTables() {
		$this->_runQuery("TRUNCATE TABLE `hs_hr_job_application`");
		$this->_runQuery("TRUNCATE TABLE `hs_hr_job_vacancy`");
        $this->_runQuery("TRUNCATE TABLE `hs_hr_job_title`");
        $this->_runQuery("TRUNCATE TABLE `hs_hr_employee`");
    	$this->_runQuery("DELETE FROM `hs_hr_mailnotifications` WHERE `notification_type_id` = " . EmailNotificationConfiguration::EMAILNOTIFICATIONCONFIGURATION_NOTIFICATION_TYPE_JOB_APPLIED);
	}

	/**
	 * Run given sql query, checking the return value
	 */
    private function _runQuery($sql) {
        $this->assertTrue(mysql_query($sql), mysql_error());
    }

    /**
     * Test case for sendApplicationReceivedEmailToApplicant().
     */
    public function testSendApplicationReceivedEmailToApplicant() {

    	$jobApplication = $this->jobApplications[1];

    	$notifier = new RecruitmentMailNotifier();
    	$mockMailer = new MockMailer();
    	$notifier->setMailer($mockMailer);

		// Check successfull email
    	$result = $notifier->sendApplicationReceivedEmailToApplicant($jobApplication);
    	$this->assertTrue($result);

		$to = $mockMailer->getTo();
		$this->assertEquals(1, count($to));
    	$this->assertEquals('janaka@example.com', $to[0]);

    	$subject = $this->_getTemplateFile(RecruitmentMailNotifier::SUBJECT_RECEIVED_APPLICANT);
    	$body = $this->_getTemplateFile(RecruitmentMailNotifier::TEMPLATE_RECEIVED_APPLICANT);
		$search = array(RecruitmentMailNotifier::VARIABLE_JOB_TITLE, RecruitmentMailNotifier::VARIABLE_TO);
		$replace = array('Manager', 'Janaka Kulathunga');

		$body = str_replace($search, $replace, $body);
		$subject = str_replace($search, $replace, $subject);
		$subject = str_replace(array("\r", "\n"), array("", ""), $subject);

    	$this->assertEquals($subject, $mockMailer->getSubject());
    	$this->assertEquals($body, $mockMailer->getText());


    	// Force failure
    	$mockMailer = new MockMailer();
    	$mockMailer->setResult(false);
    	$notifier->setMailer($mockMailer);
    	$result = $notifier->sendApplicationReceivedEmailToApplicant($jobApplication);
    	$this->assertFalse($result);

    	// without to email address - should fail
    	$jobApplication->setEmail(null);
    	$mockMailer = new MockMailer();
    	$notifier->setMailer($mockMailer);

    	$result = $notifier->sendApplicationReceivedEmailToApplicant($jobApplication);
    	$this->assertFalse($result);
    }

    /**
     * Test case for SendApplicationReceivedEmailToManager().
     */
    public function testSendApplicationReceivedEmailToManager() {
    	$jobApplication = $this->jobApplications[1];

    	$notifier = new RecruitmentMailNotifier();
    	$mockMailer = new MockMailer();
    	$notifier->setMailer($mockMailer);

		// Check successfull email
    	$result = $notifier->sendApplicationReceivedEmailToManager($jobApplication);
    	$this->assertTrue($result);

		$to = $mockMailer->getTo();
		$this->assertEquals(1, count($to));
    	$this->assertEquals('aruna@company.com', $to[0]);

    	$subject = $this->_getTemplateFile(RecruitmentMailNotifier::SUBJECT_RECEIVED_HIRING_MANAGER);
    	$body = $this->_getTemplateFile(RecruitmentMailNotifier::TEMPLATE_RECEIVED_HIRING_MANAGER);

		$search = array(RecruitmentMailNotifier::VARIABLE_JOB_TITLE, RecruitmentMailNotifier::VARIABLE_TO,
			RecruitmentMailNotifier::VARIABLE_APPLICANT_FIRSTNAME,	RecruitmentMailNotifier::VARIABLE_APPLICANT_MIDDLENAME,
			RecruitmentMailNotifier::VARIABLE_APPLICANT_LASTNAME, RecruitmentMailNotifier::VARIABLE_APPLICANT_STREET1,
			RecruitmentMailNotifier::VARIABLE_APPLICANT_STREET2, RecruitmentMailNotifier::VARIABLE_APPLICANT_CITY,
			RecruitmentMailNotifier::VARIABLE_APPLICANT_PROVINCE, RecruitmentMailNotifier::VARIABLE_APPLICANT_ZIP,
			RecruitmentMailNotifier::VARIABLE_APPLICANT_COUNTRY, RecruitmentMailNotifier::VARIABLE_APPLICANT_PHONE,
			RecruitmentMailNotifier::VARIABLE_APPLICANT_MOBILE, RecruitmentMailNotifier::VARIABLE_APPLICANT_EMAIL,
			RecruitmentMailNotifier::VARIABLE_APPLICANT_QUALIFICATIONS);

		$replace = array('Manager', 'Saman',
			$jobApplication->getFirstName(), $jobApplication->getMiddleName(),
			$jobApplication->getLastName(), $jobApplication->getStreet1(),
			$jobApplication->getStreet2(), $jobApplication->getCity(),
		 	$jobApplication->getProvince(), $jobApplication->getZip(),
		 	'Sri Lanka', $jobApplication->getPhone(),
		 	$jobApplication->getMobile(), $jobApplication->getEmail(),
			$jobApplication->getQualifications());

		$body = str_replace($search, $replace, $body);
		$subject = str_replace($search, $replace, $subject);
		$subject = str_replace(array("\r", "\n"), array("", ""), $subject);

    	$this->assertEquals($subject, $mockMailer->getSubject());
    	$this->assertEquals($body, $mockMailer->getText());

    	// Force failure
    	$mockMailer = new MockMailer();
    	$mockMailer->setResult(false);
    	$notifier->setMailer($mockMailer);
    	$result = $notifier->sendApplicationReceivedEmailToManager($jobApplication);
    	$this->assertFalse($result);

    	// without to email address - should fail
    	$this->_runQuery("UPDATE hs_hr_employee SET emp_work_email=NULL where emp_number = 11");
    	$mockMailer = new MockMailer();
    	$notifier->setMailer($mockMailer);

    	$result = $notifier->sendApplicationReceivedEmailToManager($jobApplication);
    	$this->assertFalse($result);
    }

    /**
     * Create a JobApplication object with the passed parameters
     */
    private function _getJobApplication($id, $vacancyId, $firstName, $middleName, $lastName, $street1, $street2,
    		$city, $province, $zip, $country, $mobile, $phone, $email, $qualifications) {
    	$application = new JobApplication($id);
		$application->setVacancyId($vacancyId);
		$application->setFirstName($firstName);
		$application->setMiddleName($middleName);
		$application->setLastName($lastName);
		$application->setStreet1($street1);
		$application->setStreet2($street2);
		$application->setCity($city);
		$application->setProvince($province);
		$application->setZip($zip);
		$application->setCountry($country);
		$application->setMobile($mobile);
		$application->setPhone($phone);
		$application->setEmail($email);
		$application->setQualifications($qualifications);
    	return $application;
    }

    /**
     * Saves the given JobApplication objects in the database
     *
     * @param array $applications Array of JobApplication objects to save.
     */
    private function _createJobApplications($applications) {
		foreach ($applications as $application) {

			$sql = sprintf("INSERT INTO hs_hr_job_application(application_id, vacancy_id, firstname, middlename, ".
						"lastname, street1, street2, city, country_code, province, zip, " .
						"phone, mobile, email, qualifications) " .
                        "VALUES(%d, %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                        $application->getId(), $application->getVacancyId(), $application->getFirstName(),
                        $application->getMiddleName(), $application->getLastName(), $application->getStreet1(),
                        $application->getStreet2(), $application->getCity(), $application->getCountry(),
                        $application->getProvince(), $application->getZip(), $application->getPhone(),
                        $application->getMobile(), $application->getEmail(),
                        $application->getQualifications());
            $this->assertTrue(mysql_query($sql), mysql_error());
		}
		UniqueIDGenerator::getInstance()->initTable();
    }

    /**
     * Retrieves the text of the template file
     */
    private function _getTemplateFile($fileName) {
		$text = file_get_contents(ROOT_PATH."/templates/recruitment/mails/".$fileName);
		return $text;
    }
}

/**
 * Mock class to test mailing
 */
class MockMailer {

	private $text;
	private $subject;
	private $cc;
	private $to;
	private $mailType;

	/* result of send method*/
	private $result = true;

	public $errors = null;

	public function setText($text) {
	    $this->text = $text;
	}

	public function getText() {
	    return $this->text;
	}

	public function setSubject($subject) {
		$this->subject = $subject;
	}

	public function getSubject() {
		return $this->subject;
	}

	public function setCC($cc) {
	    $this->cc = $cc;
	}

	public function getCC() {
	    return $this->cc;
	}

	public function setTo($to) {
	    $this->to = $to;
	}

	public function getTo() {
	    return $this->to;
	}

	public function setResult($result) {
	    $this->result = $result;
	}

	public function send($to, $mailType) {
		$this->to = $to;
		$this->mailType = $mailType;
		return $this->result;
	}
}

// Call RecruitmentMailNotifierTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "RecruitmentMailNotifierTest::main") {
    RecruitmentMailNotifierTest::main();
}
?>
