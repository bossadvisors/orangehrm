<?php

require_once 'PHPUnit/Framework.php';
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

class CompanyStructureDaoTest extends PHPUnit_Framework_TestCase {

    private $companyStructureDao;
    protected $fixture;

    /**
     * Set up method
     */
    protected function setUp() {

        $this->companyStructureDao = new CompanyStructureDao();
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmAdminPlugin/test/fixtures/CompanyStructureDao.yml';
        TestDataService::populate($this->fixture);
    }

    public function testSetOrganizationName() {
        $this->assertEquals($this->companyStructureDao->setOrganizationName("OrangeHRM"), 1);
    }

    public function testGetSubunit() {
        $this->assertTrue($this->companyStructureDao->getSubunit(1) instanceof Subunit);
    }

    public function testSaveSubunit() {
        $subunit = new Subunit();
        $subunit->setName("Open Source");
        $subunit->setDescription("Handles OrangeHRM product");
        $subunit->setLft(5);
        $subunit->setRgt(3);
        $subunit->setLevel(1);
        $this->assertTrue($this->companyStructureDao->saveSubunit($subunit));
    }

    public function testDeleteSubunit() {
        $subunit = new Subunit();
        $subunit->setLft(2);
        $subunit->setRgt(5);
        $this->assertTrue($this->companyStructureDao->deleteSubunit($subunit));
    }

    public function testAddSubunit(){
        $subunitList = TestDataService::loadObjectList('Subunit', $this->fixture, 'Subunit');
        $subunit = $subunitList[2];
        $parentSubunit = new Subunit();
        $parentSubunit->setName("New Department");
        $this->assertTrue($this->companyStructureDao->addSubunit($parentSubunit, $subunit));
    }

}

