<?php
// Call ProjectsTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "ProjectsTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

$_SESSION['WPATH'] = WPATH;

require_once ROOT_PATH."/lib/confs/Conf.php";
require_once 'Projects.php';

/**
 * Test class for Projects.
 * Generated by PHPUnit_Util_Skeleton on 2007-03-22 at 15:43:08.
 */
class ProjectsTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */

    public $classLeaveType = null;
    public $connection = null;


    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("ProjectsTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {

    	$this->classProjects = new Projects();

    	$conf = new Conf();
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
        mysql_select_db($conf->dbname);


        mysql_query("TRUNCATE TABLE `hs_hr_project`", $this->connection);

        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1001','zanfer1','forrw',0 )");
        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1002','zanfer2','forrw',0 )");
        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1003','zanfer3','forrw',0 )");

        mysql_query("INSERT INTO `hs_hr_project` VALUES ('1001','1001','p1','w',0 )");
        mysql_query("INSERT INTO `hs_hr_project` VALUES ('1002','1002','p2','w',0 )");
        mysql_query("INSERT INTO `hs_hr_project` VALUES ('1003','1003','p3','w',0 )");

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
	protected function tearDown() {

	    mysql_query("TRUNCATE TABLE `hs_hr_project`", $this->connection);

		mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` IN (1001, 1002, 1003);", $this->connection);
    }

    public function testFetchProject() {
    	$this->classProjects->setProjectId("1001");

    	$res  = $this->classProjects->fetchProject();

    	$this->assertNotNull($res, "No record found");

    	$this->assertEquals($res->getProjectId(),'1001','Invalid project id');
	   	$this->assertEquals($res->getCustomerId(),'1001','Invalid customer id');
	   	$this->assertEquals($res->getProjectName(),'p1','Invalid description');
	   	$this->assertEquals($res->getProjectDescription(),'w','Invalid description');
    }

    public function testAddProject() {

    	$this->classProjects->setProjectId("1004");
    	$this->classProjects->setCustomerId("1003");
    	$this->classProjects->setProjectName("Dodle");
    	$this->classProjects->setProjectDescription("jhgjhg");


    	$res  = $this->classProjects->addProject();
    	$res  = $this->classProjects->fetchProject();
	    $this->assertNotNull($res, "No record found");

	   	$this->assertEquals($res->getProjectId(),'1004','Invalid project id');
	   	$this->assertEquals($res->getCustomerId(),'1003','Invalid customer id');
	   	$this->assertEquals($res->getProjectName(),'Dodle','Invalid description');
	   	$this->assertEquals($res->getProjectDescription(),'jhgjhg','Invalid description');
    }

	public function testFetchProjects() {

      	$res = $this->classProjects->fetchProjects();
      	$this->assertNotNull($res, "record Not found");

      	$this->assertEquals(count($res), 3,'count incorrect');

      	$expected[0] = array('1001', '1001', 'p1', 'w','0');
      	$expected[1] = array('1002', '1002', 'p2', 'w','0');
      	$expected[2] = array('1003', '1003', 'p3', 'w','0');

      	$i= 0;

		for ($i=0; $i<count($res); $i++) {

			$this->assertSame($expected[$i][0], $res[$i]->getProjectId(), 'Wrong Project Request Id');
			$this->assertSame($expected[$i][1], $res[$i]->getCustomerId(), 'Wrong Cus Id ');
			$this->assertSame($expected[$i][2], $res[$i]->getProjectName(), 'Wrong Project Name ');
			$this->assertSame($expected[$i][3], $res[$i]->getProjectDescription(),'Wrong Project Description ');

      	}
	}

    /**
     * @todo Implement testEditProject().
     */
    public function testEditProject() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testDeleteProject().
     */
    public function testDeleteProject() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

  }

// Call ProjectsTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "ProjectsTest::main") {
    ProjectsTest::main();
}

?>
