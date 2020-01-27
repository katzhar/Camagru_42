<?php
class Model_Signup extends Model {
	private static $fill_db = "INSERT INTO users (id, `e-mail`, `login`, `password`) VALUES (NULL, :email, :login, :password)";

	public function create_acc($email, $login, $password) {
			include "config/database.php";
			try {
				// Create connection
				$dbh = new PDO($dsn, $db_user, $db_password, $options);
				$dbh->exec('USE camagru_db');
				$arr = array('email' => $email, 'login' => $login, 'password' => hash("whirlpool", $password));
				if ($this->add_info_to_db($dbh, Model_Signup::$fill_db, $arr) === Model::SUCCESS) 
					return Model::SUCCESS;
				return Model::ERROR;
			}
			catch(PDOxception $err) {
				$err->getMessage();
			}
	}

	private function add_info_to_db($dbh, $sql, $arr) {
		try {
			$stmt = $dbh->prepare($sql);
			$stmt->execute($arr);
			return Model::SUCCESS;
		}
		catch (PDOException $err) {
			$err->getMessage();
			return Model::ERROR;
		}
	}
}