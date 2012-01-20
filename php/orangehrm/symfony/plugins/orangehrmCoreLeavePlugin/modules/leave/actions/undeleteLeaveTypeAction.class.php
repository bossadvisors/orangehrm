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

class undeleteLeaveTypeAction extends orangehrmAction {

    protected $leaveTypeService;

    public function preExecute() {
        if ($this->getUser()->getAttribute('auth.isAdmin') != 'Yes') {
            $this->redirect('leave/viewMyLeaveList');
        }
    }
    
    public function execute($request) {
        
        $this->form = $this->getForm();

        if ($request->isMethod('post')) {

            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $undeleteId = $this->form->getValue('undeleteId');
                $this->undeleteLeaveType($undeleteId);
            }
        }
        $this->redirect("leave/leaveTypeList");        
    }



    protected function undeleteLeaveType($leaveTypeId) {
        $leaveTypeService = $this->getLeaveTypeService();
        $leaveTypeService->undeleteLeaveType($leaveTypeId);

        $leaveType = $leaveTypeService->readLeaveType($leaveTypeId);
        $leaveTypeName = $leaveType->getLeaveTypeName();
        
        $message = __('Leave Type "%1%" Successfully Undeleted', array('%1%' => $leaveTypeName));
        $this->getUser()->setFlash('templateMessage', array('success', $message));
    }


    protected function getForm() {
        $form = new UndeleteLeaveTypeForm();
        return $form;
    }

    protected function getLeaveTypeService() {

        if (is_null($this->leaveTypeService)) {
            $this->leaveTypeService = new LeaveTypeService();
        }

        return $this->leaveTypeService;
    }

}
