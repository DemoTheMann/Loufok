<?php

namespace Cadavre;

use Engine\Base;

class CadavreModel extends Base
{

    public function isCadavreOn(): bool {
        if($this->database->query("SELECT * FROM `cadavre`") === false){
            return false;
        } else {
            return true;
        }
    }

    public function getCadavre()
    {
        return $this->database->query("SELECT * FROM `cadavre`");
    }

    public function getAdminName(int $id_admin): array {
        return $this->database->query("SELECT nom_admin FROM `admin` WHERE id_admin = :id_admin", array(":id_admin" => $id_admin)); 
    }

    public function getFirstContrib(): array{
        return $this->database->query("SELECT * FROM `contribution` WHERE ordre_contribution = 1"); 
    }

    public function getAllContribIdByCadavreId(int $cad_id): array 
    {
        return $this->database->query("SELECT id_contribution FROM `contribution` WHERE id_cadavre = :id", array(":id" => $cad_id)); 
    }

    public function countContrib(int $cad_id): int 
    {
        return count($this->getAllContribIdByCadavreId($cad_id));
    }


    public function newCadavre(int $id_admin, string $titre_cadavre, $date_fin_cadavre, int $nb_contributions): void 
    {
        $this->database->query("INSERT INTO `cadavre`(id_admin, titre_cadavre, date_fin_cadavre, nb_contributions)
                                VALUES (:id_admin, :titre_cadavre, :date_fin_cadavre, :nb_contributions)",
                                array(
                                    "id_admin" => $id_admin,
                                    ":titre_cadavre" => $titre_cadavre,
                                    ":date_fin_cadavre" => $date_fin_cadavre,
                                    ":nb_contributions" => $nb_contributions,
                                ));
    }

    public function setFirstContrib(int $id_admin, int $id_cadavre,  string $txt_contribution): void
    {
        $ordre_contribution = 1;
        $id_joueur = null;

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
}