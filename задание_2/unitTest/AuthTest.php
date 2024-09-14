<?php
require_once 'model.php';

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    protected $auth;

    protected function setUp(): void
    {
        $pdo = new PDO('mysql:host=localhost;dbname=testing', 'root', '');
        $this->auth = new Auth($pdo);
    }

    // регистрация нового пользователя
    public function testRegisterNewUser()
    {
        $this->auth->createTable();
        $result = $this->auth->register('testuser', 'password123');
        $this->assertTrue($result);
        $this->auth->truncateTable();
    }

    // регистрация существующего пользователя
    public function testRegisterExistingUser()
    {
        $this->auth->createTable();
        $this->auth->register('testuser', 'password123');
        $result = $this->auth->register('testuser', 'newpassword');
        $this->assertFalse($result);
        $this->auth->truncateTable();
    }

    // вход с правильными учётными данными
    public function testLoginWithCorrectCredentials()
    {
        $this->auth->createTable();
        $this->auth->register('testuser', 'password123');
        $result = $this->auth->login('testuser', 'password123');
        $this->assertTrue($result);
        $this->auth->truncateTable();
    }

    // вход с некорректным паролем
    public function testLoginWithIncorrectPassword()
    {
        $this->auth->createTable();
        $this->auth->register('testuser', 'password123');
        $result = $this->auth->login('testuser', 'wrongpassword');
        $this->assertFalse($result);
        $this->auth->truncateTable();
    }

    // вход с несуществующим пользователем
    public function testLoginWithNonExistentUser()
    {
        $this->auth->createTable();
        $result = $this->auth->login('nonexistentuser', 'password123');
        $this->assertFalse($result);
        $this->auth->truncateTable();
    }
}
