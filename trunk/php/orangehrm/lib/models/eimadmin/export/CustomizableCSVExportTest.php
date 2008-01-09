<?php
// Call CustomizableCSVExportTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "CustomizableCSVExportTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";
require_once 'CustomizableCSVExport.php';
require_once ROOT_PATH . '/lib/common/LocaleUtil.php';
require_once ROOT_PATH . '/lib/models/hrfunct/EmpDirectDebit.php';

/**
 * Test class for CustomizableCSVExport.
 * Generated by PHPUnit_Util_Skeleton on 2008-01-09 at 11:53:31.
 */
class CustomizableCSVExportTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("CustomizableCSVExportTest");
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

    	$this->_truncateTables();

		// insert some test data
		$this->_runQuery("INSERT INTO hs_hr_custom_export(export_id, name, fields, headings) VALUES (1, 'Export 1', 'empId,lastName,firstName,middleName,street1,street2,city', '')");
		$this->_runQuery("INSERT INTO hs_hr_custom_export(export_id, name, fields, headings) VALUES (2, 'Export 2', 'empId,lastName,firstName,city', 'Employee Id,Last Name,First Name,City')");
		$this->_runQuery("INSERT INTO hs_hr_custom_export(export_id, name, fields, headings) VALUES (3, 'Export 3', 'empId,street1,street2,city', 'Employee Id,Address1, Address2, City')");

		// insert some employee data
    	$sql = "INSERT INTO hs_hr_employee" .
    				"(emp_number,   employee_id, emp_lastname, emp_firstname, emp_middle_name, " .
    				"emp_nick_name, emp_smoker, ethnic_race_code, emp_birthday, nation_code, " .
    				"emp_gender, emp_marital_status, emp_ssn_num, emp_sin_num, emp_other_id, " .
    				"emp_dri_lice_num, emp_dri_lice_exp_date, emp_military_service, emp_status, " .
    				"job_title_code, eeo_cat_code, work_station, " .
    				"emp_street1, emp_street2, city_code, coun_code, provin_code, emp_zipcode, " .
    				"emp_hm_telephone, emp_mobile, emp_work_telephone, emp_work_email, " .
    				"sal_grd_code, joined_date,	emp_oth_email, " .
					"custom1, custom2, custom3, custom4, custom5, " .
					"custom6, custom7, custom8, custom9, custom10)  VALUES (" .
  					"'10', 'E1921A', 'Karunadasa', 'Kamal', 'K', " .
  					"NULL, NULL, NULL, '1974-11-20', NULL, " .
  					"1, NULL, '987654320', '', '', " .
    				"null, '0000-00-00', NULL, 'EST001', " .
    				"NULL, NULL, NULL, " .
    				"'111 Main Street', 'SUITE A29', 'Houston', 'US', 'TX', '77845', " .
    				"'', '', '', NULL, " .
    				"NULL, '1997-12-11', NULL, " .
    				"'c1', 'c2', 'c3', 'c4', 'c5'," .
    				"'c6', 'c7', 'c8', 'c9', 'c10'" .
    				")";
    	$this->_runQuery($sql);

    	$sql = "INSERT into hs_hr_emp_us_tax(emp_number, tax_federal_status, tax_federal_exceptions, " .
    			"tax_state, tax_state_status, tax_state_exceptions, tax_unemp_state,tax_work_state) VALUES (" .
    			"10, 'NRA', 2, 'MD', 'NA', 3, 'VA', 'AZ')";
		$this->_runQuery($sql);

		// Add direct debit information
		$dd = new EmpDirectDebit();

		$dd->setEmpNumber(10);
		$dd->setRoutingNumber(11111);
		$dd->setAccount('AC 1');
		$dd->setAmount(121);
		$dd->setAccountType('CHECKING');
		$dd->setTransactionType('BLANK');
		$this->assertTrue($dd->add(), mysql_error());

		$dd = new EmpDirectDebit();

		$dd->setEmpNumber(10);
		$dd->setRoutingNumber(22222);
		$dd->setAccount('AC #2');
		$dd->setAmount(23);
		$dd->setAccountType('SAVINGS');
		$dd->setTransactionType('FLATMINUS');
		$this->assertTrue($dd->add(), mysql_error());

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	$this->_truncateTables();
    }

	/**
	 * Test the constructor
	 */
	public function testConstructor() {

		// check with invalid id
		try {
			$export = new CustomizableCSVExport(4);
			$this->fail("Exception expected");
		} catch (Exception $e) {
		}

		// check with valid id
		$export = new CustomizableCSVExport(2);
	}

    /**
     * Test the getName() function
     */
    public function testGetName() {

		$export = new CustomizableCSVExport(2);
		$this->assertEquals('Export 2', $export->getName());

		$export = new CustomizableCSVExport(1);
		$this->assertEquals('Export 1', $export->getName());

    }

    /**
     * Test the getHeader() function
     */
    public function testGetHeader() {

		// Export with header not defined, should default to assigned field names
		$export = new CustomizableCSVExport(1);
		$this->assertEquals('empId,lastName,firstName,middleName,street1,street2,city', $export->getHeader());

    	// Export with header defined
		$export = new CustomizableCSVExport(2);
		$this->assertEquals('Employee Id,Last Name,First Name,City', $export->getHeader());

		$export = new CustomizableCSVExport(3);
		$this->assertEquals('Employee Id,Address1, Address2, City', $export->getHeader());

    }

    /**
     * Test the getCSVData() method
     */
    public function testGetCSVData() {

    	// Export empId,lastName,firstName,middleName,street1,street2,city
    	$export = new CustomizableCSVExport(1);
    	$csv = $export->getCSVData();
    	$expected = 'E1921A,Karunadasa,Kamal,K,111 Main Street,SUITE A29,Houston' . "\n";
    	$this->assertEquals($expected, $csv);

		// In a different order
		$this->_runQuery("UPDATE hs_hr_custom_export SET fields = 'street1,lastName,empId,firstName,street2,middleName,city' WHERE export_id = 1");
    	$export = new CustomizableCSVExport(1);
    	$csv = $export->getCSVData();
    	$expected = '111 Main Street,Karunadasa,E1921A,Kamal,SUITE A29,K,Houston' . "\n";
    	$this->assertEquals($expected, $csv);

		// All available fields
		$available = "empId,lastName,firstName,middleName,street1,street2,city," .
                           "state,zip,gender,birthDate,ssn,empStatus,joinedDate,workStation,location,custom1,custom2," .
                           "custom3,custom4,custom5,custom6,custom7,custom8,custom9,custom10," .
                           "workState,salary,payFrequency," .
		                   "FITWStatus,FITWExemptions,SITWState,SITWStatus,SITWExemptions," .
                           "SUIState,DD1Routing,DD1Account,DD1Amount,".
                           "DD1AmountCode,DD1Checking,DD2Routing,".
		                   "DD2Account,DD2Amount,DD2AmountCode,DD2Checking";
		$this->_runQuery("UPDATE hs_hr_custom_export SET headings = '', fields = '{$available}' WHERE export_id = 2");

    	$joinedDate = LocaleUtil::getInstance()->formatDate('1997-12-11');
		$expected = "E1921A,Karunadasa,Kamal,K,111 Main Street,SUITE A29,Houston," .
                           "TX,77845,M,1974-11-20,987654320,EST001,{$joinedDate},,,c1,c2," .
                           "c3,c4,c5,c6,c7,c8,c9,c10," .
                           "AZ,,," .
		                   "NRA,2,MD,NA,3," .
                           "VA,11111,AC 1,121.00,".
                           "Blank,Y,22222,".
		                   "AC #2,23.00,Flat-,\n";

    	$export = new CustomizableCSVExport(2);
    	$csv = $export->getCSVData();
    	$this->assertEquals($expected, $csv);
    }

	/**
	 * Run given sql query
	 */
	private function _runQuery($sql) {
		$this->assertTrue(mysql_query($sql), mysql_error());
	}

	private function _truncateTables() {
    	$this->_runQuery("TRUNCATE TABLE hs_hr_custom_export");
    	$this->_runQuery("TRUNCATE TABLE `hs_hr_employee`");
	}

}

// Call CustomizableCSVExportTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "CustomizableCSVExportTest::main") {
    CustomizableCSVExportTest::main();
}
?>
