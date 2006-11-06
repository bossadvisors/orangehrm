<?php
// Call LeaveTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "LeaveTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

define('ROOT_PATH', $rootPath);
define('WPATH', $webPath);
$_SESSION['WPATH'] = WPATH;

require_once "Leave.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for Leave.
 * Generated by PHPUnit_Util_Skeleton on 2006-10-12 at 08:36:24.
 */
class LeaveTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    
    public $classLeave = null;
    public $connection = null;
    
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("LeaveTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    	$this->classLeave = new Leave(); 
    	
    	$conf = new Conf();
    	
    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
		
        mysql_select_db($conf->dbname);
        
		mysql_query("INSERT INTO `hs_hr_leave` VALUES (10, 'EMP011', 'LTY010', 'Medical', '2006-10-12', '".date('Y-m-d', time()+3600*24)."', 1, 1, 'Leave 1')");
		mysql_query("INSERT INTO `hs_hr_leave` VALUES (11, 'EMP011', 'LTY010', 'Medical', '2006-10-12', '".date('Y-m-d', time()+3600*24*2)."', 1, 1, 'Leave 2')");
    	
		mysql_query("INSERT INTO `hs_hr_leave` VALUES (12, 'EMP013', 'LTY010', 'Medical', '2006-10-12', '".date('Y-m-d', time()+3600*24)."', 8, 3, 'Leave 4')");
		mysql_query("INSERT INTO `hs_hr_leave` VALUES (13, 'EMP013', 'LTY010', 'Medical', '2006-10-12', '".date('Y-m-d', time()+3600*24*2)."', 8, 3, 'Leave 5')");
    	
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('EMP011', 'Arnold', 'Subasinghe', '', 'Arnold', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', 'AF', '', '', '', '', '', '', NULL, '0000-00-00', '')");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('EMP012', 'Mohanjith', 'Sudirikku', 'Hannadige', 'MOHA', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('EMP013', 'MohanjithX', 'SudirikkuX', 'HannadigeX', 'MOHAX', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");

		mysql_query("INSERT INTO `hs_hr_emp_reportto` VALUES ('EMP012', 'EMP011', 1);");	
		
		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY010', 'Medical', 1)");	
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	   	
    	mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY010'", $this->connection);
    	
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = 'EMP011'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = 'EMP012'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = 'EMP013'", $this->connection);
    	
    	mysql_query("DELETE FROM `hs_hr_emp_reportto` WHERE `erep_sup_emp_number` = 'EMP012' AND `erep_sub_emp_number` = 'EMP011'", $this->connection);
    	    	
    	mysql_query("TRUNCATE TABLE `hs_hr_leave`", $this->connection);    	
    }
    
    public function testRetrieveTakenLeaveAccuracy1() {
    	$leveObj = $this->classLeave;
    		
    	$res = $leveObj->retrieveTakenLeave(date('Y', time()+3600*24*367), 'EMP013');
    	
    	$this->assertEquals($res, false, "Returned future record");
    }
    
    public function testRetrieveTakenLeaveAccuracy2() {
    	$leveObj = $this->classLeave;
    		
    	$res = $leveObj->retrieveTakenLeave(date('Y', time()+3600*24), 'EMP010');
    	
    	$this->assertEquals($res, false, "Returned non exsiting record");
    }
    
    public function testRetrieveTakenLeaveAccuracy3() {
    	$leveObj = $this->classLeave;
    		
    	$res = $leveObj->retrieveTakenLeave(date('Y', time()+3600*24), 'EMP013');
	
    	$expected[0] = array(date('Y-m-d', time()+3600*24), 'Medical', 3, 8, 'Leave 4');
        $expected[1] = array(date('Y-m-d', time()+3600*24*2), 'Medical', 3, 8, 'Leave 5');
        
        $this->assertEquals($res, true, "Returned nothing");
        
        $this->assertEquals(count($res), 2, "Didn't return the expected number of records");
                
    	for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        }   	
    }

    public function testApplyLeave()
    {
    	$this->classLeave->setEmployeeId("EMP012");
    	$this->classLeave->setLeaveTypeId("LTY010");    	 	
    	$this->classLeave->setLeaveDate(date('Y-m-d', time()+3600*24));
    	$this->classLeave->setLeaveLength("2");
    	$this->classLeave->setLeaveStatus("1");
    	$this->classLeave->setLeaveComments("Leave 1");
    	
    	$res = $this->classLeave->applyLeave();    	
    	
    	$res = $this->classLeave->retriveLeaveEmployee("EMP012");
    	
    	$this->assertEquals($res, true, "No record found");
    	
    	$this->assertEquals(count($res), 1, "Wrong number of records found");
    	
        $expected[0] = array(date('Y-m-d', time()+3600*24), 'Medical', 1, 2, 'Leave 1');
        
        for ($i=0; $i < count($expected); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Checking added / applied leave ");
        }
        
        $this->classLeave->setLeaveComments("Leave 2");
        $res = $this->classLeave->applyLeave();      
        
        $res = $this->classLeave->retriveLeaveEmployee("EMP012");  
        $expected[1] = array(date('Y-m-d', time()+3600*24), 'Medical', 1, 2, 'Leave 2'); 
        
        for ($i=0; $i < count($expected); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Checking added / applied leave ");
        }	
    }
    
    public function testRetriveLeaveEmployee1() {
    	
        $res = $this->classLeave->retriveLeaveEmployee("EMP101");        
        
        $this->assertEquals($res, null, "Retured non exsistant record ");
    }

    public function testRetriveLeaveSupervisor1() {
    	
        $res = $this->classLeave->retriveLeaveSupervisor("EMP041");        
        
        $this->assertEquals($res, null, "Retured non exsistant record ");
    }
    
    public function testRetriveLeaveSupervisorAccuracy() {

    	$empId = "EMP012";
    	
        $res = $this->classLeave->retriveLeaveSupervisor($empId);
        
        $expected[0] = array(date('Y-m-d', time()+3600*24), 'Medical', 1, 1, 'Leave 1', 'Subasinghe', "EMP011");
        $expected[1] = array(date('Y-m-d', time()+3600*24*2), 'Medical', 1, 1, 'Leave 2', 'Subasinghe', "EMP011");
        
        $this->assertEquals($res, true, "No record found");
        
        $this->assertEquals(count($res), 2, "Number of records found is not accurate");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getEmployeeName(), $expected[$i][5], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getEmployeeId(), $expected[$i][6], "Didn't return expected result ");
        }
       
    }
    
    public function testRetriveLeaveEmployeeAccuracy() {

        $res = $this->classLeave->retriveLeaveEmployee("EMP011");
        
        $expected[0] = array(date('Y-m-d', time()+3600*24), 'Medical', 1, 1, 'Leave 1');
        $expected[1] = array(date('Y-m-d', time()+3600*24*2), 'Medical', 1, 1, 'Leave 2');
        
        $this->assertEquals($res, true, "No record found ");
        
        $this->assertEquals(count($res), 2, "Number of records found is not accurate ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveTypeName(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        }
       
    }
    
    public function testCancelLeaveAccuracy() {
    	        
        $res = $this->classLeave->cancelLeave(10);
        $expected = true;
                
        $this->assertEquals($res, $expected, "Cancel of leave failed ");
        
        $res = $this->classLeave->cancelLeave(10);
        $expected = false;
                
        $this->assertEquals($res, $expected, "Cancelled already cancelled leave ");
                
        $res = $this->classLeave->retriveLeaveEmployee("EMP011");        
        $expected[0] = array(date('Y-m-d', time()+3600*24*2), 'Medical', 1, 1, 'Leave 2');                

        $this->assertEquals($res, true, "No record found ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[0]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveTypeName(), $expected[$i][1], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        }
    }

    public function testCountLeave() {
    	$this->classLeave->setEmployeeId("EMP013");
    	$res = $this->classLeave->countLeave( "LTY010", date('Y', time()+3600*24));
    	
    	$this->assertEquals($res, 2, "Retruned wrong count");
    }
    
    public function testGetLeaveYears() {
    	
    	$res = $this->classLeave->getLeaveYears();
    	
    	$this->assertEquals($res, true, "No years returned");
    	
    	$this->assertEquals(count($res), 1, "Retruned wrong number of records");
    	
    	$expected = array(date('Y'));
    	
    	$this->assertEquals($res, $expected, "Retruned wrong count");
    }

}

// Call LeaveTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "LeaveTest::main") {
    LeaveTest::main();
}
?>
