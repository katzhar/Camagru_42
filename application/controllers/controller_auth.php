<?php
class Controller_Auth extends Controller {
	private static $view_page = 'auth_view.php'; 
	private static $empty_page = 'empty_view.php';
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Auth();
	}
	
	function action_index($param = null) {	
		$this->view->generate(Controller_Auth::$view_page, Controller::$template, $param);
    }
    
    function action_login() {
        $page = $this->model->check_user($_POST['login'], $_POST['password']); 
        switch ($page) {
            case (Model::INCORRECT_LOG_OR_PSSWRD):
                $this->view->generate(Controller_Auth::$empty_page, Controller::$template, Model::INCORRECT_LOG_OR_PSSWRD);
            case (Model::SUCCESS):
                $this->view->generate(Controller_Auth::$empty_page, Controller::$template, Model::SUCCESS);
        }
        
    }
}