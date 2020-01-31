<?php
class Controller_Signup extends Controller {
	private static $view_page = 'signup_view.php'; 
	private static $empty_page = 'empty_view.php';
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Signup();
	}
	
	function action_index($param = null) {	
		$this->view->generate(Controller_Signup::$view_page, Controller::$template, $param);
	}

	function action_create() {
		$page = $this->model->create_acc($_POST['email'], $_POST['login'], $_POST['password']);
		switch ($page) {
			case (Model::ERROR):
				$this->view->generate(Controller_Signup::$empty_page, Controller::$template, Model::ERROR);
			case (Model::SUCCESS):
				$this->view->generate(Controller_Signup::$empty_page, Controller::$template, Model::SUCCESS);
				echo "hello";
		}
	}
}