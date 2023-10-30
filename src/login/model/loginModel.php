<?php

namespace Login;

use Engine\Base;

class LoginModel extends Base
{

    public function getAllUsers(): array
    {
        return $this->database->query("SELECT * FROM `joueur`");
    }

    public function getUserById(int $user_id): array
    {
        return $this->database->query("SELECT * FROM `joueur` WHERE id_joueur = :user_id", array(":user_id" => $user_id));
    }

}
