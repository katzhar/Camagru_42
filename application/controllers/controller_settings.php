<?php
class Controller_Settings extends Controller {
    private static $settings1_page = 'settings1_view.php';
    private static $settings2_page = 'settings2_view.php';
    private static $settings3_page = 'settings3_view.php';
	
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Settings();
    }
    
    public function action_index($param = null) {
        $this->view->generate(Controller_Settings::$settings1_page, Controller::$template, $param);
        $page = $this->model->get_email();
    }

    function action_changelogin() {
        $this->view->generate(Controller_Settings::$settings1_page, Controller::$template, Model::SUCCESS);
        $page = $this->model->change_login(); 
    }

    function action_changeemail() {
        $this->view->generate(Controller_Settings::$settings2_page, Controller::$template, Model::SUCCESS);
    }

    function action_confirmemail() {
        $this->view->generate(Controller_Settings::$settings2_page, Controller::$template, Model::SUCCESS);
        $page = $this->model->change_email(); 
    }

    function action_changepassword() {
        $this->view->generate(Controller_Settings::$settings3_page, Controller::$template, Model::SUCCESS);
    }

    function action_confirmpassword() {
        $this->view->generate(Controller_Settings::$settings3_page, Controller::$template, Model::SUCCESS);
        $page = $this->model->change_password();
    }
}