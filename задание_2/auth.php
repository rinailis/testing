<?php
require_once 'model.php';
// Создаем экземпляр Auth
$auth = new Auth();

// Регистрация тестового пользователя (можно убрать в реальном приложении)
$auth->register('testuser', 'password123');

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        echo "<p>Авторизация успешна! Добро пожаловать, " . htmlspecialchars($username) . "!</p>";
    } else {
        echo "<p>Ошибка: неверное имя пользователя или пароль.</p>";
    }
}