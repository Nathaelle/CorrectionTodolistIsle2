<?php

class Task {

    private $task_id;
    private $description;
    private $deadline;
    private $user_id;

    public function __construct(string $desc, string $dl, int $user, int $id = 0) {
        $this->task_id = $id;
        $this->description = $desc;
        $this->deadline = $dl;
        $this->user_id = $user;
    }

    public function getTaskId(): int {
        return $this->task_id;
    }

    public function setTaskId(int $id) {
        $this->task_id = $id;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $desc) {
        $this->description = $desc;
    }

    public function getDeadline(): string {
        return $this->deadline;
    }

    public function setDeadline(string $dl) {
        $this->deadline = $dl;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function setUserId(int $id) {
        $this->user_id = $id;
    }

}