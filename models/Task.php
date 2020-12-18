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


    public function save_task(): bool {

        // Récupère le contenu du fichier sous la forme d'une chaîne de caractères
        $content = (file_exists("datas/tasks.json"))? file_get_contents("datas/tasks.json") : "";
        $tasks = json_decode($content);
        $tasks = (is_array($tasks))? $tasks : [];

        // Variable de vérification du bon résultat de l'appel à la méthode (utilisateur enregistré)

        $lastkey = (array_key_last($tasks) != null)? array_key_last($tasks) : 0;
        $this->task_id = (!empty($tasks))? $tasks[$lastkey]->task_id + 1 : 1;

        array_push($tasks, get_object_vars($this));

        var_dump($tasks);

        $handle = fopen("datas/tasks.json", "w");
        $verif = (fwrite($handle, json_encode($tasks)))? true : false;
        fclose($handle);

        return $verif;

    }

    static function getUserTasks(int $id): array {

        $content = (file_exists("datas/tasks.json"))? file_get_contents("datas/tasks.json") : "";
        $tasks = json_decode($content);
        $tasks = (is_array($tasks))? $tasks : [];

        $userTasks = []; 
        foreach($tasks as $task) {
            if($task->user_id == $id) {
                array_push($userTasks, $task);
            }
        } 

        // Voir doc 
        usort($userTasks, function ($a, $b) {
            if ($a->deadline == $b->deadline) {
                return 0;
            }
            return ($a->deadline < $b->deadline) ? -1 : 1;
        });

        return $userTasks;
    }

}