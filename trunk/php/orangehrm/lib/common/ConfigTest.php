<?php
// Call ConfigTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'ConfigTest::main');
}

require_once 'PHPUnit/Framework.php';

require_once "testConf.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

require_once 'Config.php';

/**
 * Test class for Config.
 * Generated by PHPUnit on 2008-02-18 at 18:37:33.
 */
class ConfigTest extends PHPUnit_Framework_TestCase {

	private $oldTimesheetSetValue;
	private $leaveBroughtForwardSet;
	private $leaveBroughtForwardGet;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('ConfigTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {

    	$conf = new Conf();
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
        mysql_select_db($conf->dbname);

    	$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '0000-00-00' WHERE `key` = 'hsp_accrued_last_updated'"));
    	$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '0000-00-00' WHERE `key` = 'hsp_used_last_updated'"));

		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key` = 'timesheet_period_set'");

		if (mysql_num_rows($result) == 0) {
		    $this->oldTimesheetSetValue = false;
		} else {
			$row = mysql_fetch_array($result, MYSQL_NUM);
			$oldValue = $row[0];
		}

		// For LeaveBroughtForward Setter
		$result = mysql_query("SELECT `key` FROM `hs_hr_config` WHERE `key` = 'LeaveBroughtForward".date('Y')."'");
		if (mysql_num_rows($result) == 0) {
			$this->leaveBroughtForwardSet = false;
		} else {
			$this->assertTrue(mysql_query("DELETE FROM `hs_hr_config` WHERE `key` = 'LeaveBroughtForward".date('Y')."'"), mysql_error());
		    $this->leaveBroughtForwardSet = true;
		}

		// For Leave BroughtForward Getter
		$result = mysql_query("SELECT `key` FROM `hs_hr_config` WHERE `key` = 'LeaveBroughtForward".(date('Y')+1)."'");
		if (mysql_num_rows($result) == 0) {
		    $this->assertTrue(mysql_query("INSERT INTO `hs_hr_config` (`key`, `value`) VALUES('LeaveBroughtForward".(date('Y')+1)."', 'set')"), mysql_error());
			$this->leaveBroughtForwardGet = false;
		} else {
		    $this->leaveBroughtForwardGet = true;
		}

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {

    	$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '0000-00-00' WHERE `key` = 'hsp_accrued_last_updated'"));
    	$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '0000-00-00' WHERE `key` = 'hsp_used_last_updated'"));

		if ($this->oldTimesheetSetValue === false) {
		    $this->assertTrue(mysql_query("DELETE FROM `hs_hr_config` WHERE `key` = 'timesheet_period_set'"));
		} else {
		    $this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '$this->oldTimesheetSetValue' WHERE `key` = 'timesheet_period_set'"));
		}

		// For LeaveBroghtForward Setter
		if ($this->leaveBroughtForwardSet === false) {
		    $this->assertTrue(mysql_query("DELETE FROM `hs_hr_config` WHERE `key` = 'LeaveBroughtForward".date('Y')."'"), mysql_error());
		} else {
			$result = mysql_query("SELECT `key` FROM `hs_hr_config` WHERE `key` = 'LeaveBroughtForward".date('Y')."'");
			if (mysql_num_rows($result) == 0) {
			    $this->assertTrue(mysql_query("INSERT INTO `hs_hr_config` (`key`, `value`) VALUES('LeaveBroughtForward".date('Y')."', 'set')"), mysql_error());
			}
 		}

		// For LeaveBroughtForward Getter
		if ($this->leaveBroughtForwardGet === false) {
		    $this->assertTrue(mysql_query("DELETE FROM `hs_hr_config` WHERE `key` = 'LeaveBroughtForward".(date('Y')+1)."'"), mysql_error());
		}
    }

    public function testSetHspAccruedLastUpdated() {

    	// Testing for invalid date formats.
    	try {
			Config::setHspAccruedLastUpdated("dsereregg");
			$this->fail("Invalid dates are allowed");
    	} catch (Exception $e) {}

		// Testing without giving a key, 'key' value already exists.
		Config::setHspAccruedLastUpdated("2008-02-18");
		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key`='hsp_accrued_last_updated'");
		$resultArray = mysql_fetch_array($result);
		$this->assertEquals($resultArray[0], "2008-02-18");

		// Testing by giving a key, 'key' value already exists.
		Config::setHspAccruedLastUpdated("2008-02-27", "hsp_accrued_last_updated");
		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key`='hsp_accrued_last_updated'");
		$resultArray = mysql_fetch_array($result);
		$this->assertEquals($resultArray[0], "2008-02-27");

		// Testing by giving a key, 'key' doesn't exist.
		Config::setHspAccruedLastUpdated("1000-01-01", "this_should_not_exist");
		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key`='this_should_not_exist'");
		$resultArray = mysql_fetch_array($result);
		$this->assertEquals($resultArray[0], "1000-01-01");

		$this->assertTrue(mysql_query("DELETE FROM `hs_hr_config` WHERE `key`='this_should_not_exist'"));

    }

    public function testGetHspAccruedLastUpdated() {

		// Testing normal usage.
		$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '2008-02-25' WHERE `key` = 'hsp_accrued_last_updated'"));

		$this->assertNotNull(Config::getHspAccruedLastUpdated());
		$this->assertEquals(Config::getHspAccruedLastUpdated(), "2008-02-25");

    }

    public function testSetHspUsedLastUpdated() {

    	// Testing for invalid date formats.
    	try {
			Config::setHspUsedLastUpdated("dsereregg");
			$this->fail("Invalid dates are allowed");
    	} catch (Exception $e) {}

		// Testing without giving a key, 'key' value already exists.
		Config::setHspUsedLastUpdated("2008-03-18");
		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key`='hsp_used_last_updated'");
		$resultArray = mysql_fetch_array($result);
		$this->assertEquals($resultArray[0], "2008-03-18");

		// Testing by giving a key, 'key' value already exists.
		Config::setHspUsedLastUpdated("2008-03-27", "hsp_used_last_updated");
		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key`='hsp_used_last_updated'");
		$resultArray = mysql_fetch_array($result);
		$this->assertEquals($resultArray[0], "2008-03-27");

		// Testing by giving a key, 'key' doesn't exist.
		Config::setHspUsedLastUpdated("1000-01-01", "this_should_not_exist");
		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key`='this_should_not_exist'");
		$resultArray = mysql_fetch_array($result);
		$this->assertEquals($resultArray[0], "1000-01-01");

		$this->assertTrue(mysql_query("DELETE FROM `hs_hr_config` WHERE `key`='this_should_not_exist'"));

    }

    public function testGetHspUsedLastUpdated() {

		// Testing normal usage.
		$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = '2008-03-25' WHERE `key` = 'hsp_used_last_updated'"));

		$this->assertNotNull(Config::getHspUsedLastUpdated());
		$this->assertEquals(Config::getHspUsedLastUpdated(), "2008-03-25");

    }

	public function testSetTimePeriodSet() {

		Config::setTimePeriodSet('Yes');
		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key` = 'timesheet_period_set'");
		$row = mysql_fetch_array($result, MYSQL_NUM);
		$value = $row[0];
		$this->assertEquals('Yes', $value);

		Config::setTimePeriodSet('No');
		$result = mysql_query("SELECT `value` FROM `hs_hr_config` WHERE `key` = 'timesheet_period_set'");
		$row = mysql_fetch_array($result, MYSQL_NUM);
		$value = $row[0];
		$this->assertEquals('No', $value);

		try {
		    Config::setTimePeriodSet('ABC');
		    $this->fail('Invalid arguments are allowed. Did not throw an exception');
		} catch(Exception $e) {
		    $this->assertEquals("Given value for TimeSheetPeriodSet should be 'Yes' or 'No'", $e->getMessage());
		}

	}

	public function testGetTimePeriodSet() {

		$this->assertFalse(Config::getTimePeriodSet());

		if ($this->oldTimesheetSetValue === false) {
		    $this->assertTrue(mysql_query("INSERT INTO `hs_hr_config` VALUES ('timesheet_period_set', 'Yes')"));
		} else {
		    $this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = 'Yes' WHERE `key` = 'timesheet_period_set'"));
		}
		$this->assertTrue(Config::getTimePeriodSet());

		$this->assertTrue(mysql_query("UPDATE `hs_hr_config` SET `value` = 'No' WHERE `key` = 'timesheet_period_set'"));
		$this->assertFalse(Config::getTimePeriodSet());

	}

	public function testSetLeaveBroughtForward() {
		Config::setLeaveBroughtForward(date('Y'));
		$result = mysql_query("SELECT `key`, `value` FROM `hs_hr_config` WHERE `key` = 'LeaveBroughtForward".date('Y')."'");
		$row = mysql_fetch_array($result);
		$this->assertEquals("LeaveBroughtForward".date('Y'), $row['key'], "Key is incorrect");
		$this->assertEquals("set", $row['value'], "Value is incorrect");

		// Setting LeaveBroughtForward should not be allowed more than once
		try {
		    Config::setLeaveBroughtForward(date('Y'));
		    $this->fail("Setting LeaveBroughtForward is allowed more than once");
		} catch (Exception $e) {}
	}

	public function testGetLeaveBroughtForward() {
	    $this->assertTrue(Config::getLeaveBroughtForward((date('Y')+1)));
	    $this->assertFalse(Config::getLeaveBroughtForward('4000'));
	}

}

// Call ConfigTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'ConfigTest::main') {
    ConfigTest::main();
}
?>
