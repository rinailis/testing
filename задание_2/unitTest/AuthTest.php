<?php
require_once 'model.php';
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {
    protected $auth;

    protected function setUp(): void {
        $this->auth = new Auth();
    }

    // регистрация нового пользователя
    public function testRegisterNewUser() {
        $result = $this->auth->register('testuser', 'password123');
        $this->assertTrue($result);
    }

     // регистрация существующего пользователя
    public function testRegisterExistingUser() {
        $this->auth->register('testuser', 'password123');
        $result = $this->auth->register('testuser', 'newpassword');
        $this->assertFalse($result);
    }

    // вход с правильными учётными данными
    public function testLoginWithCorrectCredentials() {
        $this->auth->register('testuser', 'password123');
        $result = $this->auth->login('testuser', 'password123');
        $this->assertTrue($result);
    }

    // вход с некорректным паролем
    public function testLoginWithIncorrectPassword() {
        $this->auth->register('testuser', 'password123');
        $result = $this->auth->login('testuser', 'wrongpassword');
        $this->assertFalse($result);
    }

    // вход с несуществующим пользователем
    public function testLoginWithNonExistentUser() {
        $result = $this->auth->login('nonexistentuser', 'password123');
        $this->assertFalse($result);
    }
}
