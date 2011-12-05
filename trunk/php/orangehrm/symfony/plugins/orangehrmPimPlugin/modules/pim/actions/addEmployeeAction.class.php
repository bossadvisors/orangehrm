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
class addEmployeeAction extends basePimAction {

    private $userService;

    /**
     * @param sfForm $form
     * @return
     */
    public function setForm(sfForm $form) {
        if (is_null($this->form)) {
            $this->form = $form;
        }
    }

    public function execute($request) {
        
        /* LDAP plugin installation check: Begins */
        
        if (isset($_SESSION['ldap']) && $_SESSION['ldap'] == "enabled") {
            $this->ldapInstalled = true;
        } else {
            $this->ldapInstalled = false;
        }
                
        /* LDAP plugin installation check: Ends */

        $this->showBackButton = true;
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();
        $adminMode = $this->getUser()->hasCredential(Auth::ADMIN_ROLE);

        if(!$adminMode) {
            //shud b redirected 2 ESS user view
            $this->redirect('pim/viewPersonalDetails?empNumber='. $loggedInEmpNum);
        }

        //this is to preserve post value if any error occurs
        $postArray = array();
        $this->createUserAccount = 0;

        if($request->isMethod('post')) {
            $postArray = $request->getPostParameters();
            unset($postArray['_csrf_token']);
            $_SESSION['addEmployeePost'] = $postArray;
        }

        if(isset ($_SESSION['addEmployeePost'])) {
            $postArray = $_SESSION['addEmployeePost'];

            if(isset($postArray['chkLogin'])) {
                $this->createUserAccount = 1;
            }
        }
        
        $this->setForm(new AddEmployeeForm(array(), $postArray, true));

        if ($this->getUser()->hasFlash('templateMessage')) {
            unset($_SESSION['addEmployeePost']);
            list($this->messageType, $this->message) = $this->getUser()->getFlash('templateMessage');
        }

        if ($request->isMethod('post')) {

            $this->form->bind($request->getPostParameters(), $request->getFiles());
            $posts = $this->form->getValues();
            $photoFile = $request->getFiles();

            //in case if file size exceeds 1MB
            if($photoFile['photofile']['name'] != "" && ($photoFile['photofile']['size'] == 0 || $photoFile['photofile']['size'] > 1000000)) {
                $this->getUser()->setFlash('templateMessage', array('warning', __('Adding Employee Failed. Photograph Size Exceeded 1MB')));
                $this->redirect('pim/addEmployee');
            }

            //in case a user already exists with same user name
            
            if ($this->createUserAccount) {

                $userService = $this->getUserService();
                $user = $userService->isExistingSystemUser($posts['user_name'],null);

                if($user instanceof SystemUser) {

                    $this->getUser()->setFlash('templateMessage', array('warning', __('Adding Employee Failed. User Name Already Exists')));
                    $this->redirect('pim/addEmployee');
                }
            }
            
            //if everything seems ok save employee and create a user account
            if ($this->form->isValid()) {
                
                try {

                    $fileType = $photoFile['photofile']['type'];

                    $allowedImageTypes[] = "image/gif";
                    $allowedImageTypes[] = "image/jpeg";
                    $allowedImageTypes[] = "image/jpg";
                    $allowedImageTypes[] = "image/pjpeg";
                    $allowedImageTypes[] = "image/png";
                    $allowedImageTypes[] = "image/x-png";

                    if(!empty($fileType) && !in_array($fileType, $allowedImageTypes)) {
                        $this->getUser()->setFlash('templateMessage', array('warning', __('Adding Employee Failed - Invalid File Type')));
                        $this->redirect('pim/addEmployee');
                        
                    } else {
                        unset($_SESSION['addEmployeePost']);
                        $empNumber = $this->saveEmployee($this->form);
                        
                        if ($this->createUserAccount) {
                            $this->saveUser($this->form, $empNumber);
                        }
                        $this->redirect('pim/viewPersonalDetails?empNumber='. $empNumber);
                    }

                } catch(Exception $e) {
                    print($e->getMessage());
                }
            }
        }
    }

    private function saveEmployee(sfForm $form) {

        $posts = $form->getValues();
        $file = $posts['photofile'];

        //saving employee
        $employee = new Employee();
        $employee->firstName = $posts['firstName'];
        $employee->lastName = $posts['lastName'];
        $employee->middleName = $posts['middleName'];
        $employee->employeeId = $posts['employeeId'];

        $employeeService = $this->getEmployeeService();
        $employeeService->addEmployee($employee);

        $empNumber = $employee->empNumber;

        //saving emp picture
        if(($file instanceof sfValidatedFile) && $file->getOriginalName() != "") {
            $empPicture = new EmpPicture();
            $empPicture->emp_number = $empNumber;
            $tempName = $file->getTempName();

            $empPicture->picture = file_get_contents($tempName);
            ;
            $empPicture->filename = $file->getOriginalName();
            $empPicture->file_type = $file->getType();
            $empPicture->size = $file->getSize();
            $empPicture->save();
        }

        return $empNumber;
    }

    private function saveUser(sfForm $form, $empNumber) {

        $posts = $form->getValues();

        if(trim($posts['user_name']) != "") {
            $userService = $this->getUserService();

            if(trim($posts['user_password']) != "" && $posts['user_password'] == $posts['re_password']) {
                $user = new SystemUser();
                $user->user_name = $posts['user_name'];
                $user->user_password = md5($posts['user_password']);
                $user->emp_number = $empNumber;
                $user->setUserRoleId(2);
                $userService->saveSystemUser($user);
             
               
            }
        }
    }

    private function getUserService() {

        if(is_null($this->userService)) {
            $this->userService = new SystemUserService();
        }

        return $this->userService;
    }
}

