<?php
// Call ViewControllerTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "ViewControllerTest::main");
}

define("ROOT_PATH", "E:/moha/source/orangehrm/trunk/php/orangehrm/");
define("WPATH", "http://localhost/orangehrm");

session_start();

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once "ViewController.php";

/**
 * Test class for ViewController.
 * Generated by PHPUnit_Util_Skeleton on 2006-09-13 at 08:21:16.
 */
class ViewControllerTest extends PHPUnit_Framework_TestCase {
	
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */	 
	
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";		
			
        $suite  = new PHPUnit_Framework_TestSuite("ViewControllerTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }
	
	function connectDB() {

		if(!@mysql_connect($_SESSION['dbInfo']['dbHostName'].':'.$_SESSION['dbInfo']['dbHostPort'], 		$_SESSION['dbInfo']['dbUserName'], $_SESSION['dbInfo']['dbPassword'])) {
			$_SESSION['error'] =  'Database Connection Error!';		
			return;
		}	
	}
	
	function fillData($phase=1, $source='/UnitTest/dbscript-') {
		$source .= $phase.'.sql';
		$this->connectDB();
	
		error_log (date("r")." Fill Data Phase $phase - Connected to the DB Server\n",3, "log.txt");
	
		if(!mysql_select_db($_SESSION['dbInfo']['dbName'])) {
			$_SESSION['error'] = 'Unable to create Database!';
			error_log (date("r")." Fill Data Phase $phase - Error - Unable to create Database\n",3, "log.txt");
			return;
		}
	
		error_log (date("r")." Fill Data Phase $phase - Selected the DB\n",3, "log.txt");
		error_log (date("r")." Fill Data Phase $phase - Reading DB Script\n",3, "log.txt");
	
		$queryFile = ROOT_PATH . $source;
		$fp    = fopen($queryFile, 'r');
	
		error_log (date("r")." Fill Data Phase $phase - Opened DB Script\n",3, "log.txt");
	
		$query = fread($fp, filesize($queryFile));
		fclose($fp);
		
		error_log (date("r")." Fill Data Phase $phase - Read DB script\n",3, "log.txt");
								
		$dbScriptStatements = explode(";", $query);
	
		error_log (date("r")." Fill Data Phase $phase - There are ".count($dbScriptStatements)." Statements in the DB script\n",3, "log.txt");
								
		for($c=0;(count($dbScriptStatements)-1)>$c;$c++)
			if(!@mysql_query($dbScriptStatements[$c])) {  
				$_SESSION['error'] = mysql_error();
				$error = mysql_error();
				error_log (date("r")." Fill Data Phase $phase - Error Statement # $c \n",3, "log.txt");
				error_log (date("r")." ".$dbScriptStatements[$c]."\n",3, "log.txt");
				
			}
			
		unset($query);						
		if(isset($error))
			return;
	}	
	

	
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
	 
    protected function setUp() {	
	 				
		$_SESSION['dbInfo']['dbHostName'] = "localhost";
		$_SESSION['dbInfo']['dbHostPort'] = "3306";
		$_SESSION['dbInfo']['dbUserName'] = "root";
		$_SESSION['dbInfo']['dbPassword'] = "moha";
		
		$_SESSION['dbInfo']['dbName'] = "hr_mysqltest";
		
		/*$this->fillData();	
		unset($error);	
		unset($_SESSION['error']);		*/
		
		$this->view = new ViewController();	
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
		
    }

    /*
	 ************************************************************************************
     * XajaxObjCall() Tests                                                             *
	 ************************************************************************************
     */
	 
	 /**
	  * GeoInfo - Province
	  */
    public function testXajaxObjCall_Province_1() {       
        $this->assertEquals(false, $this->view->xajaxObjCall("LK", "LOC", "province"));		
    }
	
	public function testXajaxObjCall_Province_2() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("US", "LOC", "province"));		
    }
		
	/**
	  * GeoInfo - addLocation
	  */
	/*public function testXajaxObjCall_addLocation_1() {	
		$extractor = new EXTRACTOR_Location(); 
		
		$test = array('txtLocDescription'=>"Nawam Mawatha", 'txtAddress'=>"Sayuru Sevana", 'cmbDistrict'=>"Colombo", 'cmbCountry'=>"LK", 'cmbProvince'=>"Western", 'txtZIP'=>"00200", 'txtPhone'=>"011-2446111", 'txtFax'=>"011-2446112", 'txtComments'=>"PHPUnit");    
		
		$parsedObject = $extractor->parseAddData($test);
        $this->assertEquals(false, $this->view->xajaxObjCall("US", "LOC", "addLocation"));		
    }	
	public function testXajaxObjCall_addLocation_2() {        
        $this->assertEquals(false, $this->view->xajaxObjCall("TX", "LOC", "addLocation"));		
    }*/
	
	 /**
	  * Job - Job Title - Assigned
	  */	  
	public function testXajaxObjCall_Job_ass_1() {        
        $this->assertEquals(false, $this->view->xajaxObjCall("Web Developer", "JOB", "assigned"));		
    }
	public function testXajaxObjCall_Job_ass_2() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("JOB001", "JOB", "assigned"));		
    }
	public function testXajaxObjCall_Job_ass_3() {
		$test = array(array("EST001", "Permanent"));        
        $this->assertEquals($test, $this->view->xajaxObjCall("JOB001", "JOB", "assigned"));		
    }
	
	 /**
	  * Job - Job Title - Unassigned
	  */
	public function testXajaxObjCall_Job_unAss_1() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("Web Developer", "JOB", "unAssigned"));		
    }
	public function testXajaxObjCall_Job_unAss_2() {
		$test = array(array("EST001", "Permanent"), array("EST002", "Part Time"));        
        $this->assertEquals($test, $this->view->xajaxObjCall("Web Developer", "JOB", "unAssigned"));		
    }
	public function testXajaxObjCall_Job_unAss_3() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("JOB001", "JOB", "unAssigned"));		
    }
	public function testXajaxObjCall_Job_unAss_4() {
		$test = array(array("EST002", "Part Time"));        
        $this->assertEquals($test, $this->view->xajaxObjCall("JOB001", "JOB", "unAssigned"));		
    }
	
	 /**
	  * Job - Job Title - editEmpStat
	  */
	public function testXajaxObjCall_Job_editEmpStat_1() {        
        $this->assertEquals(false, $this->view->xajaxObjCall("Web Developer", "JOB", "editEmpStat"));		
    }
	public function testXajaxObjCall_Job_editEmpStat_2() {        
        $this->assertEquals(true, $this->view->xajaxObjCall("EST002", "JOB", "editEmpStat"));		
    }
	public function testXajaxObjCall_Job_editEmpStat_3() {
		$test = array(array("EST002", "Part Time"));        
        $this->assertEquals($test, $this->view->xajaxObjCall("EST002", "JOB", "editEmpStat"));		
    }
	public function testXajaxObjCall_Job_editEmpStat_4() {
		$test = array(array("EST001", "Permanent"));      
        $this->assertEquals($test, $this->view->xajaxObjCall("EST001", "JOB", "editEmpStat"));		
    }
	
	 /*
	  * *********************************************************************************
	  */

    /**
     * @todo Implement testViewList().
     */
    public function testViewList() {       
        $this->assertEquals(true,true);
		//  No tests for HTML
    }

    /**
     * @todo Implement testDelParser().
     */
    /*public function testDelParser_emloyment_status() {
        $delArr = array(array('EST001')); 
        $this->view->delParser("EST", $delArr);
		
		$test = array(array("EST002", "Part Time")); 
		$this->assertEquals($test, $this->view->xajaxObjCall("EST002", "JOB", "editEmpStat"));
    }*/

    /**
     * @todo Implement testSelectIndexId().
     */
	 
    //EST
	
	public function testSelectIndexId_EST_1() {
		$this->view->indexCode = "EST";
		$test = array(array("EST001", "Permanent"), array("EST002", "Part Time"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_EST_2() {
		$this->view->indexCode = "EST";
		$test = array(array("EST001", "Permanent"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'EST001', 0));
    }
	
	public function testSelectIndexId_EST_3() {
		$this->view->indexCode = "EST";
		$test = array( array("EST002", "Part Time"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Part Time', 1));
    }
	
	public function testSelectIndexId_EST_4() {
		$this->view->indexCode = "EST";
		$test = array(array("EST001", "Permanent"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	public function testSelectIndexId_EST_5() {
		$this->view->indexCode = "EST";
		$test = array(array("EST001", "Permanent"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_EST_6() {
		$this->view->indexCode = "EST";		
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_EST_7() {
		$this->view->indexCode = "EST";		
        $this->assertEquals('', $this->view->selectIndexId(0, '001', 1));
    }
	
	//JOB

	public function testSelectIndexId_JOB_1() {
		$this->view->indexCode = "JOB";
		$test = array(array("JOB001", "Web Developer"), array("JOB002", "Technical Writer"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_JOB_2() {
		$this->view->indexCode = "JOB";
		$test = array(array("JOB001", "Web Developer"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'JOB001', 0));
    }
	
	public function testSelectIndexId_JOB_3() {
		$this->view->indexCode = "JOB";
		$test = array( array("JOB002", "Technical Writer"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Technical Writer', 1));
    }
	
	public function testSelectIndexId_JOB_4() {
		$this->view->indexCode = "JOB";
		$test = array( array("JOB001", "Web Developer"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'We', 1));
    }
	
	public function testSelectIndexId_JOB_5() {
		$this->view->indexCode = "JOB";
		$test = array( array("JOB001", "Web Developer"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_JOB_6() {
		$this->view->indexCode = "JOB";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_JOB_7() {
		$this->view->indexCode = "JOB";		  
        $this->assertEquals('', $this->view->selectIndexId(0, '001', 1));
    }	
	
	//LOC
	
	public function testSelectIndexId_LOC_1() {
		$this->view->indexCode = "LOC";
		$test = array(array("LOC001", "Nawam Mawatha", "Colombo"), array("LOC002", "NJ", "Secaucus"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_LOC_2() {
		$this->view->indexCode = "LOC";
		$test = array(array("LOC001", "Nawam Mawatha", "Colombo"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'LOC001', 0));
    }
	
	public function testSelectIndexId_LOC_3() {
		$this->view->indexCode = "LOC";
		$test = array(array("LOC002", "NJ", "Secaucus"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'NJ', 1));
    }
	
	public function testSelectIndexId_LOC_4() {
		$this->view->indexCode = "LOC";
		$test = array(array("LOC001", "Nawam Mawatha", "Colombo"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Naw', 1));
    }
	
	public function testSelectIndexId_LOC_5() {
		$this->view->indexCode = "LOC";
		$test = array(array("LOC001", "Nawam Mawatha", "Colombo"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_LOC_6() {
		$this->view->indexCode = "LOC";
		$test = array(array("LOC002", "NJ", "Secaucus"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Secaucus', 2));
    }
	
	public function testSelectIndexId_LOC_7() {
		$this->view->indexCode = "LOC";
		$test = array(array("LOC001", "Nawam Mawatha", "Colombo"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Col', 2));
    }
	
	public function testSelectIndexId_LOC_8() {
		$this->view->indexCode = "LOC";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_LOC_9() {
		$this->view->indexCode = "LOC";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	public function testSelectIndexId_LOC_10() {
		$this->view->indexCode = "LOC";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 2));
    }
	
	/* 
	 * No tests for
	 * COS, CUR, CHI, CTT, 
	 * JDC, JDT, QLF, RTM 
	 */
	 
	 // SKI
	 
	 public function testSelectIndexId_SKI_1() {
		$this->view->indexCode = "SKI";
		$test = array(array("SKI001", "Driving"), array("SKI002", "Rowing"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_SKI_2() {
		$this->view->indexCode = "SKI";
		$test = array(array("SKI001", "Driving"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'SKI001', 0));
    }
	
	public function testSelectIndexId_SKI_3() {
		$this->view->indexCode = "SKI";		
		$test = array( array("SKI002", "Rowing"));		
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Rowing', 1));		
    }
	
	public function testSelectIndexId_SKI_4() {
		$this->view->indexCode = "SKI";
		$test = array( array("SKI001", "Driving"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Dr', 1));
    }
	
	public function testSelectIndexId_SKI_5() {
		$this->view->indexCode = "SKI";
		$test = array( array("SKI001", "Driving"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_SKI_6() {
		$this->view->indexCode = "SKI";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_SKI_7() {
		$this->view->indexCode = "SKI";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	// ETH
	 
	public function testSelectIndexId_ETH_1() {
		$this->view->indexCode = "ETH";
		$test = array(array("ETH001", "Sinhala"), array("ETH002", "Islam"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_ETH_2() {
		$this->view->indexCode = "ETH";
		$test = array(array("ETH001", "Sinhala"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'ETH001', 0));
    }
	
	public function testSelectIndexId_ETH_3() {
		$this->view->indexCode = "ETH";
		$test = array( array("ETH002", "Islam"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Islam', 1));
    }
	
	public function testSelectIndexId_ETH_4() {
		$this->view->indexCode = "ETH";
		$test = array( array("ETH001", "Sinhala"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Sin', 1));
    }
	
	public function testSelectIndexId_ETH_5() {
		$this->view->indexCode = "ETH";
		$test = array( array("ETH001", "Sinhala"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_ETH_6() {
		$this->view->indexCode = "ETH";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_ETH_7() {
		$this->view->indexCode = "ETH";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	/* 
	 * No tests for
	 * EXC
	 */
	
	// MEM
	 
	public function testSelectIndexId_MEM_1() {
		$this->view->indexCode = "MEM";
		$test = array(array("MEM001", "Professional"), array("MEM002", "Academic"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_MEM_2() {
		$this->view->indexCode = "MEM";
		$test = array(array("MEM001", "Professional"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'MEM001', 0));
    }
	
	public function testSelectIndexId_MEM_3() {
		$this->view->indexCode = "MEM";
		$test = array(array("MEM002", "Academic"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Academic', 1));
    }
	
	public function testSelectIndexId_MEM_4() {
		$this->view->indexCode = "MEM";
		$test = array( array("MEM001", "Professional"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Prof', 1));
    }
	
	public function testSelectIndexId_MEM_5() {
		$this->view->indexCode = "MEM";
		$test = array( array("MEM001", "Professional"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_MEM_6() {
		$this->view->indexCode = "MEM";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_MEM_7() {
		$this->view->indexCode = "MEM";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	/* 
	 * No tests for
	 * UNI, STAT, EMC, EMG,
	 * RTE, DWT
	 */
	 
	// NAT
	 
	public function testSelectIndexId_NAT_1() {
		$this->view->indexCode = "NAT";
		$test = array(array("NAT001", "Sri Lankan"), array("NAT002", "Indian"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_NAT_2() {
		$this->view->indexCode = "NAT";
		$test = array(array("NAT001", "Sri Lankan"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'NAT001', 0));
    }
	
	public function testSelectIndexId_NAT_3() {
		$this->view->indexCode = "NAT";
		$test = array(array("NAT002", "Indian"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Indian', 1));
    }
	
	public function testSelectIndexId_NAT_4() {
		$this->view->indexCode = "NAT";
		$test = array( array("NAT001", "Sri Lankan"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Sri', 1));
    }
	
	public function testSelectIndexId_NAT_5() {
		$this->view->indexCode = "NAT";
		$test = array( array("NAT001", "Sri Lankan"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_NAT_6() {
		$this->view->indexCode = "NAT";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_NAT_7() {
		$this->view->indexCode = "NAT";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	/* 
	 * No tests for
	 * RLG, COU, DEF, TAX,
	 * PRO, DIS, ELE, BNK
	 */
	 
	// LAN
	 
	public function testSelectIndexId_LAN_1() {
		$this->view->indexCode = "LAN";
		$test = array(array("LAN001", "Tamil"), array("LAN002", "French"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_LAN_2() {
		$this->view->indexCode = "LAN";
		$test = array(array("LAN001", "Tamil"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'LAN001', 0));
    }
	
	public function testSelectIndexId_LAN_3() {
		$this->view->indexCode = "LAN";
		$test = array(array("LAN002", "French"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'French', 1));
    }
	
	public function testSelectIndexId_LAN_4() {
		$this->view->indexCode = "LAN";
		$test = array( array("LAN001", "Tamil"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Tam', 1));
    }
	
	public function testSelectIndexId_LAN_5() {
		$this->view->indexCode = "LAN";
		$test = array( array("LAN001", "Tamil"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_LAN_6() {
		$this->view->indexCode = "LAN";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_LAN_7() {
		$this->view->indexCode = "LAN";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	// MME
	 
	public function testSelectIndexId_MME_1() {
		$this->view->indexCode = "MME";
		$test = array(array("MME001", "BCS", "Professional"), array("MME002", "CIMA", "Professional"), array("MME003", "SIAM", "Academic"), array("MME004", "FIG", "Academic"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_MME_2() {
		$this->view->indexCode = "MME";
		$test = array(array("MME001", "BCS", "Professional"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'MME001', 0));
    }
	
	public function testSelectIndexId_MME_3() {
		$this->view->indexCode = "MME";
		$test = array(array("MME002", "CIMA", "Professional"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'CIMA', 1));
    }
	
	public function testSelectIndexId_MME_4() {
		$this->view->indexCode = "MME";
		$test = array(array("MME001", "BCS", "Professional"), array("MME002", "CIMA", "Professional"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Professional', 2));
    }
	
	public function testSelectIndexId_MME_5() {
		$this->view->indexCode = "MME";
		$test = array(array("MME001", "BCS", "Professional"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_MME_6() {
		$this->view->indexCode = "MME";
		$test = array(array("MME003", "SIAM", "Academic"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'SI', 1));
    }
	
	public function testSelectIndexId_MME_7() {
		$this->view->indexCode = "MME";
		$test = array(array("MME003", "SIAM", "Academic"), array("MME004", "FIG", "Academic"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Aca', 2));
    }
	
	public function testSelectIndexId_MME_8() {
		$this->view->indexCode = "MME";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_MME_9() {
		$this->view->indexCode = "MME";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	public function testSelectIndexId_MME_10() {
		$this->view->indexCode = "MME";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 2));
    }
	
	/* 
	 * No tests for
	 * SSK, EXA
	 */
	 
	// SGR
	 
	public function testSelectIndexId_SGR_1() {
		$this->view->indexCode = "SGR";
		$test = array(array("SAL001", "Rupee"), array("SAL002", "Dollars"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_SGR_2() {
		$this->view->indexCode = "SGR";
		$test = array(array("SAL001", "Rupee"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'SAL001', 0));
    }
	
	public function testSelectIndexId_SGR_3() {
		$this->view->indexCode = "SGR";
		$test = array(array("SAL002", "Dollars"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Dollars', 1));
    }
	
	public function testSelectIndexId_SGR_4() {
		$this->view->indexCode = "SGR";
		$test = array(array("SAL001", "Rupee"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Rup', 1));
    }
	
	public function testSelectIndexId_SGR_5() {
		$this->view->indexCode = "SGR";
		$test = array(array("SAL001", "Rupee"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_SGR_6() {
		$this->view->indexCode = "SGR";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_SGR_7() {
		$this->view->indexCode = "SGR";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	/* 
	 * No tests for
	 * DSG, DDI, DQA, JDK
	 */
	 
	// EDU
	 
	public function testSelectIndexId_EDU_1() {
		$this->view->indexCode = "EDU";
		$test = array(array("EDU001", "Bachelor of Science in Engineering", "University of Moratuwa"), array("EDU002", "Bachelor of Science in Computer Science", "University of Colombo"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_EDU_2() {
		$this->view->indexCode = "EDU";
		$test = array(array("EDU001", "Bachelor of Science in Engineering", "University of Moratuwa"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'EDU001', 0));
    }
	
	public function testSelectIndexId_EDU_3() {
		$this->view->indexCode = "EDU";
		$test = array(array("EDU002", "Bachelor of Science in Computer Science", "University of Colombo"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Bachelor of Science in Computer Science', 1));
    }
	
	public function testSelectIndexId_EDU_4() {
		$this->view->indexCode = "EDU";
		$test = array(array("EDU002", "Bachelor of Science in Computer Science", "University of Colombo"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'University of Colombo', 2));
    }
	
	public function testSelectIndexId_EDU_5() {
		$this->view->indexCode = "EDU";
		$test = array(array("EDU001", "Bachelor of Science in Engineering", "University of Moratuwa"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_EDU_6() {
		$this->view->indexCode = "EDU";
		$test = array(array("EDU001", "Bachelor of Science in Engineering", "University of Moratuwa"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Eng', 1));
    }
		
	public function testSelectIndexId_EDU_7() {
		$this->view->indexCode = "EDU";
		$test = array(array("EDU002", "Bachelor of Science in Computer Science", "University of Colombo"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Col', 2));
    }
	
	public function testSelectIndexId_EDU_8() {
		$this->view->indexCode = "EDU";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_EDU_9() {
		$this->view->indexCode = "EDU";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	public function testSelectIndexId_EDU_10() {
		$this->view->indexCode = "EDU";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 2));
    }
	
	/* 
	 * No tests for
	 * BCH, CCB, NCB, BBS,
	 * NBS, ETY, SBJ
	 */
	 
	 // EEC
	 
	public function testSelectIndexId_EEC_1() {
		$this->view->indexCode = "EEC";
		$test = array(array("EEC001", "OFFICIALS AND ADMINISTRATORS"), array("EEC002", "PROFESSIONALS"), array("EEC003", "TECHNICIANS"), array("EEC004", "PROTECTIVE SERVICE WORKERS"), array("EEC005", "PARAPROFESSIONALS"), array("EEC006", "ADMINISTRATIVE SUPPORT"), array("EEC007", "SKILLED CRAFT WORKERS"), array("EEC008", "SERVICE-MAINTENANCE"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_EEC_2() {
		$this->view->indexCode = "EEC";
		$test = array(array("EEC001", "OFFICIALS AND ADMINISTRATORS"), array("EEC002", "PROFESSIONALS"), array("EEC003", "TECHNICIANS"), array("EEC004", "PROTECTIVE SERVICE WORKERS"), array("EEC005", "PARAPROFESSIONALS"));    
        $this->assertEquals($test, $this->view->selectIndexId(1, '', -1));
    }
	
	public function testSelectIndexId_EEC_3() {
		$this->view->indexCode = "EEC";
		$test = array(array("EEC006", "ADMINISTRATIVE SUPPORT"), array("EEC007", "SKILLED CRAFT WORKERS"), array("EEC008", "SERVICE-MAINTENANCE"));    
        $this->assertEquals($test, $this->view->selectIndexId(2, '', -1));
    }
	
	public function testSelectIndexId_EEC_4() {
		$this->view->indexCode = "EEC";
		$test = array(array("EEC001", "OFFICIALS AND ADMINISTRATORS"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'EEC001', 0));
    }
	
	public function testSelectIndexId_EEC_5() {
		$this->view->indexCode = "EEC";
		$test = array(array("EEC006", "ADMINISTRATIVE SUPPORT"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'ADMINISTRATIVE SUPPORT', 1));
    }
	
	public function testSelectIndexId_EEC_6() {
		$this->view->indexCode = "EEC";
		$test = array(array("EEC005", "PARAPROFESSIONALS"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'PARA', 1));
    }
	
	public function testSelectIndexId_EEC_7() {
		$this->view->indexCode = "EEC";
		$test = array(array("EEC001", "OFFICIALS AND ADMINISTRATORS"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }
	
	public function testSelectIndexId_EEC_8() {
		$this->view->indexCode = "EEC";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_EEC_9() {
		$this->view->indexCode = "EEC";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	
	// LIC
	 
	/*public function testSelectIndexId_LIC_1() {
		$this->view->indexCode = "LIC";
		$test = array(array("LIC001", "Tamil"), array("LIC002", "French"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '', -1));
    }
	
	public function testSelectIndexId_LIC_2() {
		$this->view->indexCode = "LIC";
		$test = array(array("LIC001", "Tamil"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'LIC001', 0));
    }
	
	public function testSelectIndexId_LIC_3() {
		$this->view->indexCode = "LIC";
		$test = array(array("LIC002", "French"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'French', 1));
    }
	
	public function testSelectIndexId_LIC_4() {
		$this->view->indexCode = "LIC";
		$test = array( array("LIC001", "Tamil"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, 'Tam', 1));
    }
	
	public function testSelectIndexId_LIC_5() {
		$this->view->indexCode = "LIC";
		$test = array( array("LIC001", "Tamil"));    
        $this->assertEquals($test, $this->view->selectIndexId(0, '001', 0));
    }*/
	
	public function testSelectIndexId_LIC_6() {
		$this->view->indexCode = "LIC";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 0));
    }
	
	public function testSelectIndexId_LIC_7() {
		$this->view->indexCode = "LIC";		  
        $this->assertEquals('', $this->view->selectIndexId(0, 'Perm', 1));
    }
	 
    /**
     * @todo Implement testGetHeadingInfo().
     */
    public function testGetHeadingInfo() {
        $this->assertEquals(true,true);
		//  method is hard coded
    }

    /**
     * @todo Implement testGetInfo().
     */
    public function testGetInfo() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testGetPageName().
     */
    public function testGetPageName() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testCountList().
     */
    public function testCountList() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testAddData().
     */
    public function testAddData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testAddDesDisData().
     */
    public function testAddDesDisData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testUpdateDesDisData().
     */
    public function testUpdateDesDisData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testDelDesDisData().
     */
    public function testDelDesDisData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testUpdateData().
     */
    public function testUpdateData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testAssignData().
     */
    public function testAssignData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testDeleteData().
     */
    public function testDeleteData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testDelAssignData().
     */
    public function testDelAssignData() {
        // Remove the following line when you implement this test.
        $this->markTestIncomplete(
          "This test has not been implemented yet."
        );
    }

    /**
     * @todo Implement testReDirect().
     */
    public function testReDirect() {
        $this->assertEquals(true,true);
		//  No tests for HTML
    }
}

// Call ViewControllerTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "ViewControllerTest::main") {
    ViewControllerTest::main();
}
?>
