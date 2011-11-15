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

// Call ProjectAdminGatewayTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "ProjectAdminGatewayTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";
require_once ROOT_PATH."/lib/confs/Conf.php";
require_once ROOT_PATH . '/lib/exception/ExceptionHandler.php';

require_once ROOT_PATH . "/lib/models/eimadmin/Projects.php";
require_once ROOT_PATH . "/lib/models/eimadmin/ProjectAdminGateway.php";

/**
 * Test class for ProjectAdminGateway.
 * Generated by PHPUnit_Util_Skeleton on 2007-07-11 at 17:15:40.
 */
class ProjectAdminGatewayTest extends PHPUnit_Framework_TestCase {

	private $errorLevel;
	private $errorStr;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("ProjectAdminGatewayTest");
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

		mysql_query("TRUNCATE TABLE `ohrm_project`", $this->connection);
        mysql_query("TRUNCATE TABLE `ohrm_project_admin`", $this->connection);
		mysql_query("TRUNCATE TABLE `ohrm_customer`", $this->connection);
        mysql_query("TRUNCATE TABLE `hs_hr_employee`", $this->connection);

		// Insert a project and customer and employees for use in the test
        mysql_query("INSERT INTO ohrm_customer(customer_id, name, description, is_deleted) " .
        			"VALUES(1, 'Test customer', 'description', 0)");
        mysql_query("INSERT INTO ohrm_project(project_id, customer_id, name, description, is_deleted) " .
        			"VALUES(1, 1, 'Test project 1', 'a test proj 1', 0)");
        mysql_query("INSERT INTO ohrm_project(project_id, customer_id, name, description, is_deleted) " .
        			"VALUES(2, 1, 'Test project 2', 'a test proj 2', 0)");
        mysql_query("INSERT INTO hs_hr_employee(emp_number, employee_id, emp_lastname, emp_firstname, emp_middle_name) " .
        			"VALUES(1, '0011', 'Rajasinghe', 'Saman', 'Marlon')");
        mysql_query("INSERT INTO hs_hr_employee(emp_number, employee_id, emp_lastname, emp_firstname, emp_middle_name) " .
        			"VALUES(2, '0022', 'Jayasinghe', 'Aruna', 'Shantha')");
        mysql_query("INSERT INTO hs_hr_employee(emp_number, employee_id, emp_lastname, emp_firstname, emp_middle_name) " .
        			"VALUES(3, '0034', 'Ranasinghe', 'Nimal', 'Bandara')");

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
		mysql_query("TRUNCATE TABLE `ohrm_project`", $this->connection);
        mysql_query("TRUNCATE TABLE `ohrm_project_admin`", $this->connection);
		mysql_query("TRUNCATE TABLE `ohrm_customer`", $this->connection);
        mysql_query("TRUNCATE TABLE `hs_hr_employee`", $this->connection);
    }

    /**
     * @todo Implement testAddAdmin().
     */
    public function testAddAdmin() {

		$gw = new ProjectAdminGateway();

		// Verify that invalid project id's emp numbers throw exceptions
		try {
			$gw->addAdmin($projectId = "", $empNumber = 12);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			$this->assertEquals(0, $this->_countAdmins(), "No rows should be inserted");
		}

		try {
			$gw->addAdmin($projectId = "test", $empNumber = 12);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			$this->assertEquals(0, $this->_countAdmins(), "No rows should be inserted");
		}

		try {
			$gw->addAdmin($projectId = 1, $empNumber = "");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			$this->assertEquals(0, $this->_countAdmins(), "No rows should be inserted");
		}

		try {
			$gw->addAdmin($projectId = 1, $empNumber = "xyz");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			$this->assertEquals(0, $this->_countAdmins(), "No rows should be inserted");
		}

		// Verify that add using non existent projects and employee id's throws an error
		$this->_clearError();
		set_error_handler(array($this, 'errorHandler'));

		$this->assertFalse($gw->addAdmin($projectId = 11, $empNumber = 12));

		restore_error_handler();
		$this->assertNotNull($this->errorLevel);
		$this->assertEquals(0, $this->_countAdmins());

		// valid project, invalid employee
		$this->_clearError();
		set_error_handler(array($this, 'errorHandler'));

		$this->assertFalse($gw->addAdmin($projectId = 1, $empNumber = 4));

		restore_error_handler();
		$this->assertNotNull($this->errorLevel);
		$this->assertEquals(0, $this->_countAdmins());

		// invalid project, valid employee
		$this->_clearError();
		set_error_handler(array($this, 'errorHandler'));

		$this->assertFalse($gw->addAdmin($projectId = 12, $empNumber = 1));

		restore_error_handler();
		$this->assertNotNull($this->errorLevel);
		$this->assertEquals(0, $this->_countAdmins());

		// valid admin
		$gw->addAdmin($projectId = 1, $empNumber = 2);
		$this->assertEquals(1, $this->_countAdmins());
		$this->assertEquals(1, $this->_countAdmins("project_id = 1 AND emp_number = 2"));

		// adding the same admin again should not change anything
		$gw->addAdmin($projectId = 1, $empNumber = 2);
		$this->assertEquals(1, $this->_countAdmins());
		$this->assertEquals(1, $this->_countAdmins("project_id = 1 AND emp_number = 2"));

		// Add the same employee as admin to a different project
		$gw->addAdmin($projectId = 2, $empNumber = 2);
		$this->assertEquals(2, $this->_countAdmins());
		$this->assertEquals(2, $this->_countAdmins("emp_number = 2"));
		$this->assertEquals(1, $this->_countAdmins("project_id = 2 AND emp_number = 2"));
		$this->assertEquals(1, $this->_countAdmins("project_id = 2 AND emp_number = 2"));

    }

    /**
     * Test removeAdmin() method
     */
    public function testRemoveAdmin() {

		$gw = new ProjectAdminGateway();
		$this->_insertAdmins();

		// Verify that invalid project id's emp numbers throw exceptions
		try {
			$gw->removeAdmin($projectId = "", $empNumber = 12);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			$this->assertEquals(3, $this->_countAdmins(), "No rows should be removed");
		}

		try {
			$gw->removeAdmin($projectId = "test", $empNumber = 12);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			$this->assertEquals(3, $this->_countAdmins(), "No rows should be removed");
		}

		try {
			$gw->removeAdmin($projectId = 1, $empNumber = "");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			$this->assertEquals(3, $this->_countAdmins(), "No rows should be removed");
		}

		try {
			$gw->removeAdmin($projectId = 1, $empNumber = "xyz");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			$this->assertEquals(3, $this->_countAdmins(), "No rows should be removed");
		}

    	// empNumber invalid, project invalid
		$this->assertFalse($gw->removeAdmin($projectId = 111, $empNumber = 23));
		$this->assertEquals(3, $this->_countAdmins());

    	// empNumber invalid, project valid
		$this->assertFalse($gw->removeAdmin($projectId = 2, $empNumber = 9));
		$this->assertEquals(3, $this->_countAdmins());

    	// empNumber valid but not admin, project invalid
		$this->assertFalse($gw->removeAdmin($projectId = 13, $empNumber = 3));
		$this->assertEquals(3, $this->_countAdmins());

    	// empNumber valid but not admin, project valid
		$this->assertFalse($gw->removeAdmin($projectId = 1, $empNumber = 3));
		$this->assertEquals(3, $this->_countAdmins());

    	// empNumber valid, admin for different project.
		$this->assertFalse($gw->removeAdmin($projectId = 2, $empNumber = 1));
		$this->assertEquals(3, $this->_countAdmins());

    	// empNumber valid, admin for given project.
		$this->assertTrue($gw->removeAdmin($projectId = 1, $empNumber = 1));
		$this->assertEquals(2, $this->_countAdmins());
		$this->assertEquals(0, $this->_countAdmins("emp_number = 1"));

    	// attempt remove again.
		$this->assertFalse($gw->removeAdmin($projectId = 1, $empNumber = 1));
		$this->assertEquals(2, $this->_countAdmins());

		// Remove admin with multiple projects from one project
		$this->assertTrue($gw->removeAdmin($projectId = 1, $empNumber = 2));
		$this->assertEquals(1, $this->_countAdmins());
		$this->assertEquals(1, $this->_countAdmins("emp_number = 2 AND project_id = 2"));

    }

    /**
     * Tests removeAdmins() method.
     */
    public function testRemoveAdmins() {

		$gw = new ProjectAdminGateway();
		$this->_insertAdmins();

		// Verify that invalid project id's emp numbers throw exceptions
		try {
			$gw->removeAdmins($projectId = "", array(12));
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		try {
			$gw->removeAdmins($projectId = "test", array(12));
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		try {
			$gw->removeAdmins($projectId = null, array(12));
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		try {
			$gw->removeAdmins($projectId = 1, array(12, ""));
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		try {
			$gw->removeAdmins($projectId = 1, array(1, "xyz"));
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		try {
			$gw->removeAdmins($projectId = 1, null);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		// Pass empty array, valid project Id
		$this->assertEquals(0, $gw->removeAdmins($projectId = 1, $empList = array()));
		$this->assertEquals(3, $this->_countAdmins());

		// Remove one admin, invalid empNumber
		$this->assertEquals(0, $gw->removeAdmins($projectId = 1, $empList = array(12)));
		$this->assertEquals(3, $this->_countAdmins());

		// Remove one admin, valid empNumber but not admin
		$this->assertEquals(0, $gw->removeAdmins($projectId = 1, $empList = array(3)));
		$this->assertEquals(3, $this->_countAdmins());

		// Remove one admin, valid empNumber and admin but wrong project
		$this->assertEquals(0, $gw->removeAdmins($projectId = 2, $empList = array(1)));
		$this->assertEquals(3, $this->_countAdmins());

		// Remove one admin, valid empNumber and admin for given project
		$this->assertEquals(1, $gw->removeAdmins($projectId = 1, $empList = array(1)));
		$this->assertEquals(2, $this->_countAdmins());
		$this->assertEquals(0, $this->_countAdmins("emp_number = 1"));

		$this->_deleteAllAdmins();
		$this->_insertAdmins();

		// Remove two admins, one valid, the other invalid
		$this->assertEquals(1, $gw->removeAdmins($projectId = 1, $empList = array(2, 12)));
		$this->assertEquals(2, $this->_countAdmins());
		$this->assertEquals(1, $this->_countAdmins("emp_number = 2"));

		$this->_deleteAllAdmins();
		$this->_insertAdmins();

		// Remove two admins, both valid admins but invalid project Id
		$this->assertEquals(0, $gw->removeAdmins($projectId = 14, $empList = array(2, 1)));
		$this->assertEquals(3, $this->_countAdmins());

        $this->assertTrue(mysql_query("INSERT INTO ohrm_project_admin(emp_number, project_id) " .
        			"VALUES(3, 1)"));
		$this->assertEquals(1, mysql_affected_rows());

		// Remove three admins, both valid admins
		$this->assertEquals(3, $gw->removeAdmins($projectId = 1, $empList = array(1, 2, 3)));
		$this->assertEquals(1, $this->_countAdmins());
		$this->assertEquals(1, $this->_countAdmins("emp_number = 2 AND project_id = 2"));
    }

    /**
     * Tests getAdmins() method.
     */
    public function testGetAdmins() {

		$gw = new ProjectAdminGateway();

		// Verify that invalid project ids  throw exceptions
		try {
			$gw->getAdmins("");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		try {
			$gw->getAdmins("xier");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		try {
			$gw->getAdmins(null);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected
		}

		// Get admins for invalid project
		$list = $gw->getAdmins(12);
		$this->assertTrue(is_array($list));
		$this->assertEquals(0, count($list));

        mysql_query("INSERT INTO ohrm_project(project_id, customer_id, name, description, is_deleted) " .
        			"VALUES(21, 1, 'Test project 1', 'a test proj 1', 0)");

		// Get admins for valid project with no admins
		$list = $gw->getAdmins(21);
		$this->assertTrue(is_array($list));
		$this->assertEquals(0, count($list));

		$this->_deleteAllAdmins();
		$this->_insertAdmins();

		// Get admins for valid project with 1 admin
		$list = $gw->getAdmins(2);
		$this->assertTrue(is_array($list));
		$this->assertEquals(1, count($list));
		$admin = $list[0];
		$this->assertTrue($admin instanceof ProjectAdmin);
		$this->assertEquals(2, $admin->getEmpNumber());
		$this->assertEquals('Aruna', $admin->getFirstName());
		$this->assertEquals('Jayasinghe', $admin->getLastName());

		// Get admin for valid project with 2 admins
		$list = $gw->getAdmins(1);
		$this->assertTrue(is_array($list));
		$this->assertEquals(2, count($list));

		$validResults = array( 1 => array('Saman', 'Rajasinghe'), 2 => array('Aruna', 'Jayasinghe'));
		foreach ($list as $admin) {

			$empNo = $admin->getEmpNumber();
			$lastName = $admin->getLastName();;

			$this->assertTrue(array_key_exists($empNo, $validResults));
			$this->assertEquals($validResults[$empNo][0], $admin->getFirstName());
			$this->assertEquals($validResults[$empNo][1], $admin->getLastName());

			unset($validResults[$empNo]);
		}
    }

    /**
     * Tests the isAdmin() method.
     */
    public function testIsAdmin() {

		$gw = new ProjectAdminGateway();

		// Verify that invalid project id's emp numbers throw exceptions
		try {
			$gw->isAdmin($empNumber = 12, $projectId = "");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected.
		}

		try {
			$gw->isAdmin($empNumber = 12, $projectId = "test");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected.
		}

		try {
			$gw->isAdmin($empNumber = "", $projectId = 1);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected.
		}

		try {
			$gw->isAdmin($empNumber = "xyz", $projectId = 1);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected.
		}

		try {
			$gw->isAdmin($empNumber = 1, $projectId = null);
		} catch (ProjectAdminException $e) {
			$this->fail("null project id should be allowed.");
		}

		// valid employee but not admin
    	$this->assertFalse($gw->isAdmin($empNumber = 1, $projectId = 1));
    	$this->assertFalse($gw->isAdmin($empNumber = 1, $projectId = 11));
    	$this->assertFalse($gw->isAdmin($empNumber = 1));

    	// invalid emp number
    	$this->assertFalse($gw->isAdmin($empNumber = 13, $projectId = 1));
    	$this->assertFalse($gw->isAdmin($empNumber = 188, $projectId = 11));
    	$this->assertFalse($gw->isAdmin($empNumber = 15));

		$this->_insertAdmins();

		// valid admin, correct project.
    	$this->assertTrue($gw->isAdmin($empNumber = 1, $projectId = 1));

		// valid admin, without giving a project
		$this->assertTrue($gw->isAdmin($empNumber = 1));

		// valid admin, incorrect/invalid project.
    	$this->assertFalse($gw->isAdmin($empNumber = 1, $projectId = 2));
    	$this->assertFalse($gw->isAdmin($empNumber = 1, $projectId = 12));

    	// admin with multiple projects
    	$this->assertTrue($gw->isAdmin($empNumber = 2, $projectId = 1));
    	$this->assertTrue($gw->isAdmin($empNumber = 2, $projectId = 2));
    	$this->assertTrue($gw->isAdmin($empNumber = 2));
    	$this->assertFalse($gw->isAdmin($empNumber = 2, $projectId = 21));

    	// Deleted projects not considered when project Id not given
        $this->assertTrue(mysql_query("UPDATE ohrm_project SET is_deleted = 1 WHERE project_id = 1"));
		$this->assertEquals(1, mysql_affected_rows());

    	$this->assertFalse($gw->isAdmin($empNumber = 1));
    	$this->assertTrue($gw->isAdmin($empNumber = 1, $projectId = 1));

        $this->assertTrue(mysql_query("UPDATE ohrm_project SET is_deleted = 1 WHERE project_id = 2"));
		$this->assertEquals(1, mysql_affected_rows());

    	$this->assertFalse($gw->isAdmin($empNumber = 2));
    	$this->assertTrue($gw->isAdmin($empNumber = 2, $projectId = 2));
    	$this->assertTrue($gw->isAdmin($empNumber = 2, $projectId = 1));

    }

    /**
     * Test for getProjectsForAdmin() method.
     */
    public function testGetProjectsForAdmin() {

		$gw = new ProjectAdminGateway();

		// Verify that invalid emp numbers throw exceptions
		try {
			$gw->getProjectsForAdmin("");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected.
		}

		try {
			$gw->getProjectsForAdmin("aer");
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected.
		}

		try {
			$gw->getProjectsForAdmin(null);
			$this->fail("Exception not thrown");
		} catch (ProjectAdminException $e) {
			// Expected.
		}

		// invalid emp number
		$list = $gw->getProjectsForAdmin(100);
		$this->assertTrue(is_array($list));
		$this->assertEquals(0, count($list));

		// valid emp, not an admin
		$list = $gw->getProjectsForAdmin(1);
		$this->assertTrue(is_array($list));
		$this->assertEquals(0, count($list));

		$this->_insertAdmins();

		// valid emp, admin of one project
		$list = $gw->getProjectsForAdmin(1);
		$this->assertTrue(is_array($list));
		$this->assertEquals(1, count($list));
		$proj = $list[0];
		$this->assertTrue($proj instanceof Projects);
		$this->assertEquals(1, $proj->getProjectId());
		$this->assertEquals('Test project 1', $proj->getProjectName());

		// valid emp, admin of multiple projects
		$list = $gw->getProjectsForAdmin(2);
		$this->assertTrue(is_array($list));
		$this->assertEquals(2, count($list));

		$validResults = array( 1 => 'Test project 1', 2 => 'Test project 2');

		foreach ($list as $proj) {
			$this->assertTrue($proj instanceof Projects);
			$id = $proj->getProjectId();
			$name = $proj->getProjectName();

			$this->assertTrue(array_key_exists($id, $validResults));
			$this->assertEquals($name, $validResults[$id]);

			unset($validResults[$id]);
		}

		// Verify that deleted projects are not returned by default
        $this->assertTrue(mysql_query("UPDATE ohrm_project SET is_deleted = 1 WHERE project_id = 1"));
		$this->assertEquals(1, mysql_affected_rows());

		$list = $gw->getProjectsForAdmin(1);
		$this->assertTrue(is_array($list));
		$this->assertEquals(0, count($list));

		// deleted projects are returned when requested
		$list = $gw->getProjectsForAdmin(1, true);
		$this->assertTrue(is_array($list));
		$this->assertEquals(1, count($list));
		$proj = $list[0];
		$this->assertTrue($proj instanceof Projects);
		$this->assertEquals(1, $proj->getProjectId());
		$this->assertEquals('Test project 1', $proj->getProjectName());
    }

	public function errorHandler($errlevel, $errstr, $errfile='', $errline='', $errcontext=''){
		$this->errorLevel = $errlevel;
		$this->errorStr = $errstr;
	}

	private function _clearError() {
		$this->errorLevel = null;
		$this->errorStr = null;
	}

    /**
     * Counts project admins (with optional condition)
     *
     * @param  string $where where clause
     * @return int number of rows
     */
    private function _countAdmins($where = null) {

    	$sql = "SELECT COUNT(*) FROM ohrm_project_admin";
    	if (!empty($where)) {
    		$sql .= " WHERE " . $where;
    	}
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result, MYSQL_NUM);
        $count = $row[0];
		return $count;
    }

    /**
     * Inserts some admins for use in the tests
     */
    private function _insertAdmins() {

        $this->assertTrue(mysql_query("INSERT INTO ohrm_project_admin(emp_number, project_id) " .
        			"VALUES(1, 1)"));
		$this->assertEquals(1, mysql_affected_rows());
        $this->assertTrue(mysql_query("INSERT INTO ohrm_project_admin(emp_number, project_id) " .
        			"VALUES(2, 1)"));
		$this->assertEquals(1, mysql_affected_rows());
        $this->assertTrue(mysql_query("INSERT INTO ohrm_project_admin(emp_number, project_id) " .
        			"VALUES(2, 2)"));
		$this->assertEquals(1, mysql_affected_rows());
    }

    /**
     * Clears project admin table
     */
     private function _deleteAllAdmins() {
     	mysql_query("TRUNCATE TABLE ohrm_project_admin");
     }
}

// Call ProjectAdminGatewayTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "ProjectAdminGatewayTest::main") {
    ProjectAdminGatewayTest::main();
}
?>

