<?php

class Auth {
    private $pdo;

    // Конструктор класса, который принимает объект PDO
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Проверка существования пользователя в базе данных
    private function userExists($username) {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        return $stmt->fetchColumn() > 0;
    }

    // Регистрация нового пользователя
    public function register($username, $password) {
        if ($this->userExists($username)) {
            return false; // Пользователь уже существует
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare('INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)');
        $stmt->execute([
            'username' => $username,
            'password_hash' => $passwordHash
        ]);
        return true;
    }

    // Аутентификация пользователя
    public function login($username, $password) {
        if (!$this->userExists($username)) {
            return false; // Пользователь не существует
        }

        $stmt = $this->pdo->prepare('SELECT password_hash FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $passwordHash = $stmt->fetchColumn();

        return password_verify($password, $passwordHash);
    }
    
    function truncateTable() {
        try {
            $stmt = $this->pdo->prepare("TRUNCATE TABLE users");
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Ошибка: " . $e->getMessage();
        }
    }
    
    function createTable() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) UNIQUE NOT NULL,
                password_hash VARCHAR(255) NOT NULL
            )";
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            echo "Ошибка создания таблицы: " . $e->getMessage();
        }
    }
}


