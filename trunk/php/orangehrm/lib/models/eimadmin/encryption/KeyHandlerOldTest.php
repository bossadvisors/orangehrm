<?php
// Call KeyHandlerOldTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'KeyHandlerOldTest::main');
}

;

require_once 'KeyHandlerOld.php';
require_once ROOT_PATH.'/lib/dao/DMLFunctions.php';

/**
 * Test class for KeyHandlerOld.
 * Generated by PHPUnit on 2008-05-28 at 12:58:19.
 */
class KeyHandlerOldTest extends PHPUnit_Framework_TestCase {

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('KeyHandlerOldTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
	
		$filePath = ROOT_PATH . '/lib/confs/cryptokeys/key.ohrm';
	
		if (file_exists($filePath)) {
			$this->assertTrue(copy($filePath,  "$filePath.bak"));		
			$this->assertTrue(@unlink($filePath));						
		}

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
	
		$filePath = ROOT_PATH . '/lib/confs/cryptokeys/key.ohrm';

		if (file_exists($filePath)) {
			$this->assertTrue(@unlink($filePath));
		}		 
	
		if (file_exists("$filePath.bak")) {
		
			copy("$filePath.bak",  $filePath);	
			$this->assertTrue(@unlink("$filePath.bak"));
			
		}

    }

    /**
     * @todo Implement testCreateKey().
     */
    public function testCreateKey() {

		$filePath = ROOT_PATH . '/lib/confs/cryptokeys/key.ohrm'; 
		
		// Checking function when key does not exitst 
		 $this->assertTrue(KeyHandlerOld::createKey());
		 
		$keyLength = strlen(trim(file_get_contents($filePath)));
		
		$this->assertTrue(file_exists($filePath));
		$this->assertTrue(is_readable($filePath));
		$this->assertEquals(128, $keyLength);
		
		// Checking function when key already exitst
		try {
		
			KeyHandlerOld::createKey();
			
		} catch (Exception $e) {
		
			$this->assertEquals(KeyHandlerOldException::KEY_ALREADY_EXISTS, $e->getCode());
			$this->assertTrue(file_exists($filePath));
			$this->assertTrue(is_readable($filePath));
			$this->assertEquals(128, $keyLength);
			
		}


    }

    /**
     * @todo Implement testReadKey().
     */
    public function testReadKey() {

		// When key is not available
		try {
		
			$key = KeyHandlerOld::readKey();
			
		} catch (Exception $e) {
		
			$this->assertEquals(KeyHandlerOldException::KEY_DOES_NOT_EXIST, $e->getCode());
		
		}
		
		// When key is existing
		$this->assertTrue(KeyHandlerOld::createKey());
		$key = KeyHandlerOld::readKey();
		$keyLength = strlen($key);
		
		$this->assertNotNull($key);
		$this->assertTrue(is_string($key));
		$this->assertEquals(128, $keyLength);

		// When key is not readable
		$filePath = ROOT_PATH . '/lib/confs/cryptokeys/key.ohrm';
		system("chmod 000 $filePath");

		try {
		
			$key = KeyHandlerOld::readKey();
			
		} catch (Exception $e) {
		
			$this->assertEquals(KeyHandlerOldException::KEY_NOT_READABLE, $e->getCode());
		
		}
		
		// When key is again readable
		system("chmod 777 $filePath");
		$key = KeyHandlerOld::readKey();
		$keyLength = strlen($key);
		
		$this->assertNotNull($key);
		$this->assertTrue(is_string($key));
		$this->assertEquals(128, $keyLength);

    }

    /**
     * @todo Implement testDeleteKey().
     */
    public function testDeleteKey() {

		// When key is not available
		try {
		
			KeyHandlerOld::deleteKey();
			
		} catch (Exception $e) {
		
			$this->assertEquals(KeyHandlerOldException::KEY_DOES_NOT_EXIST, $e->getCode());
		
		}
		
		// When key is existing
		$filePath = ROOT_PATH . '/lib/confs/cryptokeys/key.ohrm';
		$this->assertTrue(KeyHandlerOld::createKey());
		 
		$this->assertTrue(KeyHandlerOld::deleteKey());
		
		$this->assertFalse(file_exists($filePath));

		// When key is existing, but cannot be deleted
		$this->assertTrue(KeyHandlerOld::createKey());
		system("chmod 000 $filePath");
		
		try {
		
			KeyHandlerOld::deleteKey();
			
		} catch (Exception $e) {

			$this->assertEquals(KeyHandlerOldException::KEY_DELETION_FAILIURE, $e->getCode());
		
		}

		
    }
	
}

// Call KeyHandlerOldTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'KeyHandlerOldTest::main') {
    KeyHandlerOldTest::main();
}
?>
