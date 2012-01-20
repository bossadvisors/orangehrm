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
class displayAttendanceSummaryReportCriteriaAction extends sfAction {

    public function execute($request) {

        $userObj = $this->getContext()->getUser()->getAttribute('user');
        $accessibleMenus = $userObj->getAccessibleReportSubMenus();
        $hasRight = false;

        foreach ($accessibleMenus as $menu) {
            if ($menu->getDisplayName() === "Attendance Summary") {
                $hasRight = true;
                break;
            }
        }

        if (!$hasRight) {
            return $this->renderText("You are not allowed to view this page!");
        }

        $this->reportId = $request->getParameter("reportId");
        
        $employeeList = $userObj->getEmployeeListForAttendanceTotalSummaryReport();

        if (is_array($employeeList)) {
            $lastRecord = end($employeeList);
            $this->lastEmpNumber = $lastRecord->getEmpNumber();
        } else {
            
            $this->lastEmpNumber = $employeeList->getLast()->getEmpNumber();
        }

        $this->form = new AttendanceTotalSummaryReportForm();

        $this->form->emoloyeeList = $employeeList;
    }

}

