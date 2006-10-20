<?php
// Call LeaveTypeTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "LeaveTypeTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

$_SESSION['WPATH'] = WPATH;
define('ROOT_PATH', $rootPath);
define('WPATH', $webPath);

require_once "LeaveType.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for LeaveType.
 * Generated by PHPUnit_Util_Skeleton on 2006-10-18 at 10:36:24.
 */
class LeaveTypeTest extends PHPUnit_Framework_TestCase {
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

        $suite  = new PHPUnit_Framework_TestSuite("LeaveTypeTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classLeaveType = new LeaveType(); 
    	
    	$conf = new Conf();
    	
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
		
        mysql_select_db($conf->dbname);
        
        mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY002', 'Medical', 1)");
			
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	   	
    	 mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY002'", $this->connection); 
    	 mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY003'", $this->connection); 
    }
	
    public function testAddLeaveType() {
    	
    	$this->classLeaveType->setLeaveTypeName("Anual");
    	
    	$res = $this->classLeaveType->addLeaveType();
    	
    	$res = $this->classLeaveType->retriveLeaveType("LTY003");
        
        $expected[0] = array('LTY003', 'Anual');

    }
	
     public function testRetriveLeaveType() {
    	
        $res = $this->classLeaveType->retriveLeaveType("LTY005"); 
        
        $this->assertEquals($res, null, "Retured non exsistant record ");
   } 
    
     public function testRetriveLeaveAccuracy() {

        $res = $this->classLeaveType->retriveLeaveType("LTY001");
        
        $expected[0] = array('Anual', 'LTY001');
      
        
        $this->assertEquals($res, true, "No record found ");
                    
   }
}

// Call LeaveTypeTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "LeaveTypeTest::main") {
    LeaveTypeTest::main();
}
?>
