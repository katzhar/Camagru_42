<?php
class Controller_Settings extends Controller {
    private static $settings1_page = 'settings1_view.php';
    private static $settings2_page = 'settings2_view.php';
	
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Settings();
    }
    
    public function action_index($param = null) {
        $this->view->generate(Controller_Settings::$settings1_page, Controller::$template, $param);
    }

    function action_editlogin() {
        $this->view->generate(Controller_Settings::$settings1_page, Controller::$template, Model::SUCCESS);
        $page = $this->model->edit_login(); 
    }

    function action_editemail() {
        $this->view->generate(Controller_Settings::$settings1_page, Controller::$template, Model::SUCCESS);
        $page = $this->model->edit_email(); 
    }

    function action_changepassword() {
        $this->view->generate(Controller_Settings::$settings2_page, Controller::$template, Model::SUCCESS);
        $page = $this->model->change_password();
    }
}