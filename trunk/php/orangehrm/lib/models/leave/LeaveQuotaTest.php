<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */


// Call LeaveQuotaTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "LeaveQuotaTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

$_SESSION['WPATH'] = WPATH;

require_once "LeaveQuota.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for LeaveQuota.
 * Generated by PHPUnit_Util_Skeleton on 2006-10-19 at 06:19:48.
 */
class LeaveQuotaTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */

    public $classLeaveQuota = null;
    public $connection = null;

    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("LeaveQuotaTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classLeaveQuota = new LeaveQuota();

    	$conf = new Conf();

    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);

        mysql_select_db($conf->dbname);

        mysql_query("INSERT INTO `hs_hr_employee` VALUES ('011', NULL, 'Arnold', 'Subasinghe', '', 'Arnold', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', 'AF', '', '', '', '', '', '', NULL, '0000-00-00', '')");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('012', NULL, 'Mohanjith', 'Sudirikku', 'Hannadige', 'MOHA', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('020', NULL, 'MohanjithX', 'SudirikkuX', 'HannadigeX', 'MOHAX', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('015', NULL, 'Mohanjith1', 'Sudirikku1', 'Hannadige1', 'MOHA1', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('016', NULL, 'Gayanath', 'Wageeshwara', 'Jayarathne', 'MOHA1', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('017', NULL, 'Ajith', 'Kumara', 'Bandara', 'MOHA1', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");

		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY010', 'Medical', 1)");
		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY011', 'Casual', 1)");
		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY012', 'Personal', 1)");
		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY013', 'Annual', 1)");

		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` (year, leave_type_id, employee_id, no_of_days_allotted) VALUES ('".date('Y')."', 'LTY010', '012', 10);");
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` (year, leave_type_id, employee_id, no_of_days_allotted) VALUES ('".date('Y')."', 'LTY011', '012', 20);");
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` (year, leave_type_id, employee_id, no_of_days_allotted) VALUES ('".date('Y')."', 'LTY010', '011', 10);");
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` (year, leave_type_id, employee_id, no_of_days_allotted) VALUES ('".date('Y')."', 'LTY011', '011', 20);");
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` (year, leave_type_id, employee_id, no_of_days_allotted, leave_taken) VALUES ('2009', 'LTY012', '016', 20, 10);");
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` (year, leave_type_id, employee_id, no_of_days_allotted, leave_taken) VALUES ('2010', 'LTY012', '016', 20, 10);");
		$previousYear = date('Y') - 1;
		mysql_query("INSERT INTO `hs_hr_employee_leave_quota` (year, leave_type_id, employee_id, no_of_days_allotted, leave_taken, leave_brought_forward) VALUES ('".$previousYear."', 'LTY013', '017', 20, 10, 5);");

		echo mysql_error();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {

    	mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY011'", $this->connection);

    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '011'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '012'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '020'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '015'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '016'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '017'", $this->connection);

    	mysql_query("DELETE FROM `hs_hr_employee_leave_quota` WHERE `Employee_ID` = '012'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee_leave_quota` WHERE `Employee_ID` = '011'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee_leave_quota` WHERE `Employee_ID` = '020'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee_leave_quota` WHERE `Employee_ID` = '015'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee_leave_quota` WHERE `Employee_ID` = '016'", $this->connection);
		mysql_query("DELETE FROM `hs_hr_employee_leave_quota` WHERE `Employee_ID` = '017'", $this->connection);

		mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY010'", $this->connection);
		mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY012'", $this->connection);
		mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY013'", $this->connection);


    	$this->connection = null;
    }

    public function testAddLeaveQuotaAccuracy1() {
		$expected[] = array(date('Y'), "LTY011", "Casual", "20");
		$expected[] = array(date('Y'), "LTY010", "Medical", "10");

        for ($i=0; $i < count($expected); $i++) {

			$this->classLeaveQuota->setYear($expected[$i][0]);
    		$this->classLeaveQuota->setLeaveTypeId($expected[$i][1]);
    		$this->classLeaveQuota->setNoOfDaysAllotted($expected[$i][3]);

    		$res = $this->classLeaveQuota->addLeaveQuota("020");

    		$this->assertNotNull($res, "Addition failed - $i ");
        }

    	$res = $this->classLeaveQuota->fetchLeaveQuota("020");

        $this->assertNotNull($res, "No record found ");

        $this->assertEquals(count($res), 2, "Number of records found is not accurate ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getYear(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeId(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getNoOfDaysAllotted(), $expected[$i][3], "Didn't return expected result ");
        }
    }

    /**
     * @todo Implement testEditLeaveQuota().
     */
    public function testEditLeaveQuota() {
        $expected[] = array(date('Y'), "LTY011", "Casual", "18");
        $expected[] = array(date('Y'), "LTY010", "Medical", "15");

        for ($i=0; $i<count($expected); $i++) {

			$this->classLeaveQuota->setYear($expected[$i][0]);
    		$this->classLeaveQuota->setLeaveTypeId($expected[$i][1]);
    		$this->classLeaveQuota->setNoOfDaysAllotted($expected[$i][3]);
    		$this->classLeaveQuota->setEmployeeId("015");

    		$res = $this->classLeaveQuota->editLeaveQuota();

    		$this->assertNotNull($res, "Didn't add non exsistant record - $i ");
        }
    }
    public function testEditLeaveQuota1() {
        $expected[] = array(date('Y'), "LTY011", "Casual", "18");
        $expected[] = array(date('Y'), "LTY010", "Medical", "15");

        for ($i=0; $i < count($expected); $i++) {

			$this->classLeaveQuota->setYear($expected[$i][0]);
    		$this->classLeaveQuota->setLeaveTypeId($expected[$i][1]);
    		$this->classLeaveQuota->setNoOfDaysAllotted($expected[$i][3]);
    		$this->classLeaveQuota->setEmployeeId("011");

    		$res = $this->classLeaveQuota->editLeaveQuota();

    		$this->assertNotNull($res, "Addition failed - $i ");
        }

    	$res = $this->classLeaveQuota->fetchLeaveQuota("011");

        $this->assertNotNull($res, "No record found ");

        $this->assertEquals(count($res), 2, "Number of records found is not accurate ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getYear(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeId(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getNoOfDaysAllotted(), $expected[$i][3], "Didn't return expected result ");
        }
    }

    /**
     * @todo Implement testDeleteLeaveQuota().
     */
    /*public function testDeleteLeaveQuota() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }*/

    /**
     * @todo Implement testFetchLeaveQuota().
     */
    public function testFetchLeaveQuota() {
        $res = $this->classLeaveQuota->fetchLeaveQuota("015");

        $this->assertNull($res, "Retured non exsistant record ");
    }

    public function testFetchLeaveQuotaAccuracy() {

        $res = $this->classLeaveQuota->fetchLeaveQuota("012");

        $this->assertNotNull($res, "No record found ");

        $this->assertEquals(count($res), 2, "Number of records found is not accurate ");

        $expected[] = array(date('Y'), "LTY011", "Casual", "20");
        $expected[] = array(date('Y'), "LTY010", "Medical", "10");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getYear(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeId(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getNoOfDaysAllotted(), $expected[$i][3], "Didn't return expected result ");
        }
    }

    /**
     * Test for copyLeaveBroughtForward()
     */

	public function testCopyLeaveBroughtForward() {

		$broughtForward = new LeaveQuota();

		$res = $broughtForward->copyLeaveBroughtForward(2009,2010);

		$this->assertTrue($res);

		$query = "SELECT * FROM hs_hr_employee_leave_quota WHERE year = '2010' AND leave_type_id = 'LTY012' AND employee_id = '16'";
		$result = mysql_query($query);

		$row = mysql_fetch_array($result);

		$this->assertEquals(10, $row['leave_brought_forward'], $row['leave_brought_forward']);
	}


	public function testCheckLeaveBroughtForward() {
		$broughtForward = new LeaveQuota();
		$year = date('Y') - 1;
		$this->assertTrue($broughtForward->checkBroughtForward($year));
	}

}

// Call LeaveQuotaTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "LeaveQuotaTest::main") {
    LeaveQuotaTest::main();
}
?>
