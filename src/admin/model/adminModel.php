<?php

namespace Admin;

use Engine\Base;

class AdminModel extends Base
{

    public function getAllAdmins(): array
    {
        return $this->database->query("SELECT * FROM `admin`");
    }

    public function getAdminById(int $id_admin): array
    {
        return $this->database->query("SELECT * FROM `admin` WHERE id_admin = :id_admin", array(":id_admin" => $id_admin));
    }

}
