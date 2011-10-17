<?php

require_once 'PHPUnit/Framework.php';

/**
 * Test class for AuthenticationDao.
 * Generated by PHPUnit on 2011-09-13 at 02:25:10.
 */
class AuthenticationDaoTest extends PHPUnit_Framework_TestCase {

    /**
     * @var AuthenticationDao
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->dao = new AuthenticationDao();
        $fixture = 'test/fixtures/auth/credentials.yml';

        TestDataService::populate($fixture);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * Tests getCredentials() for admin users
     */
    public function testGetCredentials_AdminUser() {
        $user = $this->dao->getCredentials('admin1', 'admin1');

        $this->assertTrue($user instanceof Users);
        $this->assertEquals('admin1', $user->getUserName());
        $this->assertEquals('Yes', $user->getIsAdmin());
    }

    /**
     * Tests getCredentials() for admin users
     */
    public function testGetCredentials_ESSUser() {
        $user = $this->dao->getCredentials('ess1', 'user1');

        $this->assertTrue($user instanceof Users);
        $this->assertEquals('ess1', $user->getUserName());
        $this->assertEquals('No', $user->getIsAdmin());
    }

    /**
     * Tests getCredentials() for wrong passwords
     */
    public function testGetCredentials_WrongPasswords() {
        $this->assertFalse($this->dao->getCredentials('admin1', 'wrong-password'));
        $this->assertFalse($this->dao->getCredentials('ess1', 'wrong-password'));
    }
    
    /**
     * Tests getCredentials() for non-existing users
     */
    public function testGetCredentials_NonExistingUsers() {
        $this->assertFalse($this->dao->getCredentials('john', 'john'));
        $this->assertFalse($this->dao->getCredentials('andrew', 'andrew'));
    }
}

?>
