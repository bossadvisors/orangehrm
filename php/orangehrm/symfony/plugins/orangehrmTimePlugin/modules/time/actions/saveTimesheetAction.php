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
class saveTimesheetAction extends sfAction {

    private $timesheetForm;

    public function execute(sfWebRequest $request) {

        if ($request->isMethod('post')) {
            
            $this->getTimesheetForm()->bind($request->getParameterHolder()->getAll());

            if ($request->getParameter('btnSave')) {
                if ($this->numberOfRows == null) {
                    $this->getTimesheetService()->saveTimesheetItems($request->getParameter('initialRows'), 1, 1, $this->currentWeekDates, $this->totalRows);
                    $this->messageData = array('SUCCESS', __(TopLevelMessages::ADD_SUCCESS));
                    $this->redirect('time/editTimesheet');
                } else {
                    $this->getTimesheetService()->saveTimesheetItems($request->getParameter('initialRows'), $this->employeeId, $this->timesheetId, $this->currentWeekDates, $this->totalRows);
                    $this->messageData = array('SUCCESS', __(TopLevelMessages::SAVE_SUCCESS));
                    $this->redirect('time/editTimesheet');
                }
            }
            if ($request->getParameter('btnRemoveRows')) {
                if ($this->numberOfRows == null) {
                    $this->messageData = array('WARNING', __("Can not delete an empty row"));
                    $this->redirect('time/editTimesheet');
                } else {
                    $this->getTimesheetService()->deleteTimesheetItems($request->getParameter('initialRows'), $this->employeeId, $this->timesheetId);
                    $this->messageData = array('SUCCESS', __(TopLevelMessages::DELETE_SUCCESS));
                    $this->redirect('time/editTimesheet');
                }
            }
        }
    }

    public function getTimesheetForm() {

        if (is_null($this->timesheetForm)) {
            $this->timesheetForm = new TimesheetForm();
        }

        return $this->timesheetForm;
    }

}

