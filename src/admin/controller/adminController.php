<?php

namespace Admin;

use Engine\Base;

class AdminController extends Base
{
    public function AdminPage(): void
    {
        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $admin_model = new AdminModel();
            $admin_data = $admin_model->getAllAdmins();

            foreach ($admin_data as $data) {

                if($_POST['email'] === $data['mail_admin'] and $_POST['password'] === $data['mdp_admin']){
                    $_SESSION['auth'] = "admin";
                    $_SESSION['user_id'] = $data['id_admin'];
                    $_SESSION['username'] = $data['nom_admin'];
                }
            }

            if(isset($_SESSION['auth'])){
                if($_SESSION['auth'] === "admin"){
                    $data = [
                        "nom_admin" => $_SESSION['username'],
                    ];
                    $this->output->load("admin/adminIn", $data);
                }
                
            } else {
                $this->output->load('admin/adminError');
            }


        } else {

            if(isset($_SESSION['auth'])){
                if($_SESSION['auth'] === "admin"){
                    $data = [
                        "nom_admin" => $_SESSION['username'],
                    ];
                    $this->output->load("admin/adminIn", $data);
                }

            } else {
                $this->output->load('admin/admin');
            }

        }

    }
}