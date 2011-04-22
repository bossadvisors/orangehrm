<?php

require_once 'PHPUnit/Framework.php';

/**
 * Test class for LabelCell.
 * Generated by PHPUnit on 2011-04-22 at 00:51:56.
 */
class LabelCellTest extends PHPUnit_Framework_TestCase {

    /**
     * @var LabelCell
     */
    protected $labelCell;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->labelCell = new LabelCell;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    public function test__toString() {
        $dataObject = new LabelCellTestDataObject();
        $dataObject->getName = create_function('', "return 'Kayla Abbey';");

        $this->labelCell->setDataobject($dataObject);
        $this->labelCell->setProperties(array('getter' => 'getDescription'));

        $this->assertEquals('Sample class', $this->labelCell->__toString());
    }

}

class LabelCellTestDataObject {

    public function getDescription() {
        return 'Sample class';
    }
}
?>
