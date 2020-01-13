<?php

class Controller_Auth extends Controller {
    public function __construct()      {  
           $this->model = new Model_Auth();
           $this->view = new View();
    }

    function action_index() {
        $this->view->generate('auth_view.php', 'template_view.php');
    }

    function action_login() {
        $login = $this->model->getlogin();
            if ($login == 'OK') {
                echo "OK";
            }
            else   {
                echo "ERROR";
            }
    }
}