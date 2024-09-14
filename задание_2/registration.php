<?php
require_once 'model.php';
// Создаем экземпляр Auth
$auth = new Auth();

// Обработка формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->register($username, $password)) {
        echo "<p>Регистрация успешна! Добро пожаловать, " . htmlspecialchars($username) . "!</p>";
    } else {
        echo "<p>Ошибка: пользователь с таким именем уже существует.</p>";
    }
}