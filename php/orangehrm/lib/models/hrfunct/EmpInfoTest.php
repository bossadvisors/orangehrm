<?php
// Call EmpInfoTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'EmpInfoTest::main');
}

require_once 'PHPUnit/Framework.php';

require_once 'EmpInfo.php';

/**
 * Test class for EmpInfo.
 * Generated by PHPUnit on 2008-02-28 at 15:18:53.
 */
class EmpInfoTest extends PHPUnit_Framework_TestCase {
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite('EmpInfoTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    }



    public function testGetFullName() {

    }
}

// Call EmpInfoTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'EmpInfoTest::main') {
    EmpInfoTest::main();
}
?>
