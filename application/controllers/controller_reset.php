<?php
class Controller_Reset extends Controller {
    private static $reset_page = 'reset_view.php'; 
    private static $newpassword_page = "newpassword_view.php";
    private static $auth_page = "auth_view.php";

    
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Reset();
	}

    function action_index($param = null) {	
		$this->view->generate(Controller_Reset::$reset_page, Controller::$template, $param);
    }

    function action_update() {
        $page = $this->model->reset_password($_POST['email']); 
		$this->view->generate(Controller_Reset::$reset_page, Controller::$template, Model::SUCCESS);
    }

    function action_confirm() {
        $page = $this->model->set_reset_link();
    }
    
    function action_newpassword() {
        $page = $this->model->update_password();
        $this->view->generate(Controller_Reset::$newpassword_page, Controller::$template, Model::SUCCESS);
    }
    
    function action_ok() {
        $page = $this->model->set_new_password($_POST['password_new'], $_POST['password_confirm']);
        switch ($page) {
        case Model::SUCCESS;
            $this->view->generate(Controller_Reset::$auth_page, Controller::$template, Model::SUCCESS);
        case Model::ERROR;
            $this->view->generate(Controller_Reset::$newpassword_page, Controller::$template, Model::SUCCESS);
    }
}
}