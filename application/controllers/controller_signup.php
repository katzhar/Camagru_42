<?php
class Controller_Signup extends Controller {
	private static $signup_page = 'signup_view.php'; 
	private static $auth_page = 'auth_view.php';
	
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Signup();
	}
	
	function action_index($param = null) {	
		$this->view->generate(Controller_Signup::$signup_page, Controller_Signup::$signup_page, $param);
	}

	function action_create() {
        if (!(isset($_POST['email']) or isset($_POST['login']) or isset($_POST['password']) or isset($_POST['password_confirm']))) {
			$this->action_index(Model::ERROR);
			return ;
		}
		$page = $this->model->create_acc($_POST['email'], $_POST['login'], $_POST['password'], $_POST['password_confirm']); 
		switch ($page) {
			case (Model::ERROR):
				$this->view->generate(Controller_Signup::$signup_page, Controller::$template, Model::ERROR);
			case (Model::SUCCESS):
				$this->view->generate(Controller_Signup::$auth_page, Controller::$template, Model::SUCCESS);
		}
	}
	
	function action_confirm() {
		$page = $this->model->confirm_user();
	}
}