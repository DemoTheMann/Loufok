<?php

namespace Login;

use Engine\Base;

class LoginController extends Base
{

    public function loginPage(): void
    {
        $this->console->addDebugInfo($_SESSION);
        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $login_model = new LoginModel();
            $user_data = $login_model->getAllUsers();

            foreach ($user_data as $data) {

                if($_POST['username'] === $data['nom_plume_joueur'] and $_POST['password'] === $data['mdp_joueur']){
                    $_SESSION['auth'] = true;
                    $_SESSION['user_id'] = $data['id_joueur'];
                    $_SESSION['username'] = $data['nom_plume_joueur'];
                }
            }

            if($_SESSION['auth'] === true){
                $data = [
                    "nom_plume" => $_SESSION['username'],
                ];
                $this->output->load("login/loggedIn", $data);
            } else {
                $this->output->load('login/loginError');
            }


        } else {

            if($_SESSION['auth'] === true){

                $data = [
                    "nom_plume" => $_SESSION['username'],
                ];
                $this->output->load("login/loggedIn", $data);

            } else {
                $this->output->load('login/login');
            }

        }

    }
}
