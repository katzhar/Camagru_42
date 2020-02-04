<?php
class Model {
	const SUCCESS					= 0;
	const ERROR						= 1;
	const INCORRECT_LOG_OR_PSSWRD	= 2;
	public function get_data() 	{
    }
    public function action_signout()
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        header('Location: /');
    }
}
