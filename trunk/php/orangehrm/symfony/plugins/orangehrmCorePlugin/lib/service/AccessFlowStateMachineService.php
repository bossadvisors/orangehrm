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

class AccessFlowStateMachineService {

    private $accessFlowStateMachineDao;

    public function getAccessFlowStateMachineDao() {


        if (is_null($this->accessFlowStateMachineDao)) {
            $this->accessFlowStateMachineDao = new AccessFlowStateMachineDao();
        }

        return $this->accessFlowStateMachineDao;
    }

    public function setAccessFlowStateMachineDao(AccessFlowStateMachineDao $acessFlowStateDao) {

        $this->accessFlowStateMachineDao = $acessFlowStateDao;
    }


    public function getAllowedActions($workflow, $state, $role) {

        $results = $this->getAccessFlowStateMachineDao()->getAllowedActions($workflow, $state, $role);

        if (is_null($results)) {

            return null;
        } else {

            foreach ($results as $allowedAction) {

                $allowedActionArray[] = $allowedAction->getAction();
            }

            return $allowedActionArray;
        }
    }

    public function getNextState($flow, $state, $role, $action) {

        $result = $this->getAccessFlowStateMachineDao()->getNextState($flow, $state, $role, $action);
        if (is_null($result)) {

            return null;
        } else {

            return $result->getResultingState();
        }
    }

    public function getActionableStates($flow, $role, $actions) {


        $records = $this->getAccessFlowStateMachineDao()->getActionableStates($flow, $role, $actions);

        if($records==null){
            
            return null;
        }
        
        foreach ($records as $record) {

            $tempArray[] = $record->getState();
        }

        return $tempArray;
    }

    public function saveWorkflowStateMachineRecord(WorkflowStateMachine $workflowStateMachineRecord) {

        return $this->getAccessFlowStateMachineDao()->saveWorkflowStateMachineRecord($workflowStateMachineRecord);
    }


    public function deleteWorkflowStateMachineRecord($flow, $state, $role, $action, $resultingState){

       return  $this->getAccessFlowStateMachineDao()->deleteWorkflowStateMachinerecord($flow, $state, $role, $action, $resultingState);
    }
}

?>
