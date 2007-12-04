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


// Call HolidaysTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "HolidaysTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

$_SESSION['WPATH'] = WPATH;

require_once "Leave.php";
require_once 'Holidays.php';
require_once ROOT_PATH."/lib/confs/Conf.php";
require_once ROOT_PATH . '/lib/common/UniqueIDGenerator.php';

/**
 * Test class for Holidays.
 * Generated by PHPUnit_Util_Skeleton on 2006-12-29 at 13:24:41.
 */
class HolidaysTest extends PHPUnit_Framework_TestCase {
    public $classHoliday = null;
    public $connection = null;
	/**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("HolidaysTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classHoliday = new Holidays();

    	$conf = new Conf();

    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
        mysql_select_db($conf->dbname);

    	mysql_query("TRUNCATE TABLE `hs_hr_holidays`", $this->connection);
    	mysql_query("INSERT INTO `hs_hr_holidays` (`holiday_id`, `description`, `date`, `recurring`, `length`) VALUES (10, 'Independence', '".date('Y')."-07-04', ".Holidays::HOLIDAYS_RECURRING.", 8)");
    	mysql_query("INSERT INTO `hs_hr_holidays` (`holiday_id`, `description`, `date`, `recurring`, `length`) VALUES (11, 'Poya', '".date('Y')."-01-04', ".Holidays::HOLIDAYS_NOT_RECURRING.", 4)");
        UniqueIDGenerator::getInstance()->initTable();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	mysql_query("TRUNCATE TABLE `hs_hr_holidays`", $this->connection);
    }

    public function testIsHoliday1() {
    	$holiday = $this->classHoliday;
    	$expected[0] = array(date('Y').'-07-04', 8);
    	$expected[1] = array(date('Y').'-01-04', 4);

    	$res = $holiday->isHoliday($expected[0][0]);

        $this->assertNotNull($res, 'Unexpected behavior');
        $this->assertEquals($res, $expected[0][1], 'Invalid Length');

        $res = $holiday->isHoliday($expected[1][0]);

        $this->assertNotNull($res, 'Unexpected behavior');
        $this->assertEquals($res, $expected[1][1], 'Invalid Length');
    }

    public function testIsHoliday2() {

    	$holiday = $this->classHoliday;
    	$expected[0] = array((date('Y')+1).'-01-04', 4);

        $res = $holiday->isHoliday($expected[0][0]);

        $this->assertNull($res, 'Unexpected behavior');
    }

    public function testListHolidays1() {
    	$holiday = $this->classHoliday;

    	$res = $holiday->listHolidays();

    	$this->assertNotNull($res, 'Exsisting records not found');

    	$expected[0] = array(11, date('Y').'-01-04', 'Poya', Holidays::HOLIDAYS_NOT_RECURRING, 4);
    	$expected[1] = array(10, date('Y').'-07-04', 'Independence', Holidays::HOLIDAYS_RECURRING, 8);

    	$this->assertEquals(count($res), count($expected), 'Invalid Number of records found ('.count($res).')');

    	for ($i=0; $i<count($expected); $i++) {
    		$this->assertEquals($res[$i]->getHolidayId(), $expected[$i][0], 'Invalid Hoiday Id');
    		$this->assertEquals($res[$i]->getDate(), $expected[$i][1], 'Invalid Date');
    		$this->assertEquals($res[$i]->getDescription(), $expected[$i][2], 'Invalid Description');
    		$this->assertEquals($res[$i]->getRecurring(), $expected[$i][3], 'Invalid Recurring Status');
    		$this->assertEquals($res[$i]->getLength(), $expected[$i][4], 'Invalid Length');
    	}
    }

    public function testListHolidays2() {
    	$holiday = $this->classHoliday;

    	$res = $holiday->listHolidays(date('Y')+1);

    	$this->assertNotNull($res, 'Exsisting records not found');

    	$expected[0] = array(10, (date('Y')+1).'-07-04', 'Independence', Holidays::HOLIDAYS_RECURRING, 8);

    	$this->assertEquals(count($res), count($expected), 'Invalid Number of records found ('.count($res).')');

    	for ($i=0; $i<count($expected); $i++) {
    		$this->assertEquals($res[$i]->getHolidayId(), $expected[$i][0], 'Invalid Hoiday Id');
    		$this->assertEquals($res[$i]->getDate(), $expected[$i][1], 'Invalid Date');
    		$this->assertEquals($res[$i]->getDescription(), $expected[$i][2], 'Invalid Description');
    		$this->assertEquals($res[$i]->getRecurring(), $expected[$i][3], 'Invalid Recurring Status');
    		$this->assertEquals($res[$i]->getLength(), $expected[$i][4], 'Invalid Length');
    	}
    }

    public function testFetchHoliday1() {
    	$holiday = $this->classHoliday;

    	$res = $holiday->fetchHoliday('97');

    	$this->assertNull($res, 'Non exsistent record found');
    }

    public function testFetchHoliday2() {
    	$holiday = $this->classHoliday;

    	$expected[0] = array(10, date('Y').'-07-04', 'Independence', Holidays::HOLIDAYS_RECURRING, 8);

    	$res = $holiday->fetchHoliday($expected[0][0]);

    	$this->assertNotNull($res, 'Exsisting records not found');

    	$this->assertEquals(count($res), count($expected), 'Invalid Nuber of records found');

    	for ($i=0; $i<count($expected); $i++) {
    		$this->assertEquals($res[$i]->getHolidayId(), $expected[$i][0], 'Invalid Hoiday Id');
    		$this->assertEquals($res[$i]->getDate(), $expected[$i][1], 'Invalid Date');
    		$this->assertEquals($res[$i]->getDescription(), $expected[$i][2], 'Invalid Description');
    		$this->assertEquals($res[$i]->getRecurring(), $expected[$i][3], 'Invalid Recurring Status');
    		$this->assertEquals($res[$i]->getLength(), $expected[$i][4], 'Invalid Length');
    	}
    }

    public function testAdd() {
        $holiday = $this->classHoliday;

        $expected[0] = array(11, date('Y').'-01-04', 'Poya', Holidays::HOLIDAYS_NOT_RECURRING, 4);
    	$expected[1] = array(10, date('Y').'-07-04', 'Independence', Holidays::HOLIDAYS_RECURRING, 8);
        $expected[2] = array(12, date('Y').'-12-25', 'Christmas', Holidays::HOLIDAYS_RECURRING, 8);

        $holiday->setDescription($expected[2][2]);
        $holiday->setDate($expected[2][1]);
        $holiday->setRecurring($expected[2][3]);
        $holiday->setLength($expected[2][4]);

        $holiday->add();

		// Set the expected ID for newly added holiday
		$expected[2][0] = $holiday->getHolidayId();

        $res = $holiday->listHolidays();

    	$this->assertNotNull($res, 'Exsisting records not found');

    	$this->assertEquals(count($res), count($expected), 'Invalid Nuber of records found');

        for ($i=0; $i<count($expected); $i++) {
    		$this->assertEquals($res[$i]->getHolidayId(), $expected[$i][0], 'Invalid Hoiday Id');
    		$this->assertEquals($res[$i]->getDate(), $expected[$i][1], 'Invalid Date');
    		$this->assertEquals($res[$i]->getDescription(), $expected[$i][2], 'Invalid Description');
    		$this->assertEquals($res[$i]->getRecurring(), $expected[$i][3], 'Invalid Recurring Status');
    		$this->assertEquals($res[$i]->getLength(), $expected[$i][4], 'Invalid Length');
    	}
    }

    public function testEdit() {
       	$holiday = $this->classHoliday;
        $expected[0] = array(11, date('Y').'-01-04', 'Poya', Holidays::HOLIDAYS_NOT_RECURRING, 4);
        $expected[1] = array(10, date('Y').'-05-01', 'May Day', Holidays::HOLIDAYS_RECURRING, 8);

        $holiday->setHolidayId($expected[1][0]);
        $holiday->setDescription($expected[1][2]);
        $holiday->setDate($expected[1][1]);
        $holiday->setRecurring($expected[1][3]);
        $holiday->setLength($expected[1][4]);

        $holiday->edit();

        $res = $holiday->listHolidays();

    	$this->assertNotNull($res, 'Exsisting records not found');

    	$this->assertEquals(count($res), count($expected), 'Invalid Nuber of records found');

        for ($i=0; $i<count($expected); $i++) {
    		$this->assertEquals($res[$i]->getHolidayId(), $expected[$i][0], 'Invalid Hoiday Id');
    		$this->assertEquals($res[$i]->getDate(), $expected[$i][1], 'Invalid Date');
    		$this->assertEquals($res[$i]->getDescription(), $expected[$i][2], 'Invalid Description');
    		$this->assertEquals($res[$i]->getRecurring(), $expected[$i][3], 'Invalid Recurring Status');
    		$this->assertEquals($res[$i]->getLength(), $expected[$i][4], 'Invalid Length');
    	}

    }

    public function testDelete() {
    	$holiday = $this->classHoliday;

       	$expected[0] = array(11, date('Y').'-01-04', 'Poya', Holidays::HOLIDAYS_NOT_RECURRING, 4);
    	$expected[1] = array(10, date('Y').'-07-04', 'Independence', Holidays::HOLIDAYS_RECURRING, 8);

        $res = $holiday->listHolidays();

    	$this->assertNotNull($res, 'Exsisting records not found');

    	$this->assertEquals(count($res), count($expected), 'Invalid Nuber of records found');

        for ($i=0; $i<count($expected); $i++) {
    		$this->assertEquals($res[$i]->getHolidayId(), $expected[$i][0], 'Invalid Hoiday Id');
    		$this->assertEquals($res[$i]->getDate(), $expected[$i][1], 'Invalid Date');
    		$this->assertEquals($res[$i]->getDescription(), $expected[$i][2], 'Invalid Description');
    		$this->assertEquals($res[$i]->getRecurring(), $expected[$i][3], 'Invalid Recurring Status');
    		$this->assertEquals($res[$i]->getLength(), $expected[$i][4], 'Invalid Length');
    	}

        $holiday->setHolidayId($expected[0][0]);
        $holiday->delete();

        $res = $holiday->listHolidays();

    	$this->assertNotNull($res, 'Exsisting records not found');

    	array_shift($expected);

    	$this->assertEquals(count($res), count($expected), 'Invalid Nuber of records found');

       	for ($i=0; $i<count($expected); $i++) {
    		$this->assertEquals($res[$i]->getHolidayId(), $expected[$i][0], 'Invalid Hoiday Id');
    		$this->assertEquals($res[$i]->getDate(), $expected[$i][1], 'Invalid Date');
    		$this->assertEquals($res[$i]->getDescription(), $expected[$i][2], 'Invalid Description');
    		$this->assertEquals($res[$i]->getRecurring(), $expected[$i][3], 'Invalid Recurring Status');
    		$this->assertEquals($res[$i]->getLength(), $expected[$i][4], 'Invalid Length');
       	}
    }
}

// Call HolidaysTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "HolidaysTest::main") {
    HolidaysTest::main();
}
?>
