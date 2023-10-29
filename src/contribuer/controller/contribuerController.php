<?php

namespace Contribuer;

use Engine\Base;

class ContribuerController extends Base
{

    public function ContribuerPage(): void
    {
        $contribuer_model= new ContribuerModel();
        $status = $contribuer_model->isCadavreOn();
        $this->console->addDebugInfo($status);

        if($_SESSION['user_id']){
            $user_id = $_SESSION['user_id'];
        } else {
            header("Location: /");
        };
        
        $data = [
            "status" => "Aucun cadavre exquis en cours pour le moment. revenez plus tard.",
            "content" => "",
        ];

        if($status){

            $cadavre = $contribuer_model->getCadavre();
            $contributions = $contribuer_model->getAllContribByCadavreId($cadavre['id_cadavre']);
            $rand_contrib = $contribuer_model->getRandContrib($user_id);
            $html = "";

            $this->console->addDebugInfo($rand_contrib);

            if($rand_contrib){
                $this->console->addDebugInfo("there's something");
            } else {
                $contribuer_model->setRandomContrib($cadavre['id_cadavre'],$user_id);
            }


            $html = `

            <form action="">
                <label for="contrib">Votre contribution à l'histoire</label>
                <textarea name="contrib" id="contrib" cols="30" rows="10"></textarea>
                <button type="submit">Enregistrer votre contribution</button>
            </form>
            `;




            $data = [
                "status" => "Voici le cadavre exquis du moment: " . $cadavre['titre_cadavre'],
                "content" => $html,
            ];

            $this->output->load("contribuer/contribuer", $data);
        
        } else {

            $this->output->load("contribuer/contribuer", $data);
        }

    }
}
