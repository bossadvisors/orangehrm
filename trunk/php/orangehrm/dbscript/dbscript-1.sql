create table `hs_hr_geninfo` (			
	`code` varchar(8) not null default '',
	`geninfo_keys` varchar(200) default null,
	`geninfo_values` varchar(200) default null,
	primary key (`code`)
) engine=innodb default charset=utf8;
		
create table hs_hr_compstructtree (
  title tinytext not null,
  description text not null,
  loc_code varchar(6) default NULL,
  lft tinyint(4) not null default '0',
  rgt tinyint(4) not null default '0',
  id int(6) not null auto_increment,
  parnt int(6) not null default '0',
  primary key  (id),
  key loc_code (loc_code)
) engine=innodb default charset=utf8;

create table `hs_hr_job_title` (
	`jobtit_code` varchar(6) not null default '',
	`jobtit_name` varchar(50) default null,
	`jobtit_desc` varchar(200) default null,
	`jobtit_comm` varchar(400) default null,
	`sal_grd_code` varchar(6) default null,
	primary key(`jobtit_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_empstat` (		
	`estat_code` varchar(6) not null default '',
	`estat_name` varchar(50) default null,
  primary key  (`estat_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_eec` (
	`eec_code` varchar(6) not null default '',
	`eec_desc` varchar(50) default null,
  primary key  (`eec_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_jobtit_empstat` (
	`jobtit_code` varchar(6) not null default '',
	`estat_code` varchar(6) not null default '',
  primary key  (`jobtit_code`,`estat_code`)
) engine=innodb default charset=utf8;		

create table `hs_hr_country` (
  `cou_code` char(2) not null default '',
  `name` varchar(80) not null default '',
  `cou_name` varchar(80) not null default '',
  `iso3` char(3) default null,
  `numcode` smallint(6) default null,
  primary key  (`cou_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_currency_type` (
  `code` int(11) not null default '0',
  `currency_id` char(3) not null default '',
  `currency_name` varchar(70) not null default '',
  primary key  (`currency_id`)
) engine=innodb default charset=utf8;

create table `hs_hr_licenses` (
	`licenses_code` varchar(6) not null default '',
	`licenses_desc` varchar(50) default null,
  primary key  (`licenses_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_db_version` (
  `id` varchar(36) not null default '',
  `name` varchar(45) default null,
  `description` varchar(100) default null,
  `entered_date` datetime default '0000-00-00 00:00:00',
  `modified_date` datetime default '0000-00-00 00:00:00',
  `entered_by` varchar(36) default null,
  `modified_by` varchar(36) default null,
  primary key  (`id`)
) engine=innodb default charset=utf8;


create table `hs_hr_developer` (
  `id` varchar(36) not null default '',
  `first_name` varchar(45) default null,
  `last_name` varchar(45) default null,
  `reports_to_id` varchar(45) default null,
  `description` varchar(200) default null,
  `department` varchar(45) default null,
  primary key  (`id`)
) engine=innodb default charset=utf8;


create table `hs_hr_district` (
  `district_code` varchar(6) not null default '',
  `district_name` varchar(50) default null,
  `province_code` varchar(6) default null,
  primary key  (`district_code`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_basicsalary` (
  `emp_number` int(7) not null default 0,
  `sal_grd_code` varchar(6) not null default '',
  `currency_id` varchar(6) not null default '',
  `ebsal_basic_salary` float default null,
  primary key  (`emp_number`,`sal_grd_code`,`currency_id`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_contract_extend` (
  `emp_number` int(7) not null default 0,
  `econ_extend_id` decimal(10,0) not null default '0',
  `econ_extend_start_date` datetime default null,
  `econ_extend_end_date` datetime default null,
  primary key  (`emp_number`,`econ_extend_id`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_language` (
  `emp_number` int(7) not null default 0,
  `lang_code` varchar(6) not null default '',
  `elang_type` smallint(6) default '0',
  `competency` smallint default '0',
  primary key  (`emp_number`,`lang_code`,`elang_type`)
) engine=innodb default charset=utf8;

create table `hs_hr_emp_attachment` (
  `emp_number` int(7) not null default 0,
  `eattach_id` decimal(10,0) not null default '0',
  `eattach_desc` varchar(200) default null,
  `eattach_filename` varchar(100) default null,
  `eattach_size` int(11) default '0',
  `eattach_attachment` mediumblob,
  `eattach_type` varchar(50) default null,
  primary key  (`emp_number`,`eattach_id`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_children` (
  `emp_number` int(7) not null default 0,
  `ec_seqno` decimal(2,0) not null default '0',
  `ec_name` varchar(100) default '',
  `ec_date_of_birth` date default '0000-00-00',
  primary key  (`emp_number`,`ec_seqno`)
) engine=innodb default charset=utf8;

create table `hs_hr_emp_dependents` (
  `emp_number` int(7) not null default 0,
  `ed_seqno` decimal(2,0) not null default '0',
  `ed_name` varchar(100) default '',
  `ed_relationship` varchar(100) default '',
  primary key  (`emp_number`,`ed_seqno`)
) engine=innodb default charset=utf8;

create table `hs_hr_emp_emergency_contacts` (
  `emp_number` int(7) not null default 0,
  `eec_seqno` decimal(2,0) not null default '0',
  `eec_name` varchar(100) default '',
  `eec_relationship` varchar(100) default '',
  `eec_home_no` varchar(100) default '',
  `eec_mobile_no` varchar(100) default '',
  `eec_office_no` varchar(100) default '',
  primary key  (`emp_number`,`eec_seqno`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_history_of_ealier_pos` (
  `emp_number` int(7) not null default 0,
  `emp_seqno` decimal(2,0) not null default '0',
  `ehoep_job_title` varchar(100) default '',
  `ehoep_years` varchar(100) default '',
  primary key  (`emp_number`,`emp_seqno`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_licenses` (
  `emp_number` int(7) not null default 0,
  `licenses_code` varchar(100) not null default '',
  `licenses_date` date not null default '0000-00-00',
  `licenses_renewal_date` date not null default '0000-00-00',
  primary key  (`emp_number`,`licenses_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_emp_member_detail` (
  `emp_number` int(7) not null default 0,
  `membship_code` varchar(6) not null default '',
  `membtype_code` varchar(6) not null default '',
  `ememb_subscript_ownership` varchar(20) default null,
  `ememb_subscript_amount` decimal(15,2) default null,
  `ememb_commence_date` datetime default null,
  `ememb_renewal_date` datetime default null,
  primary key  (`emp_number`,`membship_code`,`membtype_code`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_passport` (
  `emp_number` int(7) not null default 0,
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
) engine=innodb default charset=utf8;


create table `hs_hr_emp_skill` (
  `emp_number` int(7) not null default 0,
  `skill_code` varchar(6) not null default '',
  `years_of_exp` decimal(2,0) not null default '0',
  `comments` varchar(100) not null default ''
) engine=innodb default charset=utf8;

create table `hs_hr_emp_picture` (
  `emp_number` int(7) not null default 0,
  `epic_picture` blob,
  `epic_filename` varchar(100) default null,
  `epic_type` varchar(50) default null,
  `epic_file_size` varchar(20) default null,
  primary key  (`emp_number`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_education` (
  `emp_number` int(7) not null default 0,
  `edu_code` varchar(6) not null default '',
  `edu_major` varchar(100) default null,
  `edu_year` decimal(4,0) default null,
  `edu_gpa` varchar(25) default null,
  `edu_start_date` datetime default null,
  `edu_end_date` datetime default null,
  primary key  (`edu_code`,`emp_number`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_reportto` (
  `erep_sup_emp_number` int(7) not null default 0,
  `erep_sub_emp_number` int(7) not null default 0,
  `erep_reporting_mode` smallint(6) not null default '0',
  primary key  (`erep_sup_emp_number`,`erep_sub_emp_number`,`erep_reporting_mode`)
) engine=innodb default charset=utf8;


create table `hs_hr_emp_work_experience` (
  `emp_number` int(7) not null default 0,
  `eexp_seqno` decimal(10,0) not null default '0',
  `eexp_employer` varchar(100) default null,
  `eexp_jobtit` varchar(120) default null,
  `eexp_from_date` datetime default null,
  `eexp_to_date` datetime default null,
  `eexp_comments` varchar(200) default null,
  `eexp_internal` int(1) default null,
  primary key  (`emp_number`,`eexp_seqno`)
) engine=innodb default charset=utf8;


create table `hs_hr_employee` (
  `emp_number` int(7) not null default 0,
  `emp_lastname` varchar(100) default '',
  `emp_firstname` varchar(100) default '',
  `emp_middle_name` varchar(100) default '',
  `emp_nick_name` varchar(100) default '',
  `emp_smoker` smallint(6) default '0',
  `ethnic_race_code` varchar(6) default null,
  `emp_birthday` datetime default '0000-00-00',
  `nation_code` varchar(6) default null,
  `emp_gender` smallint(6) default null,
  `emp_marital_status` varchar(20) default null,
  `emp_ssn_num` varchar(100) default '',
  `emp_sin_num` varchar(100) default '',
  `emp_other_id` varchar(100) default '',
  `emp_dri_lice_num` varchar(100) default '',
  `emp_dri_lice_exp_date` date default '0000-00-00',
  `emp_military_service` varchar(100) default '',
  `emp_status` varchar(6) default null,
  `job_title_code` varchar(6) default null,
  `eeo_cat_code` varchar(6) default null,
  `work_station` int(6) default null,
  `emp_street1` varchar(100) default '',
  `emp_street2` varchar(100) default '',
  `city_code` varchar(100) default '',
  `coun_code` varchar(100) default '',
  `provin_code` varchar(100) default '',
  `emp_zipcode` varchar(20) default null,
  `emp_hm_telephone` varchar(50) default null,
  `emp_mobile` varchar(50) default null,
  `emp_work_telephone` varchar(50) default null,
  `emp_work_email` varchar(50) default null,
  `sal_grd_code` varchar(6) default null,
  `joined_date` date default '0000-00-00',
  `emp_oth_email` varchar(50) default null,
  primary key  (`emp_number`)
) engine=innodb default charset=utf8;


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
) engine=innodb default charset=utf8;


create table `hs_hr_language` (
  `lang_code` varchar(6) not null default '',
  `lang_name` varchar(120) default null,
  primary key  (`lang_code`)
) engine=innodb default charset=utf8;


create table `hs_hr_location` (
  `loc_code` varchar(6) not null default '',
  `loc_name` varchar(100) default null,
  `loc_country` varchar(3) default null,
  `loc_state` varchar(50) default null,
  `loc_city` varchar(50) default null,
  `loc_add` varchar(100) default null,
  `loc_zip` varchar(10) default null,
  `loc_phone` varchar(30) default null,
  `loc_fax` varchar(30) default null,
  `loc_comments` varchar(100) default null,
  primary key  (`loc_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_membership` (
  `membship_code` varchar(6) not null default '',
  `membtype_code` varchar(6) default null,
  `membship_name` varchar(120) default null,
  primary key  (`membship_code`)
) engine=innodb default charset=utf8;


create table `hs_hr_membership_type` (
  `membtype_code` varchar(6) not null default '',
  `membtype_name` varchar(120) default null,
  primary key  (`membtype_code`)
) engine=innodb default charset=utf8;


create table `hs_hr_module` (
  `mod_id` varchar(36) not null default '',
  `name` varchar(45) default null,
  `owner` varchar(45) default null,
  `owner_email` varchar(100) default null,
  `version` varchar(36) default null,
  `description` text,
  primary key  (`mod_id`)
) engine=innodb default charset=utf8;


create table `hs_hr_nationality` (
  `nat_code` varchar(6) not null default '',
  `nat_name` varchar(120) default null,
  primary key  (`nat_code`)
) engine=innodb default charset=utf8;


create table `hs_hr_province` (
  `id` int(11) not null auto_increment,
  `province_name` varchar(40) not null default '',
  `province_code` char(2) not null default '',
  `cou_code` char(2) not null default 'us',
  primary key  (`id`)
) engine=innodb default charset=utf8;

create table `hs_hr_education` (
	`edu_code` varchar(6) not null default '',
	`edu_uni` varchar(100) default null,
	`edu_deg` varchar(100) default null,
	primary key (`edu_code`)
) engine=innodb default charset=utf8;

		
create table `hs_hr_ethnic_race` (
  `ethnic_race_code` varchar(6) not null default '',
  `ethnic_race_desc` varchar(50) default null,
  primary key  (`ethnic_race_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_rights` (
  `userg_id` varchar(36) not null default '',
  `mod_id` varchar(36) not null default '',
  `addition` smallint(5) unsigned default '0',
  `editing` smallint(5) unsigned default '0',
  `deletion` smallint(5) unsigned default '0',
  `viewing` smallint(5) unsigned default '0',
  primary key  (`mod_id`,`userg_id`)
) engine=innodb default charset=utf8;


create table `hs_hr_skill` (
  `skill_code` varchar(6) not null default '',
  `skill_name` varchar(120) default null,
  primary key  (`skill_code`)
) engine=innodb default charset=utf8;


create table `hs_hr_user_group` (
  `userg_id` varchar(36) not null default '',
  `userg_name` varchar(45) default null,
  `userg_repdef` smallint(5) unsigned default '0',
  primary key  (`userg_id`)
)  engine=innodb default charset=utf8;


create table `hs_hr_users` (
  `id` varchar(36) not null default '',
  `user_name` varchar(20) default '',
  `user_password` varchar(32) default null,
  `first_name` varchar(45) default null,
  `last_name` varchar(45) default null,
  `emp_number` int(7) default 0,
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
) engine=innodb default charset=utf8;


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
) engine=innodb default charset=utf8;


create table `hs_pr_salary_currency_detail` (
  `sal_grd_code` varchar(6) not null default '',
  `currency_id` varchar(6) not null default '',
  `salcurr_dtl_minsalary` float default null,
  `salcurr_dtl_stepsalary` float default null,
  `salcurr_dtl_maxsalary` float default null,
  primary key  (`sal_grd_code`,`currency_id`)
) engine=innodb default charset=utf8;

create table `hs_pr_salary_grade` (
  `sal_grd_code` varchar(6) not null default '',
  `sal_grd_name` varchar(60) default null,
  primary key  (`sal_grd_code`)
) engine=innodb default charset=utf8;


create table `hs_hr_empreport` (
  `rep_code` varchar(6) not null default '',
  `rep_name` varchar(60) default null,
  `rep_cridef_str` varchar(200) default null,
  `rep_flddef_str` varchar(200) default null,
  primary key  (`rep_code`)
) engine=innodb default charset=utf8;

create table `hs_hr_emprep_usergroup` (
  `userg_id` varchar(6) not null default '',
  `rep_code` varchar(6) not null default '',
  primary key  (`userg_id`,`rep_code`)
) engine=innodb default charset=utf8;

CREATE TABLE `hs_hr_leave_requests` (
  `leave_request_id` int(11) NOT NULL,
  `leave_type_id` varchar(6) NOT NULL,
  `leave_type_name` char(20) default NULL,
  `date_applied` date NOT NULL,
  `employee_id` int(7) NOT NULL,
  PRIMARY KEY  (`leave_request_id`,`leave_type_id`,`employee_id`),
  KEY `employee_id` (`employee_id`),
  KEY `leave_type_id` (`leave_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `hs_hr_leave` (
  `leave_id` int(11) NOT NULL,
  `leave_date` date default NULL,
  `leave_length` smallint(6) default NULL,
  `leave_status` smallint(6) default NULL,
  `leave_comments` varchar(80) default NULL,
  `leave_request_id` int(11) NOT NULL,
  `leave_type_id` varchar(6) NOT NULL,
  `employee_id` int(7) NOT NULL,
  PRIMARY KEY  (`leave_id`,`leave_request_id`,`leave_type_id`,`employee_id`),
  KEY `leave_request_id` (`leave_request_id`,`leave_type_id`,`employee_id`),
  KEY `leave_type_id` (`leave_type_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table `hs_hr_leavetype` (
  `leave_type_id` varchar(6) not null,
  `leave_type_name` varchar(20) default null,
  `available_flag` smallint(6) default null,
  primary key  (`leave_type_id`)
) engine=innodb default charset=utf8;

create table `hs_hr_employee_leave_quota` (
  `leave_type_id` varchar(6) not null,
  `employee_id` int(7) not null,
  `no_of_days_allotted` smallint(6) default null,
  primary key  (`leave_type_id`,`employee_id`)
) engine=innodb default charset=utf8;

alter table hs_hr_compstructtree
       add constraint foreign key (loc_code)
                             references hs_hr_location(loc_code) on delete restrict;

alter table hs_pr_salary_currency_detail
       add constraint foreign key (currency_id)
                             references hs_hr_currency_type(currency_id) on delete cascade;

alter table hs_pr_salary_currency_detail
       add constraint foreign key (sal_grd_code)
                             references hs_pr_salary_grade(sal_grd_code) on delete cascade;

alter table hs_hr_location
       add constraint foreign key (loc_country)
                             references hs_hr_country(cou_code) on delete cascade;

alter table hs_hr_job_title
       add constraint foreign key (sal_grd_code)
                             references hs_pr_salary_grade(sal_grd_code) on delete set null;

alter table hs_hr_jobtit_empstat
       add constraint foreign key (jobtit_code)
                             references hs_hr_job_title(jobtit_code) on delete cascade;

alter table hs_hr_jobtit_empstat
       add constraint foreign key (estat_code)
                             references hs_hr_empstat(estat_code) on delete cascade;

alter table hs_hr_membership
       add constraint foreign key (membtype_code)
                             references hs_hr_membership_type(membtype_code) on delete cascade;

alter table hs_hr_employee
       add constraint foreign key (work_station)
                             references hs_hr_compstructtree(id) on delete set null;

alter table hs_hr_employee
       add constraint foreign key (ethnic_race_code)
                             references hs_hr_ethnic_race(ethnic_race_code) on delete set null;

alter table hs_hr_employee
       add constraint foreign key (nation_code)
                             references hs_hr_nationality(nat_code) on delete set null;

alter table hs_hr_employee
       add constraint foreign key (job_title_code)
                             references hs_hr_job_title(jobtit_code) on delete set null;

alter table hs_hr_employee
       add constraint foreign key (emp_status)
                             references hs_hr_empstat(estat_code) on delete set null;

alter table hs_hr_employee
       add constraint foreign key (eeo_cat_code)
                             references hs_hr_eec(eec_code) on delete set null;

alter table hs_hr_emp_children
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;
                             
alter table hs_hr_emp_dependents
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;
                             
alter table hs_hr_emp_emergency_contacts
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_history_of_ealier_pos
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_licenses
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;
                             
alter table hs_hr_emp_licenses
       add constraint foreign key (licenses_code)
                             references hs_hr_licenses(licenses_code) on delete cascade;
                             
alter table hs_hr_emp_skill
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_skill
       add constraint foreign key (skill_code)
                             references hs_hr_skill(skill_code) on delete cascade;

alter table hs_hr_emp_attachment
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;
                             
alter table hs_hr_emp_picture
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_education
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_education
       add constraint foreign key (edu_code)
                             references hs_hr_education(edu_code) on delete cascade;
                             
alter table hs_hr_emp_work_experience
       add constraint foreign key (emp_number)
                             references hs_hr_employee(emp_number) on delete cascade;

alter table hs_hr_emp_passport
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
       add constraint foreign key (entered_by) 
       						references hs_hr_users (id) on delete cascade;

alter table hs_hr_db_version
       add constraint foreign key (modified_by) 
       						references hs_hr_users (id) on delete cascade;

alter table hs_hr_file_version
       add constraint foreign key (altered_module)
							references hs_hr_module (mod_id) on delete cascade;
       
alter table hs_hr_file_version
       add constraint foreign key (entered_by) 
       						references hs_hr_users (id) on delete cascade;
       						
alter table hs_hr_file_version
       add constraint foreign key (modified_by) 
       						references hs_hr_users (id) on delete cascade;

alter table hs_hr_module
       add constraint foreign key (version) 
       						references hs_hr_versions (id) on delete cascade;

alter table hs_hr_rights
       add constraint foreign key (mod_id) 
       						references hs_hr_module (mod_id) on delete cascade;
       						
alter table hs_hr_rights
       add constraint foreign key (userg_id) 
       						references hs_hr_user_group (userg_id) on delete cascade;

alter table hs_hr_users
       add constraint foreign key (modified_user_id)
       						references hs_hr_users (id) on delete cascade;
       						
alter table hs_hr_users
       add constraint foreign key (created_by)
       						references hs_hr_users (id) on delete cascade;
       
alter table hs_hr_users
       add constraint foreign key (userg_id) 
       						references hs_hr_user_group (userg_id) on delete set null;
       						
alter table hs_hr_users
       add constraint foreign key (emp_number) 
       						references hs_hr_employee (emp_number) on delete restrict;
       						
alter table hs_hr_versions
       add constraint foreign key (modified_by) 
       						references hs_hr_users (id) on delete cascade;
       						
alter table hs_hr_versions
       add constraint foreign key (created_by) 
       						references hs_hr_users (id) on delete cascade;
       						
alter table hs_hr_versions
       add constraint foreign key (db_version) 
       						references hs_hr_db_version (id) on delete cascade;
       						
alter table hs_hr_versions
       add constraint foreign key (file_version) 
       						references hs_hr_file_version (id) on delete cascade;

alter table hs_hr_emprep_usergroup
       add constraint foreign key (userg_id) 
       						references hs_hr_user_group (userg_id) on delete cascade;

alter table hs_hr_emprep_usergroup
       add constraint foreign key (rep_code) 
       						references hs_hr_empreport (rep_code) on delete cascade;
       						
alter table hs_hr_employee_leave_quota
       add constraint foreign key (leave_type_id) 
       						references hs_hr_leavetype (leave_type_id) on delete cascade;
       						
alter table hs_hr_employee_leave_quota
       add constraint foreign key (employee_id) 
       						references hs_hr_employee (emp_number) on delete cascade;
       						
alter table hs_hr_leave_requests
       add constraint foreign key (employee_id) 
       						references hs_hr_employee (emp_number) on delete cascade;
							
alter table hs_hr_leave_requests
       add constraint foreign key (leave_type_id) 
       						references hs_hr_leavetype (leave_type_id) on delete cascade;
							
alter table hs_hr_leave 
		add foreign key (leave_request_id,leave_type_id,employee_id)
							references hs_hr_leave_requests 	
									(leave_request_id,leave_type_id,employee_id) on delete cascade;