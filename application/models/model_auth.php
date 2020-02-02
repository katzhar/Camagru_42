<?php
session_start();
class Model_Auth extends Model {
	private static $check_data = "SELECT * FROM users WHERE login = ? AND password = ?";

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
				header('location: ../main');
				return Model::SUCCESS;	
			}
		}
		catch (PDOException $err) {
			$err->getMessage();
            return Model::ERROR;
        }
	}
	
	function reset_password() {
		// $reset = time(hash('whirlpool', $_POST['email']));
	}
}
// 	function reset_email($email) {
// 		include "config/database.php";
// 		$subject 	= "Reset you Camagru password";
// 		$body 		= "Hi, " . $login . "!" . "\r\n" . "Don't worry, we all forget sometimes! You've recently asked to reset the password for this Camagru account:" . $email . "\r\n\n" . "To update your password, follow this link: http://" . $host . "/auth/reset/reset_link?" . $reset_link . "\r\n\n" . "Cheers," . "\r\n" . "Camagru";
// 		$header 	= "From: info@camagru.com";
// 					"CC: info@camagru.com";
// 		if (mail($email, $subject, $body, $header)) {
// 			// $_SESSION['message'] = "CREATE NEW PASSWORD";
// 			header('location: ../auth');
// 			return Model::SUCCESS;
// 		}
// 		return Model::ERROR;
// 	}