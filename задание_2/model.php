<?php

class User {
    private $username;
    private $passwordHash;

    public function __construct($username, $passwordHash) {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
    }

    public function getUsername() {
        return $this->$username;
    }
    public function getPasswordHash() {
        return $this->$passwordHash;
    }
}

class Auth {
    private $users = [];

    public function register($username, $password) {
        if (isset($this->userExists[$username])) {
            return false;
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->users[$username] = new User($username, $passwordHash);
        return true;
    }

    public function login($username, $password) {
        if (!$this->userExists[$username]) {
            return false;
        }
        $user = $this->users[$username];
        return password_verify($password, $user->getPasswordHash());
    }

    private function userExists($username) {
        return isset($this->users[$username]);
    }
}