<?php

namespace Contribuer;

use Engine\Base;

class ContribuerModel extends Base
{   

    public function getCadavre()
    {
        return $this->database->query("SELECT * FROM `cadavre`");
    }

    public function getCadavreId()
    {
        $this->database->query("SELECT id_cadavre FROM `cadavre`");
    }

    public function isCadavreOn()
    {
        // $currentDate = date("d-m-y");

        // if($this->getCadavreId() and $this->getCadavre()['date_fin_cadavre'] > $currentDate){
            return $this->getCadavreId();
        // }
    }

    public function getAllContrib(): array
    {
        return $this->database->query("SELECT * FROM `contribution`");
    }

    public function getContribIdByOrder(int $order): array
    {
        return $this->database->query("SELECT id_contribution FROM `contribution` WHERE ordre_contribution = :order", array(":order" => $order)); 
    }

    public function getAllContribByCadavreId(int $cad_id): array 
    {
        return $this->database->query("SELECT * FROM `contribution` WHERE id_cadavre = :id", array(":id" => $cad_id)); 
    }

    public function countContrib(int $cad_id): int 
    {
        return count($this->getAllContribByCadavreId($cad_id));
    }

    public function getAllRandomContrib(): array
    {
        return $this->database->query("SELECT * FROM `rand_contribution`");
    }

    public function getRandContrib(int $user_id)
    {
        return $this->database->query("SELECT id_contribution FROM `rand_contribution` WHERE id_joueur = :user_id", array(":user_id" => $user_id));
    }

    public function setRandomContrib(int $cad_id, int $user_id)
    {
        $nb_contrib = $this->countContrib($cad_id);
        $contrib_order = rand(1,$nb_contrib);
        $contrib_id = $this->getContribIdByOrder($contrib_order);
        $this->database->query("INSERT INTO `rand_contribution`(id_cadavre, id_joueur, id_contribution)
                                VALUES (:id_cadavre, :id_joueur, :id_contribution)",
                                array(":id_cadavre" => $cad_id, ":id_joueur" => $user_id, ":id_contribution" => $contrib_id['id_contribution']));
    }

}
