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


// Call TimesheetSubmissionPeriodTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "TimesheetSubmissionPeriodTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'TimesheetSubmissionPeriod.php';

/**
 * Test class for TimesheetSubmissionPeriod.
 * Generated by PHPUnit_Util_Skeleton on 2007-03-27 at 16:43:39.
 */
class TimesheetSubmissionPeriodTest extends PHPUnit_Framework_TestCase {
	public $classTimesheetSubmissionPeriod = null;
    public $connection = null;
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("TimesheetSubmissionPeriodTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
		$this->classTimesheetSubmissionPeriod = new TimesheetSubmissionPeriod();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	mysql_query("UPDATE `hs_hr_timesheet_submission_period` SET `start_day` = 1, `end_day` = 7 WHERE `timesheet_period_id` = 1");
    }

    public function testSaveTimesheetSubmissionPeriod() {
    	$expected[0] = array(1, 'week', 7, 1, 1, 7, 'Weekly');

    	$this->classTimesheetSubmissionPeriod->setTimesheetPeriodId(1);
    	$this->classTimesheetSubmissionPeriod->setStartDay($expected[0][4]);

    	try {
    		$res = $this->classTimesheetSubmissionPeriod->saveTimesheetSubmissionPeriod();
    	} catch (TimesheetSubmissionPeriodException $err) {
    		$errCode = $err->getCode();
    		$errMessage = $err->getMessage();

    		$this->assertEquals($errCode, -2, "Unexpected error code");
    		$this->assertEquals($errMessage, "Unable to determine the end date", "Unexpected error message");

    		return;
    	}

    	$this->fail('An expected Exception has not been raised.');
    }

    public function testSaveTimesheetSubmissionPeriod2() {
    	$expected[0] = array(1, 'week', 7, 1, 1, 7, 'Weekly');

    	$this->classTimesheetSubmissionPeriod->setTimesheetPeriodId(1);
    	$this->classTimesheetSubmissionPeriod->setStartDay($expected[0][4]);
    	$this->classTimesheetSubmissionPeriod->setFrequency($expected[0][2]);

    	$res = $this->classTimesheetSubmissionPeriod->saveTimesheetSubmissionPeriod();

    	$this->assertFalse($res, "Saved a record which had no changes");
    }

    public function testSaveTimesheetSubmissionPeriod3() {
    	$expected[0] = array(1, 'week', 7, 1, 2, 1, 'Weekly');

    	$this->classTimesheetSubmissionPeriod->setTimesheetPeriodId(1);
    	$this->classTimesheetSubmissionPeriod->setStartDay($expected[0][4]);
    	$this->classTimesheetSubmissionPeriod->setFrequency($expected[0][2]);

    	$res = $this->classTimesheetSubmissionPeriod->saveTimesheetSubmissionPeriod();

    	$this->assertTrue($res, "Failed to save");

		$res = $this->classTimesheetSubmissionPeriod->fetchTimesheetSubmissionPeriods();

		$this->assertNotNull($res, "Returned nothing");

		$this->assertEquals(count($res), 1, "Didn't return the expected number of records");

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetPeriodId(), "Invalid timesheet period id");
			$this->assertEquals($expected[$i][1], $res[$i]->getName(), "Invalid timesheet period name");
			$this->assertEquals($expected[$i][2], $res[$i]->getFrequency(), "Invalid timesheet period frequency");
			$this->assertEquals($expected[$i][3], $res[$i]->getPeriod(), "Invalid timesheet period period");
			$this->assertEquals($expected[$i][4], $res[$i]->getStartDay(), "Invalid timesheet period start day");
			$this->assertEquals($expected[$i][5], $res[$i]->getEndDay(), "Invalid timesheet period end day");
			$this->assertEquals($expected[$i][6], $res[$i]->getDescription(), "Invalid timesheet period description");
		}
    }

    public function testFetchTimesheetSubmissionPeriods() {
    	$this->classTimesheetSubmissionPeriod->setTimesheetPeriodId(1);

		$res = $this->classTimesheetSubmissionPeriod->fetchTimesheetSubmissionPeriods();

		$expected[0] = array(1, 'week', 7, 1, 1, 7, 'Weekly');

		$this->assertNotNull($res, "Returned nothing");

		$this->assertEquals(count($res), 1, "Didn't return the expected number of records");

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getTimesheetPeriodId(), "Invalid timesheet period id");
			$this->assertEquals($expected[$i][1], $res[$i]->getName(), "Invalid timesheet period name");
			$this->assertEquals($expected[$i][2], $res[$i]->getFrequency(), "Invalid timesheet period frequency");
			$this->assertEquals($expected[$i][3], $res[$i]->getPeriod(), "Invalid timesheet period period");
			$this->assertEquals($expected[$i][4], $res[$i]->getStartDay(), "Invalid timesheet period start day");
			$this->assertEquals($expected[$i][5], $res[$i]->getEndDay(), "Invalid timesheet period end day");
			$this->assertEquals($expected[$i][6], $res[$i]->getDescription(), "Invalid timesheet period description");
		}
    }
}

// Call TimesheetSubmissionPeriodTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "TimesheetSubmissionPeriodTest::main") {
    TimesheetSubmissionPeriodTest::main();
}
?>
