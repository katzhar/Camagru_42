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
        $this->view->generate('empty_view.php', 'template_view.php');
        $login = $this->model->login();
        if ($login == 'OK') {
            echo "OK";
        }
        else {
            echo "ERROR";
        }
    }
}