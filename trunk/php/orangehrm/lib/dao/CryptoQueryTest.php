<?php
// Call CryptoQueryTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'CryptoQueryTest::main');
}

require_once "testConf.php";
require_once 'PHPUnit/Framework.php';
require_once 'CryptoQuery.php';

require_once ROOT_PATH . '/lib/models/eimadmin/encryption/KeyHandler.php'; 

/**
 * Test class for CryptoQuery.
 * Generated by PHPUnit on 2008-05-29 at 17:46:18.
 */
class CryptoQueryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    CryptoQuery
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

        $suite  = new PHPUnit_Framework_TestSuite('CryptoQueryTest');
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
        $this->object = new CryptoQuery;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
    }

    /**
     * @todo Implement testIsEncTable().
     */
    public function testIsEncTable() {
        
        $this->assertTrue(CryptoQuery::isEncTable('hs_hr_employee'));
        $this->assertTrue(CryptoQuery::isEncTable('hs_hr_emp_basicsalary'));
        $this->assertFalse(CryptoQuery::isEncTable('hs_hr_emp_language'));
        
    }

    /**
     * @todo Implement testPrepareEncFields().
     */
    public function testPrepareDecryptFields() {
        
        $key = KeyHandler::readKey();
        
        $fields[]		= 'emp_ssn_num';
		$fields[]		= 'ebsal_basic_salary';
		$fields[]		= 'hs_hr_emp_language';

		$expected[] = "AES_DECRYPT(`emp_ssn_num`, '$key')";
		$expected[] = "AES_DECRYPT(`ebsal_basic_salary`, '$key')";
		$expected[] = "hs_hr_emp_language";
				
		mysql_connect('localhost', 'root', MYSQL_ROOT_PASSWORD);
		mysql_select_db('orangehrm');

		$result = CryptoQuery::prepareDecryptFields($fields);
		$this->assertEquals($expected, $result);
		
    }
    
    public function testPrepareEncryptFields() {

		$key = KeyHandler::readKey();
		
		$values[]		= '123456';
        $values[]		= 'abcd';
        $values[]		= 'pqr';

		$fields[]		= 'emp_ssn_num';
		$fields[]		= 'ebsal_basic_salary';
		$fields[]		= 'hs_hr_emp_language';
        
    	$expected[] = "AES_ENCRYPT(123456, '$key')";
		$expected[] = "AES_ENCRYPT(abcd, '$key')";
		$expected[] = "pqr";
    
    	$result = CryptoQuery::prepareEncryptFields($fields, $values);
		$this->assertEquals($expected, $result);
		
		$fields = null;
		$values = null;
		$expected = null;
		
		$fields[] = 'EMP_NUMBER';
		$fields[] = 'EMP_SMOKER';
		$fields[] = 'ETHNIC_RACE_CODE';
		$fields[] = 'EMP_BIRTHDAY';
		$fields[] = 'NATION_CODE';
		$fields[] = 'EMP_GENDER';
		$fields[] = 'EMP_MARITAL_STATUS';
		$fields[] = 'EMP_SSN_NUM';
		$fields[] = 'EMP_SIN_NUM';
		$fields[] = 'EMP_OTHER_ID';
		$fields[] = 'EMP_DRI_LICE_NUM';
		$fields[] = 'EMP_DRI_LICE_EXP_DATE';
		$fields[] = 'EMP_MILITARY_SERVICE';
	
		$values[] = '001';
		$values[] = '0';
		$values[] = null;
		$values[] = '0000-00-00';
		$values[] = null;
		$values[] = '1';
		$values[] = '0';
		$values[] = '125';
		$values[] = '123';
		$values[] = '';
    	$values[] = '';
	    $values[] = '0000-00-00';
    	$values[] = '';
	
		foreach($values as $value) {
			if ($value == null)
				$expected[] = null; 
			elseif ($value == 125)
				$expected[] = "AES_ENCRYPT($value, '$key')"; 
			else
				$expected[] = $value; 
		}
	
    	$result = CryptoQuery::prepareEncryptFields($fields, $values);
		$this->assertEquals($expected, $result);
    }

    /**
     * @todo Implement testIsEncField().
     */
    public function testIsEncField() {
    	
		$this->assertTrue(CryptoQuery::isEncField('emp_ssn_num'));
        $this->assertTrue(CryptoQuery::isEncField('ebsal_basic_salary'));
        $this->assertFalse(CryptoQuery::isEncField('sal_grd_code'));
 
    }
}

// Call CryptoQueryTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'CryptoQueryTest::main') {
    CryptoQueryTest::main();
}
?>
