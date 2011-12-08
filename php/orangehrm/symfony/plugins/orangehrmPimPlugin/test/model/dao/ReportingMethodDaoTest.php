<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
require_once sfConfig::get('sf_test_dir') . '/util/TestDataService.php';

/**
 * @group Admin
 */
class ReportingMethodDaoTest extends PHPUnit_Framework_TestCase {

	private $reportingMethodDao;
	protected $fixture;

	/**
	 * Set up method
	 */
	protected function setUp() {

		$this->reportingMethodDao = new ReportingMethodDao();
		$this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/ReportingMethodDao.yml';
		TestDataService::populate($this->fixture);
	}

    public function testAddReportingMethod() {
        
        $reportingMethod = new ReportingMethod();
        $reportingMethod->setName('Tamil');
        
        $this->reportingMethodDao->saveReportingMethod($reportingMethod);
        
        $savedReportingMethod = TestDataService::fetchLastInsertedRecord('ReportingMethod', 'id');
        
        $this->assertTrue($savedReportingMethod instanceof ReportingMethod);
        $this->assertEquals('Tamil', $savedReportingMethod->getName());
        
    }
    
    public function testEditReportingMethod() {
        
        $reportingMethod = TestDataService::fetchObject('ReportingMethod', 3);
        $reportingMethod->setName('Canadian French');
        
        $this->reportingMethodDao->saveReportingMethod($reportingMethod);
        
        $savedReportingMethod = TestDataService::fetchLastInsertedRecord('ReportingMethod', 'id');
        
        $this->assertTrue($savedReportingMethod instanceof ReportingMethod);
        $this->assertEquals('Canadian French', $savedReportingMethod->getName());
        
    }
    
    public function testGetReportingMethodById() {
        
        $reportingMethod = $this->reportingMethodDao->getReportingMethodById(1);
        
        $this->assertTrue($reportingMethod instanceof ReportingMethod);
        $this->assertEquals('Spanish', $reportingMethod->getName());
        
    }
    
    public function testGetReportingMethodList() {
        
        $reportingMethodList = $this->reportingMethodDao->getReportingMethodList();
        
        foreach ($reportingMethodList as $reportingMethod) {
            $this->assertTrue($reportingMethod instanceof ReportingMethod);
        }
        
        $this->assertEquals(3, count($reportingMethodList));        
        
        /* Checking record order */
        $this->assertEquals('English', $reportingMethodList[0]->getName());
        $this->assertEquals('Spanish', $reportingMethodList[2]->getName());
        
    }
    
    public function testDeleteReportingMethods() {
        
        $result = $this->reportingMethodDao->deleteReportingMethods(array(1, 2));
        
        $this->assertEquals(2, $result);
        $this->assertEquals(1, count($this->reportingMethodDao->getReportingMethodList()));       
        
    }
    
    public function testDeleteWrongRecord() {
        
        $result = $this->reportingMethodDao->deleteReportingMethods(array(4));
        
        $this->assertEquals(0, $result);
        
    }
    
    public function testIsExistingReportingMethodName() {
        
        $this->assertTrue($this->reportingMethodDao->isExistingReportingMethodName('Spanish'));
        $this->assertTrue($this->reportingMethodDao->isExistingReportingMethodName('SPANISH'));
        $this->assertTrue($this->reportingMethodDao->isExistingReportingMethodName('spanish'));
        $this->assertTrue($this->reportingMethodDao->isExistingReportingMethodName('  Spanish  '));
        
    }
    
}
