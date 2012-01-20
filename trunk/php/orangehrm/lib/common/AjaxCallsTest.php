<?php
// Call AjaxCallsTest::main() if this source file is executed directly.
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AjaxCallsTest::main');
}


require_once 'AjaxCalls.php';

/**
 * Test class for AjaxCalls.
 * Generated by PHPUnit on 2008-06-24 at 16:46:28.
 */
class AjaxCallsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    AjaxCalls
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

        $suite  = new PHPUnit_Framework_TestSuite('AjaxCallsTest');
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
        $this->object = new AjaxCalls;
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
     * @todo Implement testFetchOptions().
     */
    public function testFetchOptions() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}

// Call AjaxCallsTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == 'AjaxCallsTest::main') {
    AjaxCallsTest::main();
}
?>
