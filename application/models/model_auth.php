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
			if (!$data) {
				$_SESSION['message'] = 'INCORRECT LOGIN OR PASSWORD';
				header('Location: ../auth');
				exit();
			}
			else {
				$_SESSION['login'] = $data['login'];
				$_SESSION['password'] = $data['password'];
                $pdo = new PDO($dsn, $db_user, $db_password, $options);
                $pdo->exec('USE camagru_db');
                $sql = 'SELECT `User_ID`, `login` FROM users WHERE login=?';
                $sql = $pdo->prepare($sql);
                $sql->execute(array($_SESSION['login']));
                $id = $sql->fetch();
                $_SESSION['id'] = $id['User_ID'];
				header('location: ../main');
				return Model::SUCCESS;	
			}
		}
		catch (PDOException $err) {
			$err->getMessage();
            return Model::ERROR;
        }
	}
}
