<?php

/**
 * Test class for OperationalCountryDao.
 * Generated by PHPUnit on 2012-01-12 at 12:47:49.
 */
class OperationalCountryDaoTest extends PHPUnit_Framework_TestCase {

    /**
     * @var OperationalCountryDao
     */
    protected $dao;
    protected $fixture;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->dao = new OperationalCountryDao;
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/OperationalCountryDao.yml';
        TestDataService::populate($this->fixture);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers OperationalCountryDao::getOperationalCountryList
     */
    public function testGetOperationalCountryList_Successful() {
        $result = $this->dao->getOperationalCountryList();
        
        $this->assertTrue($result instanceof Doctrine_Collection);
        $this->assertEquals(4, $result->count());
        
        $sampleData = sfYaml::load($this->fixture);
        $sampleData = $sampleData['OperationalCountry'];
        foreach ($result as $i => $operationalCountry) {
            $this->assertTrue($operationalCountry instanceof OperationalCountry);
            $this->assertEquals($sampleData[$i]['id'], $operationalCountry->getId());
            $this->assertEquals($sampleData[$i]['name'], $operationalCountry->getName());
            $this->assertEquals($sampleData[$i]['code'], $operationalCountry->getCode());
        }
    }

}

?>
