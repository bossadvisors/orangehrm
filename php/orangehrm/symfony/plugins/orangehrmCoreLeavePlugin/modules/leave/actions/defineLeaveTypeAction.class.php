<?php

class defineLeaveTypeAction extends orangehrmAction {

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
                $leaveType = $this->form->getLeaveTypeObject();
                $this->saveLeaveType($leaveType);

                $this->redirect("leave/leaveTypeList");
            }
        }
        else {
            
            $this->undeleteForm = $this->getUndeleteForm();
            $leaveTypeId = $request->getParameter('id'); // This comes as a GET request from Leave Type List page

            if (!empty($leaveTypeId)) {
                $this->form->setDefaultValues($leaveTypeId);
                $this->form->setUpdateMode();
            }

        }
    }

    protected function saveLeaveType(LeaveType $leaveType) {
        $this->getLeaveTypeService()->saveLeaveType($leaveType);
        $message = __('Leave Type "%1%" Successfully Saved', array('%1%' => $leaveType->getLeaveTypeName()));        
        $this->getUser()->setFlash('templateMessage', array('success', $message));
    }

    protected function getForm() {
        $form = new LeaveTypeForm();
        $form->setLeaveTypeService($this->getLeaveTypeService());
        return $form;
    }
    
    protected function getUndeleteForm() {
        return new UndeleteLeaveTypeForm();
    }

    protected function getLeaveTypeService() {

        if (is_null($this->leaveTypeService)) {
            $this->leaveTypeService = new LeaveTypeService();
        }

        return $this->leaveTypeService;
    }


}
