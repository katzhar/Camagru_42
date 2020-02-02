<?php
class Controller_Auth extends Controller {
	private static $auth_page = 'auth_view.php'; 
    private static $main_page = 'main_view.php';
    private static $reset_page = 'reset_view.php';
	public function __construct() {
		$this->view = new View();
		$this->model = new Model_Auth();
	}
	
	function action_index($param = null) {	
		$this->view->generate(Controller_Auth::$auth_page, Controller::$template, $param);
    }
    
    function action_login() {
        if (!(isset($_POST['login']) or isset($_POST['password']))) {
			$this->action_index(Model::ERROR);
			return ;
		}
        $page = $this->model->check_user($_POST['login'], $_POST['password']); 
        switch ($page) {
            case (Model::ERROR):
                $this->view->generate(Controller_Auth::$auth_page, Controller::$template, Model::ERROR);
            case (Model::SUCCESS):
                $this->view->generate(Controller_Auth::$main_page, Controller::$template, Model::SUCCESS);
        }
    }

	function action_reset() {
        $page = $this->model->reset_password();
        $this->view->generate(Controller_Auth::$reset_page, Controller::$template, Model::SUCCESS);
        
	}
}