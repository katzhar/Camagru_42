<?php
class Controller_Registration extends Controller {

	private static $view_page = "view_registration.php";

	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Registration();
	}

	function action_index() {	
		$this->view->generate('registration_view.php', 'template_view.php');
	}
	function action_confirm() {
		if ($_POST['login'] && $_POST['password'] && $_POST['submit'] && $_POST['submit'] == "SignUp") {
			echo "OK";
	}
}
}