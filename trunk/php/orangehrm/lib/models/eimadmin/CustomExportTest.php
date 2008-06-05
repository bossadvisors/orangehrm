<?php
// Call CustomExportTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "CustomExportTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once ROOT_PATH . '/lib/models/eimadmin/CustomExport.php';
require_once "testConf.php";

/**
 * Test class for CustomExport.
 * Generated by PHPUnit_Util_Skeleton on 2008-01-08 at 19:19:52.
 */
class CustomExportTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("CustomExportTest");
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
    	$this->_runQuery("TRUNCATE TABLE hs_hr_custom_export");

		// insert some test data
		$this->_runQuery("INSERT INTO hs_hr_custom_export(export_id, name, fields, headings) VALUES (1, 'Export 1', 'empId,lastName,firstName,middleName,street1,street2,city', '')");
		$this->_runQuery("INSERT INTO hs_hr_custom_export(export_id, name, fields, headings) VALUES (2, 'Export 2', 'empId,lastName,firstName,city', 'Employee Id,Last Name,First Name,City')");
		$this->_runQuery("INSERT INTO hs_hr_custom_export(export_id, name, fields, headings) VALUES (3, 'Export 3', 'empId,street1,street2,city', 'Employee Id,Address1, Address2, City')");

		$this->_runQuery("TRUNCATE TABLE hs_hr_custom_fields");
		$this->_runQuery("INSERT INTO hs_hr_custom_fields(field_num, name, type, extra_data) VALUES ('1', 'Blood Group', '0', '')");

		UniqueIDGenerator::getInstance()->resetIDs();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    	$this->_runQuery("TRUNCATE TABLE hs_hr_custom_export");
    	$this->_runQuery("TRUNCATE TABLE hs_hr_custom_fields");

    	UniqueIDGenerator::getInstance()->resetIDs();
    }

    /**
     * Implement getCustomExport
     */
    public function testGetCustomExport() {

    	// non existent id
    	$this->assertNull(CustomExport::getCustomExport(10));

    	// invalid id
    	try {
    		$export = CustomExport::getCustomExport('X1');
    		$this->fail("Should throw exception on invalid parameter");
	    } catch (CustomExportException $e) {
	    	$this->assertEquals(CustomExportException::INVALID_PARAMETERS, $e->getCode());
	    }

	    // valid id
    	$export = CustomExport::getCustomExport(1);
    	$this->assertEquals(1, $export->getId());
    	$this->assertEquals('Export 1', $export->getName());

    	$assignedFields = $export->getAssignedFields();
    	$expected = array('empId','lastName','firstName','middleName','street1','street2','city');
    	$this->assertTrue(is_array($assignedFields));
    	$this->assertEquals(count($expected), count($assignedFields));
		$diff = array_diff_assoc($expected, $assignedFields);
		$this->assertEquals(0, count($diff), "Assigned fields not correct");

    	$headers = $export->getHeadings();
    	$this->assertTrue(is_array($headers));
    	$this->assertEquals(0, count($headers));

    	$export = CustomExport::getCustomExport(2);
    	$this->assertEquals(2, $export->getId());
    	$this->assertEquals('Export 2', $export->getName());

    	$assignedFields = $export->getAssignedFields();
    	$expected = array('empId','lastName','firstName','city');
    	$this->assertTrue(is_array($assignedFields));
    	$this->assertEquals(count($expected), count($assignedFields));
		$diff = array_diff_assoc($expected, $assignedFields);
		$this->assertEquals(0, count($diff), "Assigned fields not correct");

    	$headers = $export->getHeadings();
    	$expectedHeader = array('Employee Id','Last Name','First Name','City');
    	$this->assertTrue(is_array($headers));
    	$this->assertEquals(count($expectedHeader), count($headers));
		$diff = array_diff_assoc($expectedHeader, $headers);
		$this->assertEquals(0, count($diff), "Header fields not correct");

    }

    /**
     * Test the getAllFields method
     */
    public function testGetAllFields() {

    	$allFields = CustomExport::getAllFields();

    	$this->assertTrue(!empty($allFields));
    	$this->assertTrue(is_array($allFields));

		// compare arrays considering order
		$expected = array("empId", "lastName",  "firstName", "middleName", "street1", "street2", "city",
                           "state", "zip", "gender", "birthDate", "ssn", "empStatus", "joinedDate", "workStation", "location",
                           "custom1",
                           "workState", "salary", "payFrequency",
		                   "FITWStatus", "FITWExemptions", "SITWState", "SITWStatus", "SITWExemptions",
                           "SUIState", "DD1Routing", "DD1Account", "DD1Amount",
                           "DD1AmountCode", "DD1Checking", "DD2Routing",
		                   "DD2Account", "DD2Amount", "DD2AmountCode", "DD2Checking");

		$diff = array_diff_assoc($expected, $allFields);
		$this->assertEquals($expected, $allFields);
		$this->assertEquals(0, count($diff), "Incorrect fields returned");

		// verify that there are no duplicates
		$unique = array_unique($allFields);
		$this->assertEquals(count($unique), count($allFields), "Duplicate field names found!");

		// verify that none of the fields have a comma in them
		foreach ($allFields as $field) {
			$this->assertTrue((strpos($field, ",") === false), "Field name contains comma");
		}
    }

    /**
     * Test method for getCustomExportList().
     */
    public function testGetCustomExportList() {
    	$list = CustomExport::getCustomExportList();
    	$this->assertTrue(is_array($list));
    	$this->assertEquals(3, count($list));

		$expected = array(1, 2, 3);
		foreach ($list as $export) {
			$key = array_search($export->getId(), $expected);
			$this->assertTrue($key !== false);
			unset($expected[$key]);
		}
		$this->assertTrue(empty($expected));

    	$this->_runQuery("DELETE FROM hs_hr_custom_export");
    	$list = CustomExport::getCustomExportList();
    	$this->assertTrue(is_array($list));
    	$this->assertEquals(0, count($list));
    }

    /**
     * Test for getCustomExportListForView().
     */
    public function testGetCustomExportListForView() {
    	$list = CustomExport::getCustomExportListForView(1,"","");
    	$this->assertTrue(is_array($list));
    	$this->assertEquals(3, count($list));

		$expected = array(1=>'Export 1', 2=>'Export 2', 3=>'Export 3');
		foreach ($list as $export) {
			$id = $export[0];
			$name = $export[1];

			$this->assertTrue(array_key_exists($id, $expected));
			$this->assertEquals($expected[$id], $name);
			unset($expected[$id]);
		}
		$this->assertTrue(empty($expected));

    	$this->_runQuery("DELETE FROM hs_hr_custom_export");
    	$list = CustomExport::getCustomExportListForView(1,"","");
    	$this->assertNull($list);
    }

    /**
     * Test the getAvailableFields() method
     */
    public function testGetAvailableFields() {

    	$allFields = CustomExport::getAllFields();
    	$allCount = count($allFields);

    	$export = new CustomExport();
		$export->setName("NewExport12");

		// Assign everything
		$export->setAssignedFields($allFields);
		$available = $export->getAvailableFields();
		$this->assertTrue(is_array($available));
		$this->assertEquals(0, count($available));

		// Assign 3 fields
		$assign = array("empId", "firstName","gender");
		$export->setAssignedFields($assign);
		$available = $export->getAvailableFields();
		$this->assertTrue(is_array($available));
		$this->assertEquals($allCount - 3, count($available));

		$expected = $allFields;
		unset($expected[array_search("empId", $expected)]);
		unset($expected[array_search("firstName", $expected)]);
		unset($expected[array_search("gender", $expected)]);

		// Verify arrays equal
		$diff = array_diff($expected, $available);
		$this->assertEquals(0, count($diff), "Arrays should be equal");
    }

    /**
     * Test deleteExports() method
     */
    public function testDeleteExports() {

		$countBefore = $this->_count();

		// invalid id parameter
		try {
			$deleted = CustomExport::deleteExports(1);
			$this->fail("Should throw an exception on invalid parameter");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::INVALID_PARAMETERS, $e->getCode());
		}

		try {
			$deleted = CustomExport::deleteExports(array(1, "xyz"));
			$this->fail("Should throw an exception on invalid parameter");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::INVALID_PARAMETERS, $e->getCode());
		}


		// empty array
		$ids = array();
		$deleted = CustomExport::deleteExports($ids);
		$this->assertEquals(0, $deleted);

		$count = $this->_count();
		$this->assertEquals($countBefore, $count);

		// one id
		$ids = array(1);
		$deleted = CustomExport::deleteExports($ids);
		$this->assertEquals(1, $deleted);

		$count = $this->_count();
		$this->assertEquals($countBefore - 1, $count);

		// two id's
		$ids = array(2, 3);
		$deleted = CustomExport::deleteExports($ids);
		$this->assertEquals(2, $deleted);

		$count = $this->_count();
		$this->assertEquals($countBefore - 3, $count);

    }

    /**
     * Test case for save() method for new custom export definition
     */
    public function testSaveNew() {

		$countBefore = $this->_count();

		// save with duplicate name should throw exception
		$export = new CustomExport();
		$export->setName("Export 1");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on duplicate name");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::DUPLICATE_EXPORT_NAME, $e->getCode(), $e->getMessage());
		}

		// Exception should be thrown on empty name
		$export = new CustomExport();
		$export->setName("");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on empty name");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::EMPTY_EXPORT_NAME, $e->getCode());
		}

		// save with empty fields should throw exception
		$export->setName("New Export 1");
		$export->setAssignedFields(array());
		try {
			$export->save();
			$this->fail("Exception should be thrown on empty assigned fields");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::NO_ASSIGNED_FIELDS, $e->getCode());
		}

		$export->setName("New Export 1");
		$export->setAssignedFields(null);
		try {
			$export->save();
			$this->fail("Exception should be thrown on empty assigned fields");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::NO_ASSIGNED_FIELDS, $e->getCode());
		}

		// save with field not in field list should throw exception
		$export->setName("New Export 1");
		$export->setAssignedFields(array("firstName", "lastName", "EmployeeId"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on invalid field");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::INVALID_FIELD_NAME, $e->getCode());
		}

		// save with field count != header count should throw exception
		$export->setName("New Export 1");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		$export->setHeadings(array("Employee Id", "Street 1", "Street 2", "Gender"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on empty assigned fields");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::HEADER_COUNT_DOESNT_MATCH_FIELD_COUNT, $e->getCode());
		}

		// save with header containing comma should throw exception
		$export->setName("New Export 1");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		$export->setHeadings(array("Employee Id", "Street 1", "Street, 2"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on invalid header names");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::INVALID_HEADER_NAME, $e->getCode());
		}

		// valid save, verify data saved
		$export->setName("New Export 1");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		$export->setHeadings(array("Employee Id", "Street 1", "Gender"));
		$export->save();

		$id = $export->getId();

		// verify id set
		$this->assertTrue(!empty($id));
		$this->assertEquals(4, $id);

		// verify saved
		$name = $export->getName();
		$fields = implode(",", $export->getAssignedFields());
		$header = implode(",", $export->getHeadings());

		$countAfter = $this->_count();
		$this->assertEquals(1, $countAfter - $countBefore);

		$count = $this->_count("export_id={$id} AND name='{$name}' AND fields='{$fields}' AND headings='{$header}'");
		$this->assertEquals(1, $count, "Not inserted");

		// should be able to save with empty headings
		$export2 = new CustomExport();
		$export2->setName("New Export 2");
		$export2->setAssignedFields(array("empId", "street1", "gender"));
		$export2->save();

		$id = $export2->getId();

		// verify id set
		$this->assertTrue(!empty($id));
		$this->assertEquals(5, $id);

		// verify saved
		$name = $export2->getName();
		$fields = implode(",", $export2->getAssignedFields());
		$header = "";

		$countAfter = $this->_count();
		$this->assertEquals(2, $countAfter - $countBefore);

		$count = $this->_count("export_id={$id} AND name='{$name}' AND fields='{$fields}' AND headings='{$header}'");
		$this->assertEquals(1, $count, "Not inserted");
    }

    /**
     * Test case for save() method for existing custom export definition
     */
    public function testSaveUpdate() {

		$countBefore = $this->_count();

		// save with duplicate name should throw exception
		$export = new CustomExport();

		// we set id = 2, so save should update the record with id=2
		$export->setId(2);

		$export->setName("Export 1");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on duplicate name");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::DUPLICATE_EXPORT_NAME, $e->getCode());
		}

		// save with empty fields should throw exception
		$export->setName("New Export 1");
		$export->setAssignedFields(array());
		try {
			$export->save();
			$this->fail("Exception should be thrown on empty assigned fields");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::NO_ASSIGNED_FIELDS, $e->getCode());
		}

		$export->setName("New Export 1");
		$export->setAssignedFields(null);
		try {
			$export->save();
			$this->fail("Exception should be thrown on empty assigned fields");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::NO_ASSIGNED_FIELDS, $e->getCode());
		}

		// save with field not in field list should throw exception
		$export->setName("New Export 1");
		$export->setAssignedFields(array("firstName", "lastName", "EmployeeId"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on invalid field");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::INVALID_FIELD_NAME, $e->getCode());
		}

		// save with field count != header count should throw exception
		$export->setName("New Export 1");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		$export->setHeadings(array("Employee Id", "Street 1", "Street 2", "Gender"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on header count mismatch");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::HEADER_COUNT_DOESNT_MATCH_FIELD_COUNT, $e->getCode());
		}

		// save with header containing comma should throw exception
		$export->setName("New Export 1");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		$export->setHeadings(array("Employee Id", "Street 1", "Street, 2"));
		try {
			$export->save();
			$this->fail("Exception should be thrown on invalid header name");
		} catch (CustomExportException $e) {
			$this->assertEquals(CustomExportException::INVALID_HEADER_NAME, $e->getCode());
		}

		// valid save, verify data saved
		$export->setName("New Export 1");
		$export->setAssignedFields(array("empId", "street1", "gender"));
		$export->setHeadings(array("Employee Id", "Street 1", "Gender"));
		$export->save();

		$id = $export->getId();

		// verify id not changed
		$this->assertTrue(!empty($id));
		$this->assertEquals(2, $id);

		// verify saved
		$name = $export->getName();
		$fields = implode(",", $export->getAssignedFields());
		$header = implode(",", $export->getHeadings());

		$countAfter = $this->_count();
		$this->assertEquals($countAfter, $countBefore);

		$count = $this->_count("export_id={$id} AND name='{$name}' AND fields='{$fields}' AND headings='{$header}'");
		$this->assertEquals(1, $count, "Not Updated");

		// Save without changing anything
		$export->save();

		$id = $export->getId();

		// verify id not changed
		$this->assertTrue(!empty($id));
		$this->assertEquals(2, $id);
		$countAfter = $this->_count();
		$this->assertEquals($countAfter, $countBefore);

		$count = $this->_count("export_id={$id} AND name='{$name}' AND fields='{$fields}' AND headings='{$header}'");
		$this->assertEquals(1, $count, "Not Updated");

    }

	private function _runQuery($sql) {
		$this->assertTrue(mysql_query($sql), mysql_error());
	}

	/**
	 * Count the number of rows in the database with the give condition
	 *
	 * @param string $where Optional where condition
	 * @return int Number of matching rows in database
	 */
    private function _count($where = null) {

    	$sql = "SELECT COUNT(*) FROM hs_hr_custom_export";
    	if (!empty($where)) {
    		$sql .= " WHERE " . $where;
    	}
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result, MYSQL_NUM);
        $count = $row[0];
		return $count;
    }

}

// Call CustomExportTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "CustomExportTest::main") {
    CustomExportTest::main();
}
?>
