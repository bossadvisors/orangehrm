create database hr_mysql;

use hr_mysql;

create table `hs_hr_geninfo` (			
	`code` varchar(8) not null default '',
	`geninfo_keys` varchar(200) default null,
	`geninfo_values` varchar(200) default null,
	primary key (`code`)
);
		
create table `hs_hr_company_hierarchy` (
  `hie_code` varchar(6) not null default '',
  `hie_name` varchar(70) default null,
  `hie_relationship` varchar(6) default null,
  `emp_number` varchar(6) default null,
  `def_level` int(11) default null,
  `hie_telephone` varchar(30) default null,
  `hie_fax` varchar(20) default null,
  `hie_email` varchar(50) default null,
  `hie_url` varchar(200) default null,
  `hie_lo` varchar(100) default null,
  `loc_code` varchar(6) default null,
  primary key  (`hie_code`)
);


create table `hs_hr_company_hierarchy_def` (
  `def_level` int(11) not null default '0',
  `def_name` varchar(70) not null default '',
  primary key  (`def_level`)
);

create table `hs_hr_job_title` (

	`jobtit_code` varchar(6) not null default '',
	`jobtit_name` varchar(50) default null,
	`jobtit_desc` varchar(200) default null,
	`jobtit_comm` varchar(400) default null,
	`sal_grd_code` varchar(6) default null,
	primary key(`jobtit_code`)
);

create table `hs_hr_empstat` (
		
	`estat_code` varchar(6) not null default '',
	`estat_name` varchar(50) default null,
  primary key  (`estat_code`)
);

create table `hs_hr_eec` (

	`eec_code` varchar(6) not null default '',
	`eec_desc` varchar(50) default null,
  primary key  (`eec_code`)
);

create table `hs_hr_jobtit_empstat` (

	`jobtit_code` varchar(6) not null default '',
	`estat_code` varchar(6) not null default '',
  primary key  (`jobtit_code`,`estat_code`)
);		
		

create table `hs_hr_country` (
  `cou_code` varchar(6) not null default '',
  `cou_name` varchar(50) default null,
  primary key  (`cou_code`)
);

create table `hs_hr_currency_type` (
  `currency_id` varchar(6) not null default '',
  `currency_name` varchar(20) default null,
  primary key  (`currency_id`)
);

create table `hs_hr_licenses` (

	`licenses_code` varchar(6) not null default '',
	`licenses_desc` varchar(50) default null,
  primary key  (`licenses_code`)
);			

create table `hs_hr_db_version` (
  `id` varchar(36) not null default '',
  `name` varchar(45) default null,
  `description` varchar(100) default null,
  `entered_date` datetime default '0000-00-00 00:00:00',
  `modified_date` datetime default '0000-00-00 00:00:00',
  `entered_by` varchar(36) default null,
  `modified_by` varchar(36) default null,
  primary key  (`id`)
);


create table `hs_hr_developer` (
  `id` varchar(36) not null default '',
  `first_name` varchar(45) default null,
  `last_name` varchar(45) default null,
  `reports_to_id` varchar(45) default null,
  `description` varchar(200) default null,
  `department` varchar(45) default null,
  primary key  (`id`)
);


create table `hs_hr_district` (
  `district_code` varchar(6) not null default '',
  `district_name` varchar(50) default null,
  `province_code` varchar(6) default null,
  primary key  (`district_code`)
);


create table `hs_hr_electorate` (
  `electorate_code` varchar(6) not null default '',
  `electorate_name` varchar(50) default null,
  primary key  (`electorate_code`)
);



create table `hs_hr_emp_basicsalary` (
  `emp_number` varchar(6) not null default '',
  `sal_grd_code` varchar(6) not null default '',
  `currency_id` varchar(6) not null default '',
  `ebsal_basic_salary` float default null,
  primary key  (`emp_number`,`sal_grd_code`,`currency_id`)
);


create table `hs_hr_emp_contract_extend` (
  `emp_number` varchar(6) not null default '',
  `econ_extend_id` decimal(10,0) not null default '0',
  `econ_extend_start_date` datetime default null,
  `econ_extend_end_date` datetime default null,
  primary key  (`emp_number`,`econ_extend_id`)
);


create table `hs_hr_emp_language` (
  `emp_number` varchar(6) not null default '',
  `lang_code` varchar(6) not null default '',
  `elang_type` smallint(6) default '0',
  primary key  (`emp_number`,`lang_code`,`elang_type`)
);

create table `hs_hr_emp_attachment` (
  `emp_number` varchar(6) not null default '',
  `eattach_id` decimal(10,0) not null default '0',
  `eattach_desc` varchar(200) default null,
  `eattach_filename` varchar(100) default null,
  `eattach_size` int(11) default '0',
  `eattach_attachment` mediumblob,
  `eattach_type` varchar(50) default null,
  primary key  (`emp_number`,`eattach_id`)
);


create table `hs_hr_emp_children` (
  `emp_number` varchar(6) not null default '',
  `ec_seqno` decimal(2,0) not null default '0',
  `ec_name` varchar(100) default '',
  `ec_date_of_birth` date default '0000-00-00',
  primary key  (`emp_number`,`ec_seqno`)
);

create table `hs_hr_emp_dependents` (
  `emp_number` varchar(6) not null default '',
  `ed_seqno` decimal(2,0) not null default '0',
  `ed_name` varchar(100) default '',
  `ed_relationship` varchar(100) default '',
  primary key  (`emp_number`,`ed_seqno`)
);

create table `hs_hr_emp_emergency_contacts` (
  `emp_number` varchar(6) not null default '',
  `eec_seqno` decimal(2,0) not null default '0',
  `eec_name` varchar(100) default '',
  `eec_relationship` varchar(100) default '',
  `eec_home_no` varchar(100) default '',
  `eec_mobile_no` varchar(100) default '',
  `eec_office_no` varchar(100) default '',
  primary key  (`emp_number`,`eec_seqno`)
);



create table `hs_hr_emp_history_of_ealier_pos` (
  `emp_number` varchar(6) not null default '',
  `emp_seqno` decimal(2,0) not null default '0',
  `ehoep_job_title` varchar(100) default '',
  `ehoep_years` varchar(100) default '',
  primary key  (`emp_number`,`emp_seqno`)
);


create table `hs_hr_emp_licenses` (
  `emp_number` varchar(6) not null default '',
  `licenses_code` varchar(100) not null default '',
  `licenses_date` date not null default '0000-00-00',
  `licenses_renewal_date` date not null default '0000-00-00',
  primary key  (`emp_number`,`licenses_code`)
);

create table `hs_hr_emp_member_detail` (
  `emp_number` varchar(6) not null default '',
  `membship_code` varchar(6) not null default '',
  `membtype_code` varchar(6) not null default '',
  `ememb_subscript_ownership` varchar(20) default null,
  `ememb_subscript_amount` decimal(15,2) default null,
  `ememb_commence_date` datetime default null,
  `ememb_renewal_date` datetime default null,
  primary key  (`emp_number`,`membship_code`,`membtype_code`)
);


create table `hs_hr_emp_passport` (
  `emp_number` varchar(6) not null default '',
  `ep_seqno` decimal(2,0) not null default '0',
  `ep_passport_num` varchar(100) not null default '',
  `ep_passportissueddate` datetime default null,
  `ep_passportexpiredate` datetime default null,
  `ep_comments` varchar(255) default null,
  `ep_passport_type_flg` smallint(6) default null,
  `ep_i9_status` varchar(100) default '',
  `ep_i9_review_date` date default '0000-00-00',
  `cou_code` varchar(6) default null,
  primary key  (`emp_number`,`ep_seqno`)
);


create table `hs_hr_emp_skill` (
  `emp_number` varchar(6) not null default '',
  `skill_code` varchar(6) not null default '',
  `years_of_exp` decimal(2,0) not null default '0',
  `comments` varchar(100) not null default ''
);



create table `hs_hr_emp_picture` (
  `emp_number` varchar(6) not null default '',
  `epic_picture` blob,
  `epic_filename` varchar(100) default null,
  `epic_type` varchar(50) default null,
  `epic_file_size` varchar(20) default null,
  primary key  (`emp_number`)
);



create table `hs_hr_emp_qualification` (
  `qualifi_code` varchar(6) not null default '',
  `emp_number` varchar(6) not null default '',
  `equalifi_institute` varchar(50) default null,
  `equalifi_year` decimal(4,0) default null,
  `equalifi_status` varchar(20) default null,
  `equalifi_comments` varchar(200) default null,
  primary key  (`qualifi_code`,`emp_number`)
);



create table `hs_hr_emp_reportto` (
  `erep_sup_emp_number` varchar(6) not null default '',
  `erep_sub_emp_number` varchar(6) not null default '',
  `erep_reporting_mode` smallint(6) not null default '0',
  primary key  (`erep_sup_emp_number`,`erep_sub_emp_number`,`erep_reporting_mode`)
);


create table `hs_hr_emp_work_experience` (
  `emp_number` varchar(6) not null default '',
  `eexp_seqno` decimal(10,0) not null default '0',
  `eexp_company` varchar(100) default null,
  `eexp_address1` varchar(50) default null,
  `eexp_address2` varchar(50) default null,
  `eexp_address3` varchar(50) default null,
  `eexp_desig_on_leave` varchar(120) default null,
  `eexp_work_related_flg` smallint(6) default null,
  `eexp_from_date` datetime default null,
  `eexp_to_date` datetime default null,
  `eexp_years` decimal(10,0) default null,
  `eexp_months` smallint(6) default null,
  `eexp_reason_for_leave` varchar(100) default null,
  `eexp_contact_person` varchar(50) default null,
  `eexp_telephone` varchar(20) default null,
  `eexp_email` varchar(50) default null,
  `eexp_accountabilities` varchar(200) default null,
  `eexp_achievements` varchar(200) default null,
  primary key  (`emp_number`,`eexp_seqno`)
);


create table `hs_hr_employee` (
  `emp_number` varchar(6) not null default '',
  `emp_lastname` varchar(100) default '',
  `emp_firstname` varchar(100) default '',
  `emp_middle_name` varchar(100) default '',
  `emp_nick_name` varchar(100) default '',
  `emp_smoker` smallint(6) default '0',
  `emp_eth_race` varchar(100) default '',
  `emp_birthday` datetime default null,
  `nation_code` varchar(100) default '',
  `emp_gender` smallint(6) default null,
  `emp_marital_status` varchar(20) default null,
  `emp_ssn_num` varchar(100) default '',
  `emp_sin_num` varchar(100) default '',
  `emp_other_id` varchar(100) default '',
  `emp_dri_lice_num` varchar(100) default '',
  `emp_dri_lice_exp_date` date default '0000-00-00',
  `emp_military_service` varchar(100) default '',
  `emp_status` varchar(100) default '',
  `job_title_code` varchar(100) default '',
  `eeo_cat_code` varchar(100) default '',
  `loc_code` varchar(100) default '',
  `emp_street1` varchar(100) default '',
  `emp_street2` varchar(100) default '',
  `city_code` varchar(100) default '',
  `coun_code` varchar(100) default '',
  `provin_code` varchar(100) default '',
  `emp_zipcode` varchar(20) default null,
  `emp_hm_telephone` varchar(50) default null,
  `emp_mobile` varchar(6) default null,
  `emp_work_telephone` varchar(6) default null,
  `emp_work_email` varchar(6) default null,
  `sal_grd_code` varchar(100) default '',
  `joined_date` date default '0000-00-00',
  `emp_oth_email` varchar(50) default null,
  primary key  (`emp_number`)
);


create table `hs_hr_file_version` (
  `id` varchar(36) not null default '',
  `altered_module` varchar(36) default null,
  `description` varchar(200) default null,
  `entered_date` datetime not null default '0000-00-00 00:00:00',
  `modified_date` datetime default '0000-00-00 00:00:00',
  `entered_by` varchar(36) default null,
  `modified_by` varchar(36) default null,
  `name` varchar(50) default null,
  primary key  (`id`)
);


create table `hs_hr_language` (
  `lang_code` varchar(6) not null default '',
  `lang_name` varchar(120) default null,
  primary key  (`lang_code`)
);


create table `hs_hr_location` (
  `loc_code` varchar(6) not null default '',
  `loc_name` varchar(100) default null,
  `loc_country` varchar(6) default null,
  `loc_state` varchar(6) default null,
  `loc_city` varchar(6) default null,
  `loc_add` varchar(100) default null,
  `loc_zip` varchar(10) default null,
  `loc_phone` varchar(30) default null,
  `loc_fax` varchar(30) default null,
  `loc_comments` varchar(100) default null,
  primary key  (`loc_code`)
);

create table `hs_hr_membership` (
  `membship_code` varchar(6) not null default '',
  `membtype_code` varchar(6) default null,
  `membship_name` varchar(120) default null,
  primary key  (`membship_code`)
);


create table `hs_hr_membership_type` (
  `membtype_code` varchar(6) not null default '',
  `membtype_name` varchar(120) default null,
  primary key  (`membtype_code`)
);


create table `hs_hr_module` (
  `mod_id` varchar(36) not null default '',
  `name` varchar(45) default null,
  `owner` varchar(45) default null,
  `owner_email` varchar(100) default null,
  `version` varchar(36) default null,
  `description` text,
  primary key  (`mod_id`)
);


create table `hs_hr_nationality` (
  `nat_code` varchar(6) not null default '',
  `nat_name` varchar(120) default null,
  primary key  (`nat_code`)
);


create table `hs_hr_province` (
  `province_code` varchar(6) not null default '',
  `province_name` varchar(50) default null,
  `cou_code` varchar(6) default null,
  primary key  (`province_code`)
);


create table `hs_hr_education` (
	`edu_code` varchar(6) not null default '',
	`edu_uni` varchar(30) default null,
	`edu_deg` varchar(30) default null,
	primary key (`edu_code`)
);

		
create table `hs_hr_ethnic_race` (
  `ethnic_race_code` varchar(6) not null default '',
  `ethnic_race_desc` varchar(50) default null,
  primary key  (`ethnic_race_code`)
);

create table `hs_hr_rights` (
  `userg_id` varchar(36) not null default '',
  `mod_id` varchar(36) not null default '',
  `addition` smallint(5) unsigned default '0',
  `editing` smallint(5) unsigned default '0',
  `deletion` smallint(5) unsigned default '0',
  `viewing` smallint(5) unsigned default '0',
  primary key  (`mod_id`,`userg_id`)
);


create table `hs_hr_skill` (
  `skill_code` varchar(6) not null default '',
  `skill_name` varchar(120) default null,
  primary key  (`skill_code`)
);


create table `hs_hr_user_group` (
  `userg_id` varchar(36) not null default '',
  `userg_name` varchar(45) default null,
  `userg_repdef` smallint(5) unsigned default '0',
  primary key  (`userg_id`)
) ;


create table `hs_hr_users` (
  `id` varchar(36) not null default '',
  `user_name` varchar(20) default '',
  `user_password` varchar(30) default null,
  `first_name` varchar(45) default null,
  `last_name` varchar(45) default null,
  `emp_number` varchar(36) default null,
  `user_hash` varchar(32) default null,
  `is_admin` char(3) default null,
  `receive_notification` char(1) default null,
  `description` text,
  `date_entered` datetime default '0000-00-00 00:00:00',
  `date_modified` datetime default '0000-00-00 00:00:00',
  `modified_user_id` varchar(36) default null,
  `created_by` varchar(36) default null,
  `title` varchar(50) default null,
  `department` varchar(50) default null,
  `phone_home` varchar(45) default null,
  `phone_mobile` varchar(45) default null,
  `phone_work` varchar(45) default null,
  `phone_other` varchar(45) default null,
  `phone_fax` varchar(45) default null,
  `email1` varchar(100) default null,
  `email2` varchar(100) default null,
  `status` varchar(25) default null,
  `address_street` varchar(150) default null,
  `address_city` varchar(150) default null,
  `address_state` varchar(100) default null,
  `address_country` varchar(25) default null,
  `address_postalcode` varchar(10) default null,
  `user_preferences` text,
  `deleted` tinyint(1) not null default '0',
  `employee_status` varchar(25) default null,
  `userg_id` varchar(36) default null,
  primary key  (`id`),
  unique key `user_name` type btree (`user_name`)
) ;

create table `hs_hr_versions` (
  `id` varchar(36) not null default '',
  `name` varchar(45) default null,
  `entered_date` datetime default '0000-00-00 00:00:00',
  `modified_date` datetime default '0000-00-00 00:00:00',
  `modified_by` varchar(36) default null,
  `created_by` varchar(36) default null,
  `deleted` tinyint(4) not null default '0',
  `db_version` varchar(36) default null,
  `file_version` varchar(36) default null,
  `description` text,
  primary key  (`id`)
) ;


create table `hs_pr_salary_currency_detail` (
  `sal_grd_code` varchar(6) not null default '',
  `currency_id` varchar(6) not null default '',
  `salcurr_dtl_minsalary` float default null,
  `salcurr_dtl_stepsalary` float default null,
  `salcurr_dtl_maxsalary` float default null,
  primary key  (`sal_grd_code`,`currency_id`)
);

create table `hs_pr_salary_grade` (
  `sal_grd_code` varchar(6) not null default '',
  `sal_grd_name` varchar(60) default null,
  primary key  (`sal_grd_code`)
);


create table `hs_hr_empreport` (
  `rep_code` varchar(6) not null default '',
  `rep_name` varchar(60) default null,
  `rep_cridef_str` varchar(100) default null,
  `rep_flddef_str` varchar(100) default null,
  primary key  (`rep_code`)
);

create table `hs_hr_emprep_usergroup` (
  `userg_id` varchar(6) not null default '',
  `rep_code` varchar(6) not null default '',
  primary key  (`userg_id`,`rep_code`)
);


alter table hs_hr_company_hierarchy
       add constraint foreign key (def_level)
                             references hs_hr_company_hierarchy_def(def_level) on delete cascade;


alter table hs_hr_company_hierarchy
       add constraint foreign key (hie_relationship)
                             references hs_hr_company_hierarchy(hie_code) on delete cascade;

alter table hs_pr_salary_currency_detail
       add constraint foreign key (currency_id)
                             references hs_hr_currency_type(currency_id) on delete cascade;

alter table hs_pr_salary_currency_detail
       add constraint foreign key (sal_grd_code)
                             references hs_pr_salary_grade(sal_grd_code) on delete cascade;

alter table hs_hr_location
       add constraint foreign key (loc_city)
                             references hs_hr_district(district_code) on delete cascade;



alter table hs_hr_location
       add constraint foreign key (loc_state)
                             references hs_hr_province(province_code) on delete cascade;



alter table hs_hr_location
       add constraint foreign key (loc_country)
                             references hs_hr_country(cou_code) on delete cascade;



alter table hs_hr_job_title
       add constraint foreign key (sal_grd_code)
                             references hs_pr_salary_grade(sal_grd_code) on delete cascade;

alter table hs_hr_jobtit_empstat
       add constraint foreign key (jobtit_code)
                             references hs_hr_job_title(jobtit_code) on delete cascade;

alter table hs_hr_jobtit_empstat
       add constraint foreign key (estat_code)
                             references hs_hr_empstat(estat_code) on delete cascade;

alter table hs_hr_membership
       add constraint foreign key (membtype_code)
                             references hs_hr_membership_type(membtype_code) on delete cascade;

alter table hs_hr_province
       add constraint foreign key (cou_code)
                             references hs_hr_country(cou_code) on delete cascade;
alter table hs_hr_district
       add constraint foreign key (province_code)
                             references hs_hr_province(province_code) on delete cascade;



alter table hs_hr_employee 
       add constraint foreign key (sal_grd_code)
                             references hs_pr_salary_grade(sal_grd_code) on delete cascade;


alter table hs_hr_employee
       add constraint foreign key (loc_code)
                             references hs_hr_location(loc_code) on delete cascade;


alter table hs_hr_employee
       add constraint foreign key (nation_code)
                             references hs_hr_nationality(nat_code) on delete cascade;

alter table hs_hr_emp_picture
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_work_experience
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;
alter table hs_hr_emp_member_detail
       add constraint foreign key (membtype_code)
                             references hs_hr_membership_type(membtype_code) on delete cascade;

alter table hs_hr_emp_member_detail
       add constraint foreign key (membship_code)
                             references hs_hr_membership(membship_code) on delete cascade;

alter table hs_hr_emp_member_detail
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_reportto
       add constraint foreign key (erep_sup_emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_reportto
       add constraint foreign key (erep_sub_emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;
alter table hs_hr_emp_basicsalary
       add constraint foreign key (sal_grd_code)
                             references hs_pr_salary_grade(sal_grd_code) on delete cascade;

alter table hs_hr_emp_basicsalary
       add constraint foreign key (currency_id)
                             references hs_hr_currency_type(currency_id) on delete cascade;

alter table hs_hr_emp_basicsalary
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_language
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;


alter table hs_hr_emp_language
       add constraint foreign key (lang_code)
                             references hs_hr_language(lang_code) on delete cascade;

alter table hs_hr_emp_contract_extend
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;


alter table hs_hr_db_version
       add constraint foreign key (`entered_by`) 
       						references `hs_hr_users` (`id`) on delete cascade;

alter table hs_hr_db_version
       add constraint foreign key (`modified_by`) 
       						references `hs_hr_users` (`id`) on delete cascade;

alter table hs_hr_file_version
       add constraint foreign key (`altered_module`)
							references `hs_hr_module` (`mod_id`) on delete cascade;
       
alter table hs_hr_file_version
       add constraint foreign key (`entered_by`) 
       						references `hs_hr_users` (`id`) on delete cascade;
       						
alter table hs_hr_file_version
       add constraint foreign key (`modified_by`) 
       						references `hs_hr_users` (`id`) on delete cascade;

alter table hs_hr_module
       add constraint foreign key (`version`) 
       						references `hs_hr_versions` (`id`) on delete cascade;

alter table hs_hr_rights
       add constraint foreign key (`mod_id`) 
       						references `hs_hr_module` (`mod_id`) on delete cascade;
       						
alter table hs_hr_rights
       add constraint foreign key (`userg_id`) 
       						references `hs_hr_user_group` (`userg_id`) on delete cascade;

alter table hs_hr_users
       add constraint foreign key (`modified_user_id`)
       						references `hs_hr_users` (`id`) on delete cascade;
       						
alter table hs_hr_users
       add constraint foreign key (`created_by`)
       						references `hs_hr_users` (`id`) on delete cascade;
       
alter table hs_hr_users
       add constraint foreign key (`userg_id`) 
       						references `hs_hr_user_group` (`userg_id`) on delete cascade;
       						
alter table hs_hr_users
       add constraint foreign key (`emp_number`) 
       						references `hs_hr_employee` (`emp_number`) on delete cascade;
       						
alter table hs_hr_versions
       add constraint foreign key (`modified_by`) 
       						references `hs_hr_users` (`id`) on delete cascade;
       						
alter table hs_hr_versions
       add constraint foreign key (`created_by`) 
       						references `hs_hr_users` (`id`) on delete cascade;
       						
alter table hs_hr_versions
       add constraint foreign key (`db_version`) 
       						references `hs_hr_db_version` (`id`) on delete cascade;
       						
alter table hs_hr_versions
       add constraint foreign key (`file_version`) 
       						references `hs_hr_file_version` (`id`) on delete cascade;

alter table hs_hr_emprep_usergroup
       add constraint foreign key (`userg_id`) 
       						references `hs_hr_user_group` (`userg_id`) on delete cascade;

alter table hs_hr_emprep_usergroup
       add constraint foreign key (`rep_code`) 
       						references `hs_hr_empreport` (`rep_code`) on delete cascade;
       						
INSERT INTO `hs_hr_geninfo` VALUES ('001','','');
INSERT INTO `hs_hr_user_group` VALUES ('USG001','Admin','1'),('USG002','Operator','0');
INSERT INTO `hs_hr_users` VALUES ('USR001','demo','demo','Demo','',null,'','Yes','1','','0000-00-00 00:00:00','0000-00-00 00:00:00',null,'USR001','','','','','','','','','','Enabled','','','','','','',0,'','USG001');
INSERT INTO `hs_hr_db_version` VALUES ('DVR001','mysql4.1','initial DB','2005-10-10 00:00:00','2005-12-20 00:00:00','USR001',null);
INSERT INTO `hs_hr_file_version` VALUES ('FVR001',NULL,'Release 1','2006-03-15 00:00:00','2006-03-15 00:00:00','USR001',null,'file_ver_01');
INSERT INTO `hs_hr_versions` VALUES ('VER001','Release 1','2006-03-15 00:00:00','2006-03-15 00:00:00','USR001',null,0,'DVR001','FVR001','version 1.0');
INSERT INTO `hs_hr_module` VALUES ('MOD001','Admin','Koshika','koshika@beyondm.net','VER001','HR Admin'),('MOD002','PIM','Koshika','koshika@beyondm.net','VER001','HR Functions'),('MOD003','Maintenance','Koshika','koshika@beyondm.net','VER001','Application Maintenance'),('MOD004','Report','Koshika','koshika@beyondm.net','VER001','Reporting');
INSERT INTO `hs_hr_rights` VALUES ('USG001','MOD001',1,1,1,1),('USG001','MOD002',1,1,1,1),('USG001','MOD003',1,1,1,1),('USG001','MOD004',1,1,1,1);
