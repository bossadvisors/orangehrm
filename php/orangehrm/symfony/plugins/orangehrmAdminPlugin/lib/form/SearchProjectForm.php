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
 *
 */
class SearchProjectForm extends BaseForm {

    private $customerService;
    private $projectService;

    public function getProjectService() {
        if (is_null($this->projectService)) {
            $this->projectService = new ProjectService();
            $this->projectService->setProjectDao(new ProjectDao());
        }
        return $this->projectService;
    }

    public function getCustomerService() {
        if (is_null($this->customerService)) {
            $this->customerService = new CustomerService();
            $this->customerService->setCustomerDao(new CustomerDao());
        }
        return $this->customerService;
    }

    public function configure() {
        $this->setWidgets(array(
            'customer' => new sfWidgetFormInputText(),
            'project' => new sfWidgetFormInputText(),
            'projectAdmin' => new sfWidgetFormInputText()
        ));

        $this->setValidators(array(
            'customer' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'project' => new sfValidatorString(array('required' => false, 'max_length' => 100)),
            'projectAdmin' => new sfValidatorString(array('required' => false, 'max_length' => 100))
        ));

        $this->widgetSchema->setNameFormat('searchProject[%s]');
    }

    public function setDefaultDataToWidgets($searchClues){
        $this->setDefault('customer', $searchClues['customer']);
        $this->setDefault('project', $searchClues['project']);
        $this->setDefault('projectAdmin', $searchClues['projectAdmin']);
    }

    public function getProjectAdminListAsJson() {

        $jsonArray = array();
        $employeeService = new EmployeeService();
        $employeeService->setEmployeeDao(new EmployeeDao());

        $employeeList = $employeeService->getEmployeeList();

        foreach ($employeeList as $employee) {
            $jsonArray[] = array('name' => $employee->getFullName(), 'id' => $employee->getEmpNumber());
        }

        $jsonString = json_encode($jsonArray);

        return $jsonString;
    }

    public function getCustomerListAsJson() {
        $jsonArray = array();
        $customerList = $this->getCustomerService()->getAllCustomers();
        foreach ($customerList as $customer) {
            $jsonArray[] = array('name' => $customer->getName(), 'id' => $customer->getCustomerId());
        }
        $jsonString = json_encode($jsonArray);
        return $jsonString;
    }

    public function getProjectListAsJson() {
        $jsonArray = array();
        $projectList = $this->getProjectService()->getAllActiveProjects();
        foreach ($projectList as $project) {
            $jsonArray[] = array('name' => $project->getName(), 'id' => $project->getProjectId());
        }
        $jsonString = json_encode($jsonArray);
        return $jsonString;
    }

}

