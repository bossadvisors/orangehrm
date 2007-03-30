<?php
// Call CustomerTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "CustomerTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'Customer.php';


/**
 * Test class for Customer.
 * Generated by PHPUnit_Util_Skeleton on 2007-03-22 at 15:38:57.
 */
class CustomerTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("CustomerTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {

    	$this->classCustomer = new Customer();

    	$conf = new Conf();

    	$this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);

        mysql_select_db($conf->dbname);

		mysql_query("TRUNCATE TABLE `hs_hr_customer`");

        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1001','zanfer1','forrw',0 )");
        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1002','zanfer2','forrw',0 )");
        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1003','zanfer3','forrw',0 )");
        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1004','zanfer4','forrw',0 )");
        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1005','zanfer5','forrw',0 )");
        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1006','zanfer6','forrw',0 )");
        mysql_query("INSERT INTO `hs_hr_customer` VALUES ('1007','zanfer7','forrw',0 )");

    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {

    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` = '1001'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` = '1002'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` = '1003'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` = '1004'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` = '1005'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` = '1006'", $this->connection);
    	mysql_query("DELETE FROM `hs_hr_customer` WHERE `customer_id` = '1007'", $this->connection);

		mysql_query("TRUNCATE TABLE `hs_hr_customer`", $this->connection);
    }


    public function testAddCustomer() {

    	$this->classCustomer->setCustomerId("1008");
    	$this->classCustomer->setCustomerName("Dodle");
    	$this->classCustomer->setCustomerDescription("jhgjhg");


    	$res  = $this->classCustomer->addCustomer();
    	$res  = $this->classCustomer->fetchCustomer("1008");
	    $this->assertNotNull($res, "No record found");

	   $this->assertEquals($res->getCustomerId(),'1008','Id Not Found');
	   $this->assertEquals($res->getCustomerName(),'Dodle','Name Not Found');
	   $this->assertEquals($res->getCustomerDescription(),'jhgjhg','Description Not Found');

    }

    public function testUpdateCustomer() {

		$res  = $this->classCustomer->fetchCustomer("1007");
		$this->assertNotNull($res, "No record found");
    	$res->setCustomerName("BoooBU");
    	$res->updateCustomer();
    	$res  = $this->classCustomer->fetchCustomer("1007");
    	$this->assertNotNull($res, "No record found");

	   $this->assertEquals($res->getCustomerId(),'1007','Id Not Found');
	   $this->assertEquals($res->getCustomerName(),'BoooBU','Name Not Found');
	   $this->assertEquals($res->getCustomerDescription(),'forrw','Description Not Found');


    }

    /**
     * @todo Implement testDeleteCustomer().
     */
    public function testDeleteCustomer() {

       $res  = $this->classCustomer->fetchCustomer("1007");
        $this->assertNotNull($res, "record Not found");

    	$res->deleteCustomer();
    	$res  = $this->classCustomer->fetchCustomer("1007");
    	$this->assertNull($res, "record found");


    }

    /**
     * @todo Implement testGetListofCustomers().
     */
    public function testGetListofCustomers() {


       $res = $this->classCustomer->getListofCustomers($pageNO=0,$schStr='',$mode=-1, $sortField=0, $sortOrder='ASC');
      $this->assertNotNull($res, "record Not found");



      $this->assertEquals(count($res), 7,'count incorrect');

      $expected[0] = array('1001', 'zanfer1', 'forrw', '0');
      $expected[1] = array('1002', 'zanfer2', 'forrw', '0');
      $expected[2] = array('1003', 'zanfer3', 'forrw', '0');
      $expected[3] = array('1004', 'zanfer4', 'forrw', '0');
      $expected[4] = array('1005', 'zanfer5', 'forrw', '0');
      $expected[5] = array('1006', 'zanfer6', 'forrw', '0');
      $expected[6] = array('1007', 'zanfer7', 'forrw', '0');

      $i= 0;

		for ($i=0; $i<count($res); $i++) {

		$this->assertSame($expected[$i][0], $res[$i][0], 'Wrong Cus Request Id');
		$this->assertSame($expected[$i][1], $res[$i][1], 'Wrong Cus Name ');
		$this->assertSame($expected[$i][2], $res[$i][2], 'Wrong Cus Name ');


      }



    }

    /**
     * @todo Implement testFetchCustomers().
     */
    public function testFetchCustomers() {

       $res = $this->classCustomer->fetchCustomers();
      $this->assertNotNull($res, "record Not found");

      $this->assertEquals(count($res), 7,'count incorrect');

      $expected[0] = array('1001', 'zanfer1', 'forrw', '0');
      $expected[1] = array('1002', 'zanfer2', 'forrw', '0');
      $expected[2] = array('1003', 'zanfer3', 'forrw', '0');
      $expected[3] = array('1004', 'zanfer4', 'forrw', '0');
      $expected[4] = array('1005', 'zanfer5', 'forrw', '0');
      $expected[5] = array('1006', 'zanfer6', 'forrw', '0');
      $expected[6] = array('1007', 'zanfer7', 'forrw', '0');

      $i= 0;

		for ($i=0; $i<count($res); $i++) {

		$this->assertSame($expected[$i][0], $res[$i]->getCustomerId(), 'Wrong Cus Request Id');
		$this->assertSame($expected[$i][1], $res[$i]->getCustomerName(), 'Wrong Cus Name ');
		$this->assertSame($expected[$i][2], $res[$i]->getCustomerDescription(), 'Wrong Cus Name ');

      }

    }

    /**
     * @todo Implement testFetchCustomer().
     */
    public function testFetchCustomer() {

        $res  = $this->classCustomer->fetchCustomer("1005");
		$this->assertNotNull($res, "No record found");

		$this->assertEquals($res->getCustomerId(),'1005','Id Not Found');
	    $this->assertEquals($res->getCustomerName(),'zanfer5','Name Not Found');
	    $this->assertEquals($res->getCustomerDescription(),'forrw','Description Not Found');

    }

    /**
     * @todo Implement testGetLastRecord().
     */
    public function testGetLastRecord() {

        $res = $this->classCustomer->getLastRecord();
        $this->assertNotNull($res, "No record found");

        $this->assertEquals($res,'1008','Invalid last id');


    }
}

// Call CustomerTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "CustomerTest::main") {
    CustomerTest::main();
}
?>
