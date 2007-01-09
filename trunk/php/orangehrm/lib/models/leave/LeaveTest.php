<?php
// Call LeaveTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "LeaveTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "testConf.php";

$_SESSION['WPATH'] = WPATH;

require_once "Leave.php";
require_once ROOT_PATH."/lib/confs/Conf.php";

/**
 * Test class for Leave.
 * Generated by PHPUnit_Util_Skeleton on 2006-10-12 at 08:36:24.
 */
class LeaveTest extends PHPUnit_Framework_TestCase {
    
	public $classLeave = null;
    public $connection = null;
	/**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */    
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
        		
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('011', 'Arnold', 'Subasinghe', '', 'Arnold', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', 'AF', '', '', '', '', '', '', NULL, '0000-00-00', '')");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('012', 'Mohanjith', 'Sudirikku', 'Hannadige', 'MOHA', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('013', 'MohanjithX', 'SudirikkuX', 'HannadigeX', 'MOHAX', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('014', 'Mohanjith1', 'Sudirikku1', 'Hannadige1', 'MOHA1', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		mysql_query("INSERT INTO `hs_hr_employee` VALUES ('014', 'Mohanjith1', 'Sudirikku1', 'Hannadige1', 'MOHA1', 0, NULL, '0000-00-00 00:00:00', NULL, NULL, NULL, '', '', '', '', '0000-00-00', '', NULL, NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00', NULL)");
		
		mysql_query("INSERT INTO `hs_hr_emp_reportto` VALUES ('012', '011', 1);");	
		
		mysql_query("INSERT INTO `hs_hr_leavetype` VALUES ('LTY010', 'Medical', 1)");	
		
		mysql_query("INSERT INTO `hs_hr_leave_requests` (`leave_request_id`, `leave_type_id`, `leave_type_name`, `date_applied`, `employee_id`) VALUES (10, 'LTY010', 'Medical', '".date('Y-m-d', time()+3600*24)."', '012')");			
		mysql_query("INSERT INTO `hs_hr_leave_requests` (`leave_request_id`, `leave_type_id`, `leave_type_name`, `date_applied`, `employee_id`) VALUES (11, 'LTY010', 'Medical', '".date('Y-m-d', time()+3600*24)."', '011')");	
		mysql_query("INSERT INTO `hs_hr_leave_requests` (`leave_request_id`, `leave_type_id`, `leave_type_name`, `date_applied`, `employee_id`) VALUES (12, 'LTY010', 'Medical', '".date('Y-m-d', time()+3600*24)."', '013')");	
		mysql_query("INSERT INTO `hs_hr_leave_requests` (`leave_request_id`, `leave_type_id`, `leave_type_name`, `date_applied`, `employee_id`) VALUES (13, 'LTY010', 'Medical', '".date('Y-m-d', time()+3600*24)."', '014')");	
		
		mysql_query("INSERT INTO `hs_hr_leave` (`leave_id`, `employee_id`, `leave_type_id`, `leave_date`, `leave_length`, `leave_status`, `leave_comments`, `leave_request_id`) VALUES (10, '011', 'LTY010', '".date('Y-m-d', time()+3600*24)."', 1, 1, 'Leave 1', 11)");
		mysql_query("INSERT INTO `hs_hr_leave` (`leave_id`, `employee_id`, `leave_type_id`, `leave_date`, `leave_length`, `leave_status`, `leave_comments`, `leave_request_id`) VALUES (11, '011', 'LTY010', '".date('Y-m-d', time()+3600*24*2)."', 1, 1, 'Leave 2', 11)");
    	
		mysql_query("INSERT INTO `hs_hr_leave` (`leave_id`, `employee_id`, `leave_type_id`, `leave_date`, `leave_length`, `leave_status`, `leave_comments`, `leave_request_id`) VALUES (12, '013', 'LTY010', '".date('Y-m-d', time()+3600*24)."', 8, 3, 'Leave 4', 12)");
		mysql_query("INSERT INTO `hs_hr_leave` (`leave_id`, `employee_id`, `leave_type_id`, `leave_date`, `leave_length`, `leave_status`, `leave_comments`, `leave_request_id`) VALUES (13, '013', 'LTY010', '".date('Y-m-d', time()+3600*24*2)."', 8, 3, 'Leave 5', 12)");
    	
		mysql_query("INSERT INTO `hs_hr_leave` (`leave_id`, `employee_id`, `leave_type_id`, `leave_date`, `leave_length`, `leave_status`, `leave_comments`, `leave_request_id`) VALUES (15, '014', 'LTY010', '".date('Y-m-d', time())."', 8, 2, 'Leave 6', 13)");
	
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {    	
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '011'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '012'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '013'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_employee` WHERE `emp_number` = '014'", $this->connection);
    	
    	mysql_query("DELETE FROM `hs_hr_emp_reportto` WHERE `erep_sup_emp_number` = '012' AND `erep_sub_emp_number` = '011'", $this->connection);
    	    	
    	mysql_query("TRUNCATE TABLE `hs_hr_leave`", $this->connection); 
    	mysql_query("TRUNCATE TABLE `hs_hr_leave_requests`", $this->connection);   
    	
    	mysql_query("DELETE FROM `hs_hr_leavetype` WHERE `Leave_Type_ID` = 'LTY010'", $this->connection);
    }
    
    public function testRetrieveTakenLeaveAccuracy1() {
    	$leveObj = $this->classLeave;
    		
    	$res = $leveObj->retrieveTakenLeave(date('Y', time()+3600*24*367), '013');
    	
    	$this->assertEquals($res, false, "Returned future record");
    }
    
    public function testRetrieveTakenLeaveAccuracy2() {
    	$leveObj = $this->classLeave;
    		
    	$res = $leveObj->retrieveTakenLeave(date('Y', time()+3600*24), '010');
    	
    	$this->assertEquals($res, false, "Returned non exsiting record");
    }
    
    public function testRetrieveTakenLeaveAccuracy3() {
    	$leveObj = $this->classLeave;
    		
    	$res = $leveObj->retrieveTakenLeave(date('Y', time()+3600*24), '013');
	
    	$expected[0] = array(date('Y-m-d', time()+3600*24), 'Medical', 3, 8, 'Leave 4');
        $expected[1] = array(date('Y-m-d', time()+3600*24*2), 'Medical', 3, 8, 'Leave 5');
        
        $this->assertNotNull($res, "Returned nothing");
        
        $this->assertEquals(count($res), 2, "Didn't return the expected number of records");
                
    	for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        }   	
    }

    public function testApplyLeave()
    {
    	$this->classLeave->setLeaveRequestId("010");
    	$this->classLeave->setEmployeeId("012");
    	$this->classLeave->setLeaveTypeId("LTY010");    	 	
    	$this->classLeave->setLeaveDate(date('Y-m-d', time()+3600*24));
    	$this->classLeave->setLeaveLength("2");
    	$this->classLeave->setLeaveStatus("1");
    	$this->classLeave->setLeaveComments("Leave 1");
    	
    	$res = $this->classLeave->applyLeave();    	
    	
    	$res = $this->classLeave->retrieveLeaveEmployee("012");
    	
    	$this->assertNotNull($res, "No record found");
    	
    	$this->assertEquals(count($res), 1, "Wrong number of records found");
    	
        $expected[0] = array(date('Y-m-d', time()+3600*24), 'Medical', 1, 2, 'Leave 1');
        
        for ($i=0; $i < count($expected); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Checking added / applied leave ");        	
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Checking added / applied leave ");
        }
        
        $this->classLeave->setLeaveComments("Leave 2");
        $res = $this->classLeave->applyLeave();      
        
        $res = $this->classLeave->retrieveLeaveEmployee("012");  
        $expected[1] = array(date('Y-m-d', time()+3600*24), 'Medical', 1, 2, 'Leave 2'); 
        
        for ($i=0; $i < count($expected); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveStatus(), $expected[$i][2], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveLength(), $expected[$i][3], "Checking added / applied leave ");
        	$this->assertEquals($res[$i]->getLeaveComments(), $expected[$i][4], "Checking added / applied leave ");
        }	
    }
    
    public function testRetriveLeaveEmployeeAccuracy() {

        $res = $this->classLeave->retrieveLeaveEmployee("011");
        
        $expected[0] = array(date('Y-m-d', time()+3600*24), 'Medical', 1, 1, 'Leave 1');
        $expected[1] = array(date('Y-m-d', time()+3600*24*2), 'Medical', 1, 1, 'Leave 2');
        
        $this->assertNotNull($res, "No record found ");
        
        $this->assertEquals(count($res), 2, "Number of records found is not accurate ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[$i]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");        	
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
                
        $res = $this->classLeave->retrieveLeaveEmployee("011");        
        $expected[0] = array(date('Y-m-d', time()+3600*24), 'Medical', 0, 1, ''); 
        $expected[1] = array(date('Y-m-d', time()+3600*24*1), 'Medical', 0, 1, '');                 

        $this->assertNotNull($res, "No record found ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[0]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveStatus(), $expected[$i][2], "Didn't return expected status ");
        	$this->assertEquals($res[0]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        }
    }

    public function testCountLeave() {
    	$this->classLeave->setEmployeeId("013");
    	$res = $this->classLeave->countLeave( "LTY010", date('Y', time()+3600*24));
    	
    	$this->assertEquals($res, 2, "Retruned wrong count");
    }
    
    public function testGetLeaveYears() {
    	
    	$res = $this->classLeave->getLeaveYears();
    	
    	$this->assertNotNull($res, "No years returned");
    	
    	$this->assertEquals(count($res), 2, "Retruned wrong number of records");
    	
    	$expected = array(date('Y')+1, date('Y'));
    	
    	$this->assertEquals($res, $expected, "Retruned wrong count");
    }
    
    public function testTakeLeaveAccuracy() {

    	$res = $this->classLeave->retrieveLeaveEmployee("014");        
        $this->assertNotNull($res, "Exsistent record not found ");   
        
        $expected[0] = array(date('Y-m-d', time()), 'Medical', 2, 8, 'Leave 6');                

        $this->assertNotNull($res, "No record found ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[0]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        } 
    	
    	$res = $this->classLeave->takeLeave();
    	$this->assertNotNull($res, "Unexpected behavior ");
    	
        $res = $this->classLeave->retrieveLeaveEmployee("014");        
        $this->assertNotNull($res, "Exsistent record not found2 ");    
        
        $expected[0] = array(date('Y-m-d', time()), 'Medical', 3, 8, 'Leave 6');                

        $this->assertNotNull($res, "No record found ");

        for ($i=0; $i < count($res); $i++) {
        	$this->assertEquals($res[0]->getLeaveDate(), $expected[$i][0], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveStatus(), $expected[$i][2], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveLength(), $expected[$i][3], "Didn't return expected result ");
        	$this->assertEquals($res[0]->getLeaveComments(), $expected[$i][4], "Didn't return expected result ");
        }
        
        $res = $this->classLeave->takeLeave();
    	$this->assertEquals($res, false, "Unexpected behavior ");   
       
    }

}

// Call LeaveTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "LeaveTest::main") {
    LeaveTest::main();
}
?>
