<?php

class defineWorkWeekAction extends baseLeaveAction {

    public function preExecute() {
        parent::preExecute();
        if ($this->getUser()->getAttribute('auth.isAdmin') != 'Yes') {
            $this->redirect('leave/viewMyLeaveList');
        }        
    }
    
    public function execute($request) {

        $workWeek = $this->getWorkWeekService()->getWorkWeekOfOperationalCountry(null);
        
        if (empty($workWeek)) {
            $workWeek = new WorkWeek();
        }
                
        $this->workWeekForm = new WorkWeekForm(array('workWeekEntity' => $workWeek));

        if ($request->isMethod(sfRequest::POST)) {
            $workWeekService = $this->getWorkWeekService();
            $this->workWeekForm->bind($request->getParameter($this->workWeekForm->getName()));

            if ($this->workWeekForm->isValid()) {
                try {
                    
                    $workWeek->setMon($this->workWeekForm->getValue('day_length_Monday'));
                    $workWeek->setTue($this->workWeekForm->getValue('day_length_Tuesday'));
                    $workWeek->setWed($this->workWeekForm->getValue('day_length_Wednesday'));
                    $workWeek->setThu($this->workWeekForm->getValue('day_length_Thursday'));
                    $workWeek->setFri($this->workWeekForm->getValue('day_length_Friday'));
                    $workWeek->setSat($this->workWeekForm->getValue('day_length_Saturday'));
                    $workWeek->setSun($this->workWeekForm->getValue('day_length_Sunday'));
                    
                    $this->getWorkWeekService()->saveWorkWeek($workWeek);
                    $this->templateMessage = array('SUCCESS', __('Work Week Successfully Saved'));
                } catch (Exception $e) {
                    $this->templateMessage = array('FAILURE', __('Failed to Save Work Week'));
                }
            }
        }
    }

}
