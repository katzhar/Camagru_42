<?php
session_start();
class Model_Auth extends Model {
    public function check_user($login, $password) {
		include "config/database.php";
		$hash_password = hash('whirlpool', $password);
        try {
			$dbh = new PDO($dsn, $db_user, $db_password, $options);
			$dbh->exec('USE camagru_db');
			$query = "SELECT * FROM users WHERE login = ? AND password = ?";
			$arr = array($login, $hash_password);
			$stmt = $dbh->prepare($query);
			$stmt->execute($arr);
			$data = $stmt->fetch();
			if (!$data) {
				$_SESSION['message'] = 'INCORRECT LOGIN OR PASSWORD';
				header('Location: ../auth');
			}
			else {
				$_SESSION['login'] = $data['login'];
				$_SESSION['password'] = $data['password'];
				header('location: ../main');
				return Model::SUCCESS;	
			}
		}
		catch (PDOException $err) {
            return Model::ERROR;
        }
    }
}