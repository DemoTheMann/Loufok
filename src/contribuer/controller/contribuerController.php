<?php

namespace Contribuer;

use Engine\Base;

class ContribuerController extends Base
{

    public function ContribuerPage(): void
    {
        $contribuer_model= new ContribuerModel();
        $status = $contribuer_model->isCadavreOn();

        if($_SESSION['user_id']){
            $user_id = $_SESSION['user_id'];
        } else {
            header("Location: /");
        };
        
        $data = [
            "status" => "Aucun cadavre exquis en cours pour le moment. revenez plus tard.",
            "content" => "",
            "form" => "",
        ];

        if($status){

            $cadavre = $contribuer_model->getCadavre();
            $contributions = $contribuer_model->getAllContribByCadavreId($cadavre['id_cadavre']);
            $rand_contrib = $contribuer_model->getRandContrib($user_id);
            $html = "";

            if($rand_contrib){
                $this->console->addDebugInfo("Random contribution is set");
            } else {
                $contribuer_model->setRandomContrib($cadavre['id_cadavre'],$user_id);
                $rand_contrib = $contribuer_model->getRandContrib($user_id);
            };

            $nb_contrib = $contribuer_model->countContrib($cadavre['id_cadavre']);
            $contrib = $contribuer_model->getContribById($rand_contrib['id_contribution']);
            
            $user_contrib = $contribuer_model->getContribByIdJoueur($user_id);

            if($_SERVER['REQUEST_METHOD'] === "POST"){
                
                $new_contrib_txt = $_POST['contrib'];

                if($user_contrib){
                    $contribuer_model->updateContribByJoueur($user_id, $new_contrib_txt);
                } else {
                    $contribuer_model->newContrib($cadavre['id_cadavre'], $user_id, $new_contrib_txt);
                    $user_contrib = $contribuer_model->getContribByIdJoueur($user_id);
                }
            }
            
            if($nb_contrib >= $cadavre['nb_contributions']){

                $html= 
                    "
                    <div>
                        <h5>Vous ne pouvez pas contribuer à ce Cadavre Exquis car son nombre maximum de contributions est déjà atteint.
                    </div>
                    ";
                $form = "";

            } else {

                $html= 
                    "
                    <div>
                        <h5>contribution n°".$contrib['ordre_contribution']." sur un total de ".$nb_contrib." contributions</h5>
                        <p>".$contrib['txt_contribution']."</p>
                        <h5>Poursuivez cette histoire en 280 charactères maximum.<h5>
                    </div>
                    ";
                $form =
                    "
                    <form action='' method='POST'>
                        <label for='contrib'>Votre contribution à l'histoire</label>
                        <textarea name='contrib' id='contrib' minlength='50' maxlength='280' required>". $user_contrib['txt_contribution'] ."</textarea>
                        <button type='submit'>Enregistrer votre contribution</button>
                    </form>
                    ";
            }
    
            
            $data = [
                "status" => "Voici le Cadavre Exquis du moment: " . $cadavre['titre_cadavre'],
                "content" => $html,
                "form" => $form,
            ];
        }

        $this->output->load("contribuer/contribuer", $data);

    }
}
