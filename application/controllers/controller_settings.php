<?php
class Controller_Settings extends Controller {
    private static $settings_page = 'settings_view.php';
	
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Settings();
    }
    public function action_index($param = null) {
        $this->view->generate(Controller_Settings::$settings_page, Controller::$template, $param);
    }

    function action_editprofile() {
        $this->view->generate(Controller_Settings::$settings_page, Controller::$template, Model::SUCCESS);
        $page = $this->model->edit_profile(); 
    }

    function action_changepassword() {
        $this->view->generate(Controller_Settings::$settings_page, Controller::$template, Model::SUCCESS);
        $page = $this->model->change_password();
    }
}