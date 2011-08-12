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
class displayProjectReportCriteriaAction extends displayReportCriteriaAction {

    public function setReportCriteriaInfoInRequest($formValues) {

        $projectService = new ProjectService();
        $projectId = $formValues["project_name"];
        $projectName = $projectService->getProjectName($projectId);

        $this->getRequest()->setParameter('projectName', $projectName);
        $this->getRequest()->setParameter('projectDateRangeFrom', $formValues["project_date_range"]["from"]);
        $this->getRequest()->setParameter('projectDateRangeTo', $formValues["project_date_range"]["to"]);
    }

    public function setForward() {
        $this->forward('time', 'displayProjectReport');
    }

    public function hasStaticColumns() {
        return true;
    }

    public function setStaticColumns($formValues) {

        $staticColumns["fromDate"] = "1970-01-01";
        $staticColumns["toDate"] = date("Y-m-d");

        if (($formValues["project_date_range"]["from"] != "YYYY-MM-DD") && ($formValues["project_date_range"]["to"] != "YYYY-MM-DD")) {
            $staticColumns["fromDate"] = $formValues["project_date_range"]["from"];
            $staticColumns["toDate"] = $formValues["project_date_range"]["to"];
        } else if (($formValues["project_date_range"]["from"] != "YYYY-MM-DD") && ($formValues["project_date_range"]["to"] == "YYYY-MM-DD")) {
            $staticColumns["fromDate"] = $formValues["project_date_range"]["from"];
        } else if (($formValues["project_date_range"]["from"] == "YYYY-MM-DD") && ($formValues["project_date_range"]["to"] != "YYYY-MM-DD")) {
            $staticColumns["toDate"] = $formValues["project_date_range"]["to"];
        }

        $staticColumns["projectId"] = $formValues["project_name"];

        return $staticColumns;
    }

}

