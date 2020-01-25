<?php
class Model_Signup extends Model {
	private static $fill_db = "INSERT INTO users (id, `e-mail`, `login`, `password`) VALUES (NULL, :email, :login, :password)";

	public function create_acc($email, $log, $passwd) {
			include "config/database.php";
			$dbh = new PDO($dsn, $db_user, $db_password, $options);
			$dbh->exec('USE db_camagru');
			try {

			}
			
	}
}
