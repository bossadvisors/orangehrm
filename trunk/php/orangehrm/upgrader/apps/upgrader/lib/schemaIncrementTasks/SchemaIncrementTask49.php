<?php
include_once 'SchemaIncrementTask.php';

class SchemaIncrementTask49 extends SchemaIncrementTask {
    
    public $userInputs;
    
    public function execute() {
        $this->incrementNumber = 49;
        parent::execute();
        
        $result[] = $this->upgradeUtility->executeSql($this->sql[0]);
        
        $result[] = $this->upgradeUtility->executeSql($this->sql[1]);
        
        $result[] = $this->upgradeUtility->executeSql($this->sql[2]);
        
        $result[] = $this->upgradeUtility->executeSql($this->sql[3]);
        
        $result[] = $this->upgradeUtility->executeSql($this->sql[4]);
        
        $this->checkTransactionComplete($result);
        $this->updateOhrmUpgradeInfo($this->transactionComplete, $this->incrementNumber);
        $this->upgradeUtility->finalizeTransaction($this->transactionComplete);
        $this->upgradeUtility->closeDbConnection();
    }
    
    public function getUserInputWidgets() {
        
    }
    
    public function setUserInputs() {
        
    }
    
    public function loadSql() {
    
        $sql[0] = "ALTER TABLE hs_hr_emp_attachment 
                    CHANGE eattach_id eattach_id int default null";
        
        $sql[1] = "ALTER TABLE `ohrm_emp_education` 
                    DROP FOREIGN KEY `ohrm_emp_education_ibfk_1`,
                    DROP FOREIGN KEY `ohrm_emp_education_ibfk_2`;";
        
        $sql[2] = "ALTER TABLE ohrm_emp_education
                    ADD column id int not null AUTO_INCREMENT,
                    DROP PRIMARY KEY,
                    ADD primary key (id)";
        
        $sql[3] = "alter table ohrm_emp_education
                    add constraint foreign key (emp_number) references hs_hr_employee(emp_number) on delete cascade,
                    add constraint foreign key (education_id) references ohrm_education(id) on delete cascade;";
        
        $sql[4] = "INSERT INTO `ohrm_filter_field` (`filter_field_id`, `report_group_id`, `name`, `where_clause_part`, `filter_field_widget`, `condition_no`, `required`) VALUES 
                    (22, 3, 'include', 'hs_hr_employee.termination_id', 'ohrmReportWidgetIncludedEmployeesDropDown', 1, 'true');";
        
        $this->sql = $sql;
    }
    
    public function getNotes() {
        
        return $notes;
    }
    
}