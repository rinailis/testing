<?php
require_once 'models/Task.php';

use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase {
    private $taskManager;

    protected function setUp(): void {
        $this->taskManager = $this->createMock(TaskManager::class);
    }

    public function testAddTask() {
        $mockTask = $this->createMock(Task::class);
        $mockTask->method('getTitle')->willReturn("Test Task");
        $mockTask->method('isCompleted')->willReturn(false);

        $this->taskManager->method('addTask')->willReturn($mockTask);

        $task = $this->taskManager->addTask("Test Task");
        $this->assertEquals("Test Task", $task->getTitle());
        $this->assertFalse($task->isCompleted());
    }

    public function testDeleteTask() {
        $mockTask = $this->createMock(Task::class);
        $mockTask->method('getId')->willReturn(1);
        
        $this->taskManager->method('addTask')->willReturn($mockTask);
        $this->taskManager->method('deleteTask')->willReturn(true);
        
        $task = $this->taskManager->addTask("Task to Delete");
        
        $result = $this->taskManager->deleteTask($task->getId());
        $this->assertTrue($result);
    }

    public function testUpdateTask() {
        $mockTask = $this->createMock(Task::class);
        $mockTask->method('getId')->willReturn(1);
        $mockTask->method('getTitle')->willReturn("Old Title");

        $this->taskManager->method('addTask')->willReturn($mockTask);
        $this->taskManager->method('updateTask')->willReturn(true);

        $task = $this->taskManager->addTask("Old Title");
        $result = $this->taskManager->updateTask($task->getId(), "New Title");
        
        $this->assertTrue($result);
    }

    public function testCompleteTask() {
        $mockTask = $this->createMock(Task::class);
        $mockTask->method('getId')->willReturn(1);
        
        $this->taskManager->method('addTask')->willReturn($mockTask);
        $this->taskManager->method('completeTask')->willReturn(true);
        
        $task = $this->taskManager->addTask("Task to Complete");
        $result = $this->taskManager->completeTask($task->getId());
        
        $this->assertTrue($result);
    }

    public function testCompleteNonExistentTask() {
        $this->taskManager->method('completeTask')->willReturn(false);
        
        $result = $this->taskManager->completeTask(999);
        $this->assertFalse($result);
    }

    public function testDeleteNonExistentTask() {
        
        $this->taskManager->method('deleteTask')->willReturn(false);
        
        $result = $this->taskManager->deleteTask(999);
        $this->assertFalse($result);
    }
}
