<?php

class User {

    private $user_id;
    private $username;
    private $password;

    public function __construct(string $name, string $passwd, int $id = 0) {
        $this->user_id = $id;
        $this->username = $name;
        $this->password = $passwd;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function setUserId(int $id) {
        $this->user_id = $id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $name) {
        $this->username = $name;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $passwd) {
        $this->password = $passwd;
    }

}