<?php
class Task {
    private $id;
    private $title;
    private $completed;

    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
        $this->completed = false;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function isCompleted() {
        return $this->completed;
    }

    public function complete() {
        $this->completed = true;
    }

    public function updateTitle($title) {
        $this->title = $title;
    }
}

class TaskManager {
    private $tasks = [];
    private $nextId = 1;

    public function addTask($title) {
        $task = new Task($this->nextId++, $title);
        $this->tasks[$task->getId()] = $task;
        return $task;
    }

    public function deleteTask($id) {
        if (isset($this->tasks[$id])) {
            unset($this->tasks[$id]);
            return true;
        }
        return false;
    }

    public function updateTask($id, $title) {
        if (isset($this->tasks[$id])) {
            $this->tasks[$id]->updateTitle($title);
            return true;
        }
        return false;
    }

    public function completeTask($id) {
        if (isset($this->tasks[$id])) {
            $this->tasks[$id]->complete();
            return true;
        }
        return false;
    }

    public function getTasks() {
        return $this->tasks;
    }
}
