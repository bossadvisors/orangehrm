<?php

class getDatabaseInfoAction extends sfAction {
    
    public function preExecute() {
        $this->getUser()->setAttribute('currentScreen', 0);
    }
    
    public function execute($request) {
        $this->form = new DatabaseInfo();
        
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('databaseInfo'));
            if ($this->form->isValid()) {
                $dbInfo;
                $dbInfo['host'] = $this->form->getValue('host');
                $dbInfo['port'] = $this->form->getValue('port');
                $dbInfo['username'] = $this->form->getValue('username');
                $dbInfo['password'] = $this->form->getValue('password');
                $dbInfo['database'] = $this->form->getValue('database_name');
                
                $this->getUser()->setAttribute('dbInfo', $dbInfo);
                
                $upgraderUtility = new UpgradeUtility();
                $result = $upgraderUtility->checkDatabaseConnection($dbInfo['host'], $dbInfo['username'], $dbInfo['password'], $dbInfo['database'], $dbInfo['port']);
                if(!$result) {
                    $this->getUser()->setFlash('errorMessage', __('Failed to Connect: Check Database Details'));
                } else {
                    $result = $upgraderUtility->checkDatabaseStatus();
                    if (!$result) {
                        $this->getUser()->setFlash('errorMessage', __('Failed to Proceed: Interrupted Database'));
                    } else {
                        $this->getRequest()->setParameter('submitBy', 'databaseInfo');
                        $this->forward('upgrade','index');
                    }
                }
            } 
        }
    }
}