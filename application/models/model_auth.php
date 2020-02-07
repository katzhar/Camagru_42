<?php
session_start();
class Model_Auth extends Model {
	private static $check_data = "SELECT * FROM users WHERE login=? AND password=?";

    public function check_user($login, $password) {
		include "config/database.php";
		$hash_password = hash('whirlpool', $password);
        try {
			$dbh = new PDO($dsn, $db_user, $db_password, $options);
			$dbh->exec('USE camagru_db');
			$arr = array($login, $hash_password);
			$stmt = $dbh->prepare(Model_Auth::$check_data);
			$stmt->execute($arr);
			$data = $stmt->fetch();
			if ($data) {
				$_SESSION['login'] = $data['login'];
				$_SESSION['password'] = $data['password'];
				header ('Location: ../main');
				exit();
				return Model::SUCCESS;
			}
			else {
				$_SESSION['message'] = 'INCORRECT LOGIN OR PASSWORD';
				header('Location: ../auth');
				exit();
				return Model::ERROR;
			}
		}
		catch (PDOException $err) {
			$err->getMessage();
            return Model::ERROR;
        }
	}
}
