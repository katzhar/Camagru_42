<?php
class Controller_Signup extends Controller {
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Signup();
	}
	function action_index() {	
		$this->view->generate('signup_view.php', 'template_view.php');
	}

	function action_confirm() {
		$this->view->generate('empty_view.php', 'template_view.php');
		$signup = $this->model->signup();
		if ($signup == "ERROR") {
			echo "ERROR";	
		}
		else if ($signup == "OK") {
			echo "Please check your e-mail and verify your account";
		}
	
	}
}