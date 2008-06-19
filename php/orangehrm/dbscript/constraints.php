<?php
/*
* Contains foreign key constraints defined as php variables in the given format.
* We may later choose to parse the mysql statements and construct an array instead of
* maintaining a separate file like this.
*
*array("child_table", array("child_col1,child_col2"), "parent_table", array("parent_col1","parent_col2"), "on delete clause")
*/
$fkConstraints = array(

array("hs_hr_compstructtree",         array("loc_code"),     "hs_hr_location",      array("loc_code"),     "restrict"),
array("hs_pr_salary_currency_detail", array("currency_id"),  "hs_hr_currency_type", array("currency_id"),  "cascade"),
array("hs_pr_salary_currency_detail", array("sal_grd_code"), "hs_pr_salary_grade",  array("sal_grd_code"), "cascade"),
array("hs_hr_location",               array("loc_country"),  "hs_hr_country",       array("cou_code"),     "cascade"),
array("hs_hr_job_title",              array("sal_grd_code"), "hs_pr_salary_grade",  array("sal_grd_code"), "null"),
array("hs_hr_jobtit_empstat",         array("jobtit_code"),  "hs_hr_job_title",     array("jobtit_code"),  "cascade"),
array("hs_hr_jobtit_empstat",         array("estat_code"),   "hs_hr_empstat",       array("estat_code"),   "cascade"),
array("hs_hr_membership",             array("membtype_code"),"hs_hr_membership_type", array("membtype_code"),  "cascade"),
array("hs_hr_employee",         array("work_station"),       "hs_hr_compstructtree",  array("id"),         "null"),
array("hs_hr_employee",         array("ethnic_race_code"),   "hs_hr_ethnic_race",     array("ethnic_race_code"), "null"),
array("hs_hr_employee",         array("nation_code"),    "hs_hr_nationality", array("nat_code"),     "null"),
array("hs_hr_employee", 		array("job_title_code"), "hs_hr_job_title",   array("jobtit_code"), "null"),
array("hs_hr_employee", 		array("emp_status"),     "hs_hr_empstat",     array("estat_code"),  "null"),
array("hs_hr_employee",         array("eeo_cat_code"),   "hs_hr_eec",         array("eec_code"), "null"),
array("hs_hr_emp_children",     array("emp_number"),     "hs_hr_employee",    array("emp_number"), "cascade"),
array("hs_hr_emp_dependents",   array("emp_number"),     "hs_hr_employee",    array("emp_number"), "cascade"),
array("hs_hr_emp_emergency_contacts",    array("emp_number"), "hs_hr_employee", array("emp_number"), "cascade"),
array("hs_hr_emp_history_of_ealier_pos", array("emp_number"), "hs_hr_employee", array("emp_number"), "cascade"),
array("hs_hr_emp_licenses",    array("emp_number"),    "hs_hr_employee",  array("emp_number"), "cascade"),
array("hs_hr_emp_licenses",    array("licenses_code"), "hs_hr_licenses",  array("licenses_code"), "cascade"),
array("hs_hr_emp_skill",       array("emp_number"),    "hs_hr_employee",  array("emp_number"), "cascade"),
array("hs_hr_emp_skill",       array("skill_code"),    "hs_hr_skill",     array("skill_code"), "cascade"),
array("hs_hr_emp_attachment",  array("emp_number"),    "hs_hr_employee",  array("emp_number"), "cascade"),
array("hs_hr_emp_picture",     array("emp_number"),    "hs_hr_employee",  array("emp_number"), "cascade"),
array("hs_hr_emp_education",   array("emp_number"),    "hs_hr_employee",  array("emp_number"), "cascade"),
array("hs_hr_emp_education",   array("edu_code"),      "hs_hr_education", array("edu_code"), "cascade"),
array("hs_hr_emp_work_experience", array("emp_number"),   "hs_hr_employee",        array("emp_number"), "cascade"),
array("hs_hr_emp_passport",        array("emp_number"),   "hs_hr_employee",        array("emp_number"), "cascade"),
array("hs_hr_emp_member_detail",   array("membtype_code"),"hs_hr_membership_type", array("membtype_code"), "cascade"),
array("hs_hr_emp_member_detail",   array("membship_code"),"hs_hr_membership",      array("membship_code"), "cascade"),
array("hs_hr_emp_member_detail",   array("emp_number"),   "hs_hr_employee",        array("emp_number"), "cascade"),
array("hs_hr_emp_reportto",  array("erep_sup_emp_number"), "hs_hr_employee", array("emp_number"), "cascade"),
array("hs_hr_emp_reportto",        array("erep_sub_emp_number"), "hs_hr_employee", array("emp_number"), "cascade"),
array("hs_hr_emp_basicsalary",     array("sal_grd_code"),        "hs_pr_salary_grade", array("sal_grd_code"), "cascade"),
array("hs_hr_emp_basicsalary", array("currency_id"),    "hs_hr_currency_type", array("currency_id"), "cascade"),
array("hs_hr_emp_basicsalary", array("emp_number"),     "hs_hr_employee",      array("emp_number"), "cascade"),
array("hs_hr_emp_language",    array("emp_number"),     "hs_hr_employee",      array("emp_number"), "cascade"),
array("hs_hr_emp_language",    array("lang_code"),      "hs_hr_language",      array("lang_code"), "cascade"),
array("hs_hr_emp_contract_extend", array("emp_number"), "hs_hr_employee",      array("emp_number"), "cascade"),
array("hs_hr_db_version",      array("entered_by"), "hs_hr_users",      array("id"), "cascade"),
array("hs_hr_db_version",      array("modified_by"), "hs_hr_users",     array("id"), "cascade"),
array("hs_hr_file_version",    array("altered_module"), "hs_hr_module", array("mod_id"), "cascade"),
array("hs_hr_file_version",    array("entered_by"), "hs_hr_users",      array("id"), "cascade"),
array("hs_hr_file_version",    array("modified_by"), "hs_hr_users",     array("id"), "cascade"),
array("hs_hr_module",   array("version"), "hs_hr_versions",             array("id"), "cascade"),
array("hs_hr_rights",   array("mod_id"), "hs_hr_module",          array("mod_id"), "cascade"),
array("hs_hr_rights",   array("userg_id"), "hs_hr_user_group",    array("userg_id"), "cascade"),
array("hs_hr_users",    array("modified_user_id"), "hs_hr_users", array("id"), "null"),
array("hs_hr_users",    array("created_by"), "hs_hr_users",       array("id"), "null"),
array("hs_hr_users",    array("userg_id"), "hs_hr_user_group",    array("userg_id"), "null"),
array("hs_hr_users",    array("emp_number"), "hs_hr_employee",    array("emp_number"), "null"),
array("hs_hr_versions", array("modified_by"), "hs_hr_users",      array("id"), "cascade"),
array("hs_hr_versions", array("created_by"), "hs_hr_users",       array("id"), "cascade"),
array("hs_hr_versions", array("db_version"), "hs_hr_db_version",  array("id"), "cascade"),
array("hs_hr_versions", array("file_version"), "hs_hr_file_version",   array("id"), "cascade"),
array("hs_hr_emprep_usergroup", array("userg_id"), "hs_hr_user_group", array("userg_id"), "cascade"),
array("hs_hr_emprep_usergroup", array("rep_code"), "hs_hr_empreport",  array("rep_code"), "cascade"),
array("hs_hr_employee_leave_quota", array("leave_type_id"), "hs_hr_leavetype", array("leave_type_id"), "cascade"),
array("hs_hr_employee_leave_quota", array("employee_id"), "hs_hr_employee",    array("emp_number"), "cascade"),
array("hs_hr_leave_requests", array("employee_id"), "hs_hr_employee",          array("emp_number"), "cascade"),
array("hs_hr_leave_requests", array("leave_type_id"), "hs_hr_leavetype",       array("leave_type_id"), "cascade"),
array("hs_hr_leave", array("leave_request_id","leave_type_id","employee_id"), "hs_hr_leave_requests", array("leave_request_id","leave_type_id","employee_id"), "cascade"),
array("hs_hr_mailnotifications",         array("user_id"), "hs_hr_users",        array("id"), "cascade"),
array("hs_hr_employee_timesheet_period", array("employee_id"), "hs_hr_employee", array("emp_number"), "cascade"),
array("hs_hr_employee_timesheet_period", array("timesheet_period_id"), "hs_hr_timesheet_submission_period", array("timesheet_period_id"), "cascade"),
array("hs_hr_project",    array("customer_id"), "hs_hr_customer",   array("customer_id"), "restrict"),
array("hs_hr_project_activity",    array("project_id"), "hs_hr_project",   array("project_id"), "cascade"),
array("hs_hr_project_admin",    array("project_id"), "hs_hr_project",   array("project_id"), "cascade"),
array("hs_hr_project_admin",    array("emp_number"), "hs_hr_employee",   array("emp_number"), "cascade"),
array("hs_hr_timesheet",  array("employee_id"), "hs_hr_employee",   array("emp_number"), "cascade"),
array("hs_hr_timesheet",  array("timesheet_period_id"), "hs_hr_timesheet_submission_period", array("timesheet_period_id"), "cascade"),
array("hs_hr_time_event", array("timesheet_id"), "hs_hr_timesheet", array("timesheet_id"), "cascade"),
array("hs_hr_time_event", array("activity_id"), "hs_hr_project_activity",     array("activity_id"), "cascade"),
array("hs_hr_time_event", array("project_id"), "hs_hr_project",     array("project_id"), "cascade"),
array("hs_hr_time_event", array("employee_id"), "hs_hr_employee",   array("emp_number"), "cascade"),
array("hs_hr_employee_workshift", array("workshift_id"), "hs_hr_workshift",   array("workshift_id"), "cascade"),
array("hs_hr_employee_workshift", array("emp_number"), "hs_hr_employee",   array("emp_number"), "cascade"),
array("hs_hr_emp_us_tax", array("emp_number"), "hs_hr_employee",   array("emp_number"), "cascade"),
array("hs_hr_emp_directdebit", array("emp_number"), "hs_hr_employee",   array("emp_number"), "cascade"),
array("hs_hr_emp_basicsalary", array("payperiod_code"), "hs_hr_payperiod",   array("payperiod_code"), "cascade"),
array("hs_hr_employee_workshift", array("emp_number"), "hs_hr_employee",   array("emp_number"), "cascade"),
array("hs_hr_job_vacancy", array("manager_id"), "hs_hr_employee",   array("emp_number"), "null"),
array("hs_hr_job_vacancy", array("jobtit_code"), "hs_hr_job_title",   array("jobtit_code"), "null"),
array("hs_hr_job_application", array("vacancy_id"), "hs_hr_job_vacancy",   array("vacancy_id"), "cascade")
);

?>
