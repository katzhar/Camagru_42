<?php
class Controller_404 extends Controller {
	private static $error_404 = '404_view.php';
	private static $template_view = 'template_view.php';

	function action_index($param = NULL) 	{
		$this->view->generate(Controller_404::$error_404, Controller_404::$template_view);
	}
}
