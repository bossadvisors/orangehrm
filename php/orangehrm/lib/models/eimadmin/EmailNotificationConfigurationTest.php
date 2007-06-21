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


// Call EmailNotificationConfigurationTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "EmailNotificationConfigurationTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

require_once 'EmailNotificationConfiguration.php';

/**
 * Test class for EmailNotificationConfiguration.
 * Generated by PHPUnit_Util_Skeleton on 2007-02-20 at 10:17:50.
 */
class EmailNotificationConfigurationTest extends PHPUnit_Framework_TestCase {
	public $classNotifications = null;
    public $connection = null;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("EmailNotificationConfigurationTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
		$this->classNotifications = new EmailNotificationConfiguration('USR010');

		$conf = new Conf();

    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);

    	mysql_query("INSERT INTO `hs_hr_users` VALUES ('USR010', 'demo1', 'fe01ce2a7fbac8fafaed7c982a04e229', 'Admin', NULL, NULL, NULL, 'Yes', '1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Enabled', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'USG001')");
		mysql_query("INSERT INTO `hs_hr_users` VALUES ('USR011', 'demo2', 'fe01ce2a7fbac8fafaed7c982a04e229', 'Admin', NULL, NULL, NULL, 'Yes', '1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Enabled', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'USG001')");

    	mysql_query("INSERT INTO `hs_hr_mailnotifications` (`user_id`, `notification_type_id`, `status`) VALUES ('USR010', 0, 1)");
    	mysql_query("INSERT INTO `hs_hr_mailnotifications` (`user_id`, `notification_type_id`, `status`) VALUES ('USR010', 2, 0)");
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
		/*mysql_query("DELETE FROM `hs_hr_users` WHERE `id` = 'USR010'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_users` WHERE `id` = 'USR011'", $this->connection);
*/
		mysql_query("TRUNCATE TABLE `hs_hr_mailnotifications`", $this->connection);
    }

    public function testFetchNotifcationStatus() {
		$res = $this->classNotifications->fetchNotifcationStatus();

		$expected[0] = array('USR010', 0, 1);
		$expected[1] = array('USR010', 2, 0);

		$this->assertNotNull($res, 'Unexpected behavior');
		$this->assertTrue(is_array($res), 'Invalid result type');

		//$this->assertEquals(2, count($res), 'Invallid Number of records');

		for ($i=0; $i<count($expected); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getUserId(), 'Invallid employee id');
			$this->assertEquals($expected[$i][1], $res[$i]->getNotifcationTypeId(), 'Invallid notification');
			$this->assertEquals($expected[$i][2], $res[$i]->getNotificationStatus(), 'Invallid notification status');
		}
    }

    public function testFetchNotifcationStatus1() {
		$obj = new EmailNotificationConfiguration('USR092');

		$res = $obj->fetchNotifcationStatus();

		$this->assertNull($res, 'Unexpected behavior');
    }

    public function testUpdateNotificationStatus() {

		$this->classNotifications->setUserId('USR011');
 		$this->classNotifications->setNotifcationTypeId(0);
		$this->classNotifications->setNotificationStatus(1);

 		$res = $this->classNotifications->updateNotificationStatus();

 		$this->assertTrue($res, 'Update failed');

 		$res = $this->classNotifications->fetchNotifcationStatus();

		$expected[0] = array('USR011', 0, 1);

		$this->assertNotNull($res, 'Unexpected behavior');
		$this->assertTrue(is_array($res), 'Invalid result type');

		$this->assertEquals(1, count($res), 'Invallid Number of records');

		for ($i=0; $i<count($expected); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getUserId(), 'Invallid employee id');
			$this->assertEquals($expected[$i][1], $res[$i]->getNotifcationTypeId(), 'Invallid notification');
			$this->assertEquals($expected[$i][2], $res[$i]->getNotificationStatus(), 'Invallid notification status');
		}
    }


 	public function testUpdateNotificationStatus1() {

		$this->classNotifications->setUserId('USR010');
 		$this->classNotifications->setNotifcationTypeId(0);
		$this->classNotifications->setNotificationStatus(0);

 		$res = $this->classNotifications->updateNotificationStatus();

 		$this->assertTrue($res, 'Update failed');

		$res = $this->classNotifications->fetchNotifcationStatus();

		$expected[0] = array('USR010', 0, 0);
		$expected[1] = array('USR010', 2, 0);

		$this->assertNotNull($res, 'Unexpected behavior');
		$this->assertTrue(is_array($res), 'Invalid result type');

		$this->assertEquals(2, count($res), 'Invallid Number of records');

		for ($i=0; $i<count($res); $i++) {
			$this->assertEquals($expected[$i][0], $res[$i]->getUserId(), 'Invallid employee id');
			$this->assertEquals($expected[$i][1], $res[$i]->getNotifcationTypeId(), 'Invallid notification');
			$this->assertEquals($expected[$i][2], $res[$i]->getNotificationStatus(), 'Invallid notification status');
		}
    }

}

// Call EmailNotificationConfigurationTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "EmailNotificationConfigurationTest::main") {
    EmailNotificationConfigurationTest::main();
}
?>
