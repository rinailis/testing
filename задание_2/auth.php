<?php
require_once 'model.php';

$pdo = new PDO('mysql:host=localhost;dbname=testing', 'root', '');
$auth = new Auth($pdo);

$auth->register('testuser', 'password123');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        echo "<p>Авторизация успешна! Добро пожаловать, " . htmlspecialchars($username) . "!</p>";
    } else {
        echo "<p>Ошибка: неверное имя пользователя или пароль.</p>";
    }
}