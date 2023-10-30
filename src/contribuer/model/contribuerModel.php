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
        return $this->database->query("SELECT id_cadavre FROM `cadavre`");
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

    public function getContribById(int $id_contrib): array {
        return $this->database->query("SELECT * FROM `contribution` WHERE id_contribution = :id_contrib", array(":id_contrib" => $id_contrib)); 
    }

    public function getContribByIdJoueur(int $id_joueur){
        return $this->database->query("SELECT * FROM `contribution` WHERE id_joueur = :id_joueur", array(":id_joueur" => $id_joueur)); 
    }

    public function getContribByOrder(int $order)
    {
        return $this->database->query("SELECT * FROM `contribution` WHERE ordre_contribution = :order", array(":order" => $order)); 
    }

    public function getAllContribIdByCadavreId(int $cad_id): array 
    {
        return $this->database->query("SELECT id_contribution FROM `contribution` WHERE id_cadavre = :id", array(":id" => $cad_id)); 
    }

    public function countContrib(int $cad_id): int 
    {
        return count($this->getAllContribIdByCadavreId($cad_id));
    }

    public function newContrib(int $id_cadavre, int $id_joueur, string $txt_contribution): void
    {

        $ordre_contribution = $this->countContrib($id_cadavre)+1;
        $id_admin = null;

        $this->database->query("INSERT INTO `contribution`(id_admin, id_cadavre, id_joueur, txt_contribution, ordre_contribution)
                                VALUES (:id_admin, :id_cadavre, :id_joueur, :txt_contribution, :ordre_contribution)",
                                array(
                                    "id_admin" => $id_admin,
                                    ":id_cadavre" => $id_cadavre,
                                    ":id_joueur" => $id_joueur,
                                    ":txt_contribution" => $txt_contribution,
                                    "ordre_contribution" => $ordre_contribution,
                                ));
    }

    public function updateContribByJoueur(int $id_joueur, $txt_contribution): void 
    {
        $this->database->query("UPDATE `contribution`
                                SET txt_contribution = :txt_contribution
                                WHERE id_joueur = :id_joueur",
                                array(
                                    ":txt_contribution" => $txt_contribution,
                                    "id_joueur" => $id_joueur,
                                ));
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
        $contrib_id = $this->getContribByOrder($contrib_order)['id_contribution'];
        $this->database->query("INSERT INTO `rand_contribution`(id_cadavre, id_joueur, id_contribution)
                                VALUES (:id_cadavre, :id_joueur, :id_contribution)",
                                array(":id_cadavre" => $cad_id, ":id_joueur" => $user_id, ":id_contribution" => $contrib_id));
    }

}
