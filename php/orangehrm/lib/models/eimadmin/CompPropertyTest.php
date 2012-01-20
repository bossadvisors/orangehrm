<?php
// Call CompPropertyTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'CompPropertyTest::main');
}

require_once "testConf.php";

require_once 'CompProperty.php';

/**
 * Test class for CompProperty.
 * Generated by PHPUnit on 2008-02-22 at 12:54:05.
 */
class CompPropertyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    CompProperty
     * @access protected
     */
    protected $object;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main()
    {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('CompPropertyTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $conf = new Conf();
        $this->connection = mysql_connect($conf->dbhost.":".$conf->dbport, $conf->dbuser, $conf->dbpass);
        mysql_select_db($conf->dbname);

        mysql_query("TRUNCATE TABLE `hs_hr_comp_property`", $this->connection);


    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
        mysql_query("TRUNCATE TABLE `hs_hr_comp_property`", $this->connection);
        mysql_close($this->connection);
    }

    /**
     * @todo Implement testAddProperty().
     */
    public function testAddProperty() {

        mysql_query("TRUNCATE TABLE `hs_hr_comp_property`", $this->connection);

        $prop = new CompProperty();
        $prop->setPropName('new Item');
        $prop->addProperty();

        $res=mysql_query("SELECT * FROM `hs_hr_comp_property`", $this->connection);

        $row=mysql_fetch_array($res);

        $this->assertEquals($row['prop_name'],'new Item');
        $this->assertEquals($row['prop_id'],'1');
    }

    /**
     * @todo Implement testEditProperty().
     */
    public function testEditProperty() {
        mysql_query("TRUNCATE TABLE `hs_hr_comp_property`", $this->connection);

        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item','1')", $this->connection);

        $prop = new CompProperty();
        $prop->setPropName('new Item Edited');
        $prop->editProperty(1);



        $res=mysql_query("SELECT * FROM `hs_hr_comp_property`", $this->connection);

        $row=mysql_fetch_array($res);

        $this->assertEquals($row['prop_name'],'new Item Edited');
        $this->assertEquals($row['emp_id'],'1');
        $this->assertEquals($row['prop_id'],'1');
    }

    /**
     * @todo Implement testGetPropertyList().
     */
    public function testGetPropertyList() {
        mysql_query("TRUNCATE TABLE `hs_hr_comp_property`", $this->connection);

        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item','1')", $this->connection);
        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item 2','10')", $this->connection);

        $prop = new CompProperty();
        $prop->setPropName('new Item Edited');
        $rows=$prop->getPropertyList();


        $this->assertEquals($rows[0]['prop_name'],'new Item');
        $this->assertEquals($rows[0]['emp_id'],'1');
        $this->assertEquals($rows[0]['prop_id'],'1');


        $this->assertEquals($rows[1]['prop_name'],'new Item 2');
        $this->assertEquals($rows[1]['emp_id'],'10');
        $this->assertEquals($rows[1]['prop_id'],'2');
    }

    /**
     * @todo Implement testEditPropertyList().
     */
    public function testEditPropertyList() {
        mysql_query("TRUNCATE TABLE `hs_hr_comp_property`", $this->connection);

        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item','1')", $this->connection);
        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item 2','10')", $this->connection);

        $prop = new CompProperty();
        $prop->setEditPropIds(array('1','2'));
        $prop->setEditEmpIds(array('5','6'));
        $prop->editPropertyList();

        $res=mysql_query("SELECT * FROM `hs_hr_comp_property`", $this->connection);

        $row=mysql_fetch_array($res);

        $this->assertEquals($row['prop_name'],'new Item');
        $this->assertEquals($row['emp_id'],'5');
        $this->assertEquals($row['prop_id'],'1');

        $row=mysql_fetch_array($res);

        $this->assertEquals($row['prop_name'],'new Item 2');
        $this->assertEquals($row['emp_id'],'6');
        $this->assertEquals($row['prop_id'],'2');
    }

    /**
     * @todo Implement testDeleteProperties().
     */
    public function testDeleteProperties() {
        mysql_query("TRUNCATE TABLE `hs_hr_comp_property`", $this->connection);

        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item','1')", $this->connection);
        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item 2','10')", $this->connection);
        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item 3','11')", $this->connection);
        mysql_query("INSERT INTO `hs_hr_comp_property` (`prop_name`,`emp_id`) VALUES ('new Item 5','20')", $this->connection);

        $prop = new CompProperty();
        $prop->setDeleteList(array('2','3'));
        $prop->deleteProperties();

        $res=mysql_query("SELECT * FROM `hs_hr_comp_property`", $this->connection);

        $numRows= mysql_num_rows($res);
        $this->assertEquals($numRows,2,'Number of rows invalid');

        $row=mysql_fetch_array($res);

        $this->assertEquals($row['prop_name'],'new Item');
        $this->assertEquals($row['emp_id'],'1');
        $this->assertEquals($row['prop_id'],'1');

        $row=mysql_fetch_array($res);

        $this->assertEquals($row['prop_name'],'new Item 5');
        $this->assertEquals($row['emp_id'],'20');
        $this->assertEquals($row['prop_id'],'4');
    }
}

// Call CompPropertyTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'CompPropertyTest::main') {
    CompPropertyTest::main();
}
?>
