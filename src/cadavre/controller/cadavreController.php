<?php

namespace Cadavre;

use Engine\Base;

class CadavreController extends Base
{
    public function CadavrePage(): void
    {
        $cadavre_model= new CadavreModel();
        $status = $cadavre_model->isCadavreOn();

        if($_SESSION['user_id']){
            $user_id = $_SESSION['user_id'];
        } else {
            header("Location: /admin");
        };

        if($status){

            $current_cadavre = $cadavre_model->getCadavre();

            $current_cadavre_admin = $cadavre_model->getAdminName($current_cadavre['id_admin']);

            $current_cadavre_total_contrib = $cadavre_model->countContrib($current_cadavre['id_cadavre']);

            $current_cadavre_first_contrib = $cadavre_model->getFirstContrib();
                
            $html =
            "
                <h>Nom du Cadavre Exquis: ". $current_cadavre['titre_cadavre'] ."</h4>
                <p>Nom de l'administrateur d'origine: ". $current_cadavre_admin['nom_admin'] ."</p>
                <p>Date de création: ". $current_cadavre['date_debut_cadavre'] ."</p>
                <p>Date de cloturation: ". $current_cadavre['date_fin_cadavre'] ."</p>
                <p>Nombre de contributions: ". $current_cadavre_total_contrib ." sur ". $current_cadavre['nb_contributions'] ." contributions autorisées</p>
                <p>Récit d'origine: ". $current_cadavre_first_contrib['txt_contribution'] ."</p>
            ";

            $form = "";

            $data = [
                "status" => "Un Cadavre Exquis est déjà en cours de réalisation, voici un résumé de ses paramètres.",
                "content" => $html,
                "form" => $form,
            ];

        } else {
            
            if($_SERVER['REQUEST_METHOD'] === "POST"){

                $id_admin = $_SESSION['user_id'];
                $titre_cadavre = $_POST['title'];
                $date_fin_cadavre = $_POST['date_fin'];
                $nb_contributions = $_POST['nb_contrib'];
                $txt_contribution = $_POST['contrib'];

                $cadavre_model->newCadavre($id_admin,$titre_cadavre,$date_fin_cadavre,$nb_contributions);

                $id_cadavre = $cadavre_model->getCadavre()['id_cadavre'];

                $cadavre_model->setFirstContrib($id_admin,$id_cadavre,$txt_contribution);

                header("Location: /cadavre");
                
            };

            $html = "";

            $form = 
            "
            <form action='' method='POST'>
                <label for='title'>Entrez le titre</label>
                <input type='text' name='title' id='title' required>
                <label for='date_fin'>La date de cloturation</label>
                <input type='date' name='date_fin' id='date_fin' required>
                <label for='nb_contrib'>Le nombre de contributions maximum autorisées</label>
                <input type='number' name='nb_contrib' id='nb_contrib' required>

                <label for='contrib'>La première contribution du récit</label>
                <textarea name='contrib' id='contrib' minlength='50' maxlength='280' required></textarea>

                <button type='submit'>Démarrer le Cadavre Exquis</button>
            </form>
            ";

            $data = [
                "status" => "Aucun Cadavre Exquis n'est en cours de création, voulez vous en créer un ?",
                "content" => $html,
                "form" => $form,
            ];

        }

        $this->output->load('cadavre/cadavre', $data);
    }
}