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

    public function save_user(): bool {

        // Récupère le contenu du fichier sous la forme d'une chaîne de caractères
        $content = (file_exists("datas/users.json"))? file_get_contents("datas/users.json") : "";
        $users = json_decode($content);
        $users = (is_array($users))? $users : [];

        var_dump($users);

        // Variable de vérification du bon résultat de l'appel à la méthode (utilisateur enregistré)
        $verif = true;

        // Je parcours mon tableau (ma liste d'utilisateurs) :
        foreach($users as $user) {
            // Si l'on rencontre un utilisateur ayant le même pseudo, on ne permettra pas l'enregistrement de l'utilisateur courant
            if($user->username == $this->username) {
                $verif = false;
            }
        }

        if($verif) {

            $lastkey = (array_key_last($users) != null)? array_key_last($users) : 0;
            $this->user_id = (!empty($users))? $users[$lastkey]->user_id + 1 : 1;

            array_push($users, get_object_vars($this));

            $handle = fopen("datas/users.json", "w");
            $verif = (fwrite($handle, json_encode($users)))? true : false;
            fclose($handle);

        }

        return $verif;

    }

    public function verify_user(): bool {

        $content = (file_exists("datas/users.json"))? file_get_contents("datas/users.json") : "";
        $users = json_decode($content);
        $users = (is_array($users))? $users : [];

        $verif = false;

        foreach($users as $user) {
            if($user->username == $this->username) {
                $verif = password_verify($this->password, $user->password);
            }
        }

        return $verif;

    }

}