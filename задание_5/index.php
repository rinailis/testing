<?php
session_start();

require_once './models/Task.php';
require_once './unitTest/TaskTest.php';

if (!isset($_SESSION['taskManager'])) {
    $_SESSION['taskManager'] = new TaskManager();
}

$taskManager = $_SESSION['taskManager'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $title = trim($_POST['title']);
        if ($title) {
            $taskManager->addTask($title);
        }
    } elseif (isset($_POST['complete'])) {
        $taskId = intval($_POST['id']);
        $taskManager->completeTask($taskId);
    } elseif (isset($_POST['delete'])) {
        $taskId = intval($_POST['id']);
        $taskManager->deleteTask($taskId);
    } elseif (isset($_POST['edit'])) {
        $taskId = intval($_POST['id']);
        $taskTitle = intval($_POST['title']);
        $taskManager->updateTask($taskId);
    }
}

$tasks = $taskManager->getTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
</head>
<body>
    <h1>Список задач:</h1>

    <form method="POST">
        <h2>Выполненные задачи:</h2>
        <input type="text" name="title" placeholder="Введите название задачи" required>
        <button type="submit" name="add">Добавить</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?php echo htmlspecialchars($task->getTitle()); ?>
                <?php if (!$task->isCompleted()): ?>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">
                        <button type="submit" name="complete">Пометить как выполненное</button>
                    </form>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">
                    <button type="submit" name="delete">Удалить</button>
                </form>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $task->getId(); ?>">
                    <input type="text" name="title" placeholder="Введите название задачи" required>
                    <button type="submit" name="edit">Редактировать</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
