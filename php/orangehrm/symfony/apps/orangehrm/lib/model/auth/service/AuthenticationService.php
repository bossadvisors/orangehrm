<?php

class AuthenticationService extends BaseService {

    private $authenticationDao;
    private $cookieManager;

    /**
     *
     * @param AuthenticationDao $dao 
     */
    public function setAuthenticationDao($dao) {
        $this->authenticationDao = $dao;
    }

    /**
     *
     * @return AuthenticationDao 
     */
    public function getAuthenticationDao() {
        if (!isset($this->authenticationDao)) {
            $this->authenticationDao = new AuthenticationDao();
        }
        return $this->authenticationDao;
    }

    /**
     *
     * @param CookieManager $cookieManager 
     */
    public function setCookieManager($cookieManager) {
        $this->cookieManager = $cookieManager;
    }

    /**
     *
     * @return CookieManager 
     */
    public function getCookieManager() {
        if (!isset($this->cookieManager)) {
            $this->cookieManager = new CookieManager();
        }
        return $this->cookieManager;
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @return bool 
     */
    public function hasValidCredentials($username, $password) {
        $user = $this->getAuthenticationDao()->getCredentials($username, md5($password));
        return (!(is_null($user) || !$user));
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @param array $additionalData
     * @return bool
     * @throws AuthenticationServiceException
     */
    public function setCredentials($username, $password, $additionalData) {
        $user = $this->getAuthenticationDao()->getCredentials($username, md5($password));

        if (is_null($user) || !$user) {
            return false;
        } else {
            sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

            if ($user->getIsAdmin() == 'No' && $user->getEmpNumber() == '') {
                throw new AuthenticationServiceException('Employee not assigned');

            } elseif (!is_null ($user->getEmployee()->getTerminationId())) {
                throw new AuthenticationServiceException('Employee is terminated');

            } elseif ($user->getStatus() == 0) {
                throw new AuthenticationServiceException('Account disabled');
            }

            $this->setBasicUserAttributes($user);
            $this->setBasicUserAttributesToSession($user);
            $this->setRoleBasedUserAttributes($user);
            $this->setRoleBasedUserAttributesToSession($user);
            $this->setSystemBasedUserAttributes($user, $additionalData);
            $this->setSystemBasedUserAttributesToSession($user, $additionalData);

            $this->getCookieManager()->setCookie('Loggedin', 'True', 0, '/');
            return true;
        }
        return true;
    }

    /**
     * Clear user credentials from session and cookies
     */
    public function clearCredentials() {
        session_destroy();
        $cookieManager = new CookieManager();
        $cookieManager->destroyCookie('Loggedin', '/');
    }

    /**
     *
     * @param Users $user 
     */
    protected function setBasicUserAttributes(SystemUser $user) {
        $sfUser = sfContext::getInstance()->getUser();
        $sfUser->setAttribute('auth.userId', $user->getId());
        $sfUser->setAttribute('auth.userGroup', $user->getUsergId());
        $sfUser->setAttribute('auth.isAdmin', $user->getIsAdmin());
         $sfUser->setAttribute('auth.isAdmin',true);
        $sfUser->setAttribute('auth.empId', $user->getEmployee()->getEmployeeId());
        $sfUser->setAttribute('auth.empNumber', $user->getEmpNumber());
       // $sfUser->setAttribute('auth.firstName', $user->getFirstName());
        $sfUser->setAttribute('auth.firstName', $user->getEmployee()->getEmpFirstname()); 
    }

    /**
     *
     * @param Users $user 
     * @deprecated
     */
    protected function setBasicUserAttributesToSession(SystemUser $user) {
        $_SESSION['user'] = $user->getId();
        $_SESSION['userGroup'] = $user->getUsergId();
         $_SESSION['isAdmin'] = $user->getIsAdmin();
        /* In the base product, this session variable is assigned with the value
           employee number (emp_number field), left padded with zeros. The session
           variable does not contain the value of actual employee id (employee_id 
           field) */
        $padLength = 4; // This should be taken from sysConf of the base product
        $_SESSION['empID'] = str_pad($user->getEmployee()->getEmpNumber(), $padLength, '0', STR_PAD_LEFT);

        $_SESSION['empNumber'] = $user->getEmpNumber();
        $_SESSION['fname'] = $user->getEmployee()->getEmpFirstname();
    }

    /**
     *
     * @param Users $user 
     */
    protected function setRoleBasedUserAttributes(SystemUser $user) {
        $isSupervisor = false;
        $isProjectAdmin = false;
        $isManager = false;
        $isDirector = false;
        $isAcceptor = false;
        $isOfferer = false;
        $isHiringManager = false;
        $isInterviewer = false;

        if ($user->getIsAdmin() == 'No') {

            $authorizeObj = $authorizeObj = Auth::instance();
            $isSupervisor = $authorizeObj->hasRole(Auth::SUPERVISOR_ROLE);
            $isProjectAdmin = $authorizeObj->hasRole(Auth::PROJECTADMIN_ROLE);
            $isManager = $authorizeObj->hasRole(Auth::MANAGER_ROLE);
            $isDirector = $authorizeObj->hasRole(Auth::DIRECTOR_ROLE);
            $isAcceptor = $authorizeObj->hasRole(Auth::INTERVIEWER);
            $isOfferer = $authorizeObj->hasRole(Auth::HIRINGMANAGER_ROLE);
            $isHiringManager = $authorizeObj->hasRole(Auth::HIRINGMANAGER_ROLE);
            $isInterviewer = $authorizeObj->hasRole(Auth::INTERVIEWER);
        }

        $sfUser = sfContext::getInstance()->getUser();
        $sfUser->setAttribute('auth.isSupervisor', $isSupervisor);
        $sfUser->setAttribute('auth.isProjectAdmin', $isProjectAdmin);
        $sfUser->setAttribute('auth.isManager', $isManager);
        $sfUser->setAttribute('auth.isDirector', $isDirector);
        $sfUser->setAttribute('auth.isAcceptor', $isAcceptor);
        $sfUser->setAttribute('auth.isOfferer', $isOfferer);
        $sfUser->setAttribute('auth.isHiringManager', $isHiringManager);
        $sfUser->setAttribute('auth.isInterviewer', $isInterviewer);
    }

    /**
     *
     * @param Users $user 
     * @deprecated
     */
    protected function setRoleBasedUserAttributesToSession(SystemUser $user) {
        $isNotAdmin = ($user->getIsAdmin() == 'No');
        $authorizeObj = Auth::instance();

        $_SESSION['isSupervisor'] = ($isNotAdmin) ? $authorizeObj->hasRole(Auth::SUPERVISOR_ROLE) : false;
        $_SESSION['isProjectAdmin'] = ($isNotAdmin) ? $authorizeObj->hasRole(Auth::PROJECTADMIN_ROLE) : false;
        $_SESSION['isManager'] = ($isNotAdmin) ? $authorizeObj->hasRole(Auth::MANAGER_ROLE) : false;
        $_SESSION['isDirector'] = ($isNotAdmin) ? $authorizeObj->hasRole(Auth::DIRECTOR_ROLE) : false;
        $_SESSION['isAcceptor'] = ($isNotAdmin) ? $authorizeObj->hasRole(Auth::INTERVIEWER) : false;
        $_SESSION['isOfferer'] = ($isNotAdmin) ? $authorizeObj->hasRole(Auth::HIRINGMANAGER_ROLE) : false;
        $_SESSION['isHiringManager'] = ($isNotAdmin) ? $authorizeObj->hasRole(Auth::HIRINGMANAGER_ROLE) : false;
        $_SESSION['isInterviewer'] = ($isNotAdmin) ? $authorizeObj->hasRole(Auth::INTERVIEWER) : false;
    }

    protected function setSystemBasedUserAttributes(SystemUser $user, $additionalData) {
        $styleSheet = 'orange'; // Current theme; TODO: Load from config
        $sfUser = sfContext::getInstance()->getUser();
        $sfUser->setAttribute('system.webPath', public_path('/'));
        $sfUser->setAttribute('system.styleSheet', $styleSheet);
        $sfUser->setAttribute('system.timeZoneOffset', $additionalData['timeZoneOffset']);
    }

    protected function setSystemBasedUserAttributesToSession(SystemUser $user, $additionalData) {
        $styleSheet = 'orange'; // Current theme; TODO: Load from config
        $_SESSION['WPATH'] = str_replace('/symfony/web/', '', public_path('/'));
        $_SESSION['styleSheet'] = $styleSheet;
        $_SESSION['userTimeZoneOffset'] = $additionalData['timeZoneOffset'];
        $_SESSION['printBenefits'] = 'enabled';
    }

}

