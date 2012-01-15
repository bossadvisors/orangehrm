<?php

/**
 * Test class for OperationalCountryService.
 * Generated by PHPUnit on 2012-01-12 at 12:46:56.
 */
class OperationalCountryServiceTest extends PHPUnit_Framework_TestCase {

    /**
     * @var OperationalCountryService
     */
    protected $service;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->service = new OperationalCountryService;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers OperationalCountryService::getOperationalCountryDao
     */
    public function testGetOperationalCountryDao() {
        $result = $this->service->getOperationalCountryDao();
        $this->assertTrue($result instanceof OperationalCountryDao);
        
        $newOperationalCountryDao = new OperationalCountryDao();
        $this->service->setOperationalCountryDao($newOperationalCountryDao);
        $result = $this->service->getOperationalCountryDao();
        $this->assertEquals($newOperationalCountryDao, $result);
    }

    /**
     * @covers OperationalCountryService::setOperationalCountryDao
     */
    public function testSetOperationalCountryDao() {
        $operationalCountryDao = new OperationalCountryDao();
        $this->service->setOperationalCountryDao($operationalCountryDao);
        $result = $this->service->getOperationalCountryDao();
        $this->assertEquals($operationalCountryDao, $result);
    }

    /**
     * @covers OperationalCountryService::getOperationalCountryList
     */
    public function testGetOperationalCountryList_Successful() {
        $operationalCountryList = array();
        $operationalCountryList[] = new OperationalCountry();
        $operationalCountryList[] = new OperationalCountry();
        $operationalCountryList[] = new OperationalCountry();
        
        $operationalCountryDaoMock = $this->getMock('OperationalCountryDao', array('getOperationalCountryList'));
        $operationalCountryDaoMock->expects($this->once())
                ->method('getOperationalCountryList')
                ->will($this->returnValue($operationalCountryList));
        $this->service->setOperationalCountryDao($operationalCountryDaoMock);
        
        $result = $this->service->getOperationalCountryList();
        $this->assertEquals($operationalCountryList, $result);
    }
    
    /**
     * @covers OperationalCountryService::getOperationalCountryList
     * @expectedException ServiceException
     */
    public function testGetOperationalCountryList_WithException() {
        $operationalCountryDaoMock = $this->getMock('OperationalCountryDao', array('getOperationalCountryList'));
        $operationalCountryDaoMock->expects($this->once())
                ->method('getOperationalCountryList')
                ->will($this->throwException(new DaoException));
        $this->service->setOperationalCountryDao($operationalCountryDaoMock);
        
        $this->service->getOperationalCountryList();
    }
    
    /**
     * @covers OperationalCountryService::getLocationsMappedToOperationalCountry
     */
    public function testGetLocationsMappedToOperationalCountry_Success() {
        $locationList = array();
        $locationList[] = new Location();
        $locationList[] = new Location();
        $locationList[] = new Location();
        
        $sriLanka = new Country();
        $sriLanka->setName('Sri Lanka');
        
        $operationalCountry = new OperationalCountry();
        $operationalCountry->setId(1);
        $operationalCountry->setCountry($sriLanka);
        $operationalCountry->setCountryCode('LK');
        
        $operationalCountryDaoMock = $this->getMock('OperationalCountryDao', array('getLocationsMappedToOperationalCountry'));
        $operationalCountryDaoMock->expects($this->once())
                ->method('getLocationsMappedToOperationalCountry')
                ->will($this->returnValue($locationList));
        $result = $this->service->setOperationalCountryDao($operationalCountryDaoMock);
        
        $result = $this->service->getLocationsMappedToOperationalCountry($operationalCountry);
        $this->assertEquals($locationList, $result);
    }
    
    /**
     * @covers OperationalCountryService::getLocationsMappedToOperationalCountry
     * @expectedException ServiceException
     */
    public function testGetLocationsMappedToOperationalCountry_WithException() {
        $operationalCountry = new OperationalCountry();
        
        $operationalCountryDaoMock = $this->getMock('OperationalCountryDao', array('getLocationsMappedToOperationalCountry'));
        $operationalCountryDaoMock->expects($this->once())
                ->method('getLocationsMappedToOperationalCountry')
                ->will($this->throwException(new DaoException));
        $result = $this->service->setOperationalCountryDao($operationalCountryDaoMock);
        
        $this->service->getLocationsMappedToOperationalCountry($operationalCountry);
    }

}

?>
