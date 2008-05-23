<?php
// Call CryptoTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'CryptoTest::main');
}

require_once 'PHPUnit/Framework.php';

require_once 'Crypto.php';

/**
 * Test class for Crypto.
 * Generated by PHPUnit on 2008-05-15 at 11:56:19.
 */
class CryptoTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    Crypto
     * @access protected
     */

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main()
    {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('CryptoTest');
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
	
	public function testEncryptDecrypt() {
	
		$values[] = "abcd";
		$values[] = "";
		$values[] = null;
		$values[] = 1234;
		$values[] = 1234.25;
		$values[] = 1234.3165434654;
		$values[] = "1234";
		$values[] = "abcd1234";
		$values[] = "!@#$%^&*()_+|";
		$values[] = "!@#abcs$%^&*()_+|";
		$values[] = "!@#$%^12345&*()_+|";
		$values[] = "OrangeHRM is a Human Resource Management (HRM) business solution for the Small and Medium-sized Enterprise (SME). It is developed on PHP, MySQL and Apache HTTP Server and can be downloaded to use on both the Linux operating system and Microsoft Windows.

OrangeHRM is released under the GNU General Public License,[1] and is thus free software.

As of June 25, 2007, the current stable version of OrangeHRM is version 2.2, which consists of 7 different modules:

    * Administration Module
    * Personal Information Management Module
    * Reports Module
    * Employee Self Service Module
    * Time and Attendance Management Module
    * Leave Management Module
    * Bug Tracking Module

The project was started during autumn 2005 by hSenid Software International and launched on SourceForge in January 2006. By February 2007, it reached top 10 on the activity ranking out of more than 140,000 listed projects.";
		
		$crypt = Crypto::getInstance();
		$i = 1;
		
		foreach($values as $value) {
		
			$expected = $value;
			$result = $crypt->decode($crypt ->encode($value));
			
			$this->assertEquals($expected, $result, "Failed at " . $i++);
		
		}
	
	}

}

// Call CryptoTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'CryptoTest::main') {
    CryptoTest::main();
}
?>
