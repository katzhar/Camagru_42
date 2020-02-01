<?php
session_start();
class Model_Signup extends Model {
	private static $fill_db = "INSERT INTO users (`e-mail`, `login`, `password`, `unique_link`) VALUES (:email, :login, :password, :unique_link)";

	public function create_acc($email, $login, $password, $password_confirm) {
		include "config/database.php";
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['message'] = "INVALID E-MAIL";
			header('Location: ../signup');
		}
		else if ($password !== $password_confirm) {
			$_SESSION['message'] = "PASSWORDS DOESN'T MATCH";
			header('Location: ../signup');
		}
		else if ($password === strtolower($password) or strlen($password) < 4) {
			$_SESSION['message'] = "YOUR PASSWORD MUST CONTAIN AT LEAST 5 CHARACTERS AND 1 UPPERCASE LETTER";
			header('Location: ../signup');
			}
		elseif (is_numeric($login) or strlen($login) < 4) {
			$_SESSION['message'] = "YOUR USERNAME MUST CONTAIN AT LEAST 5 CHARACTERS";
			header('Location: ../signup');
		}
		else {
			try {
				$dbh = new PDO($dsn, $db_user, $db_password, $options);
				$dbh->exec('USE camagru_db');
				$unique_link = time(hash('whirlpool', $_POST['email']));
				$arr = array('email' => $email, 'login' => $login, 'password' => hash("whirlpool", $password), 'unique_link' => $unique_link);
				if ($this->add_info_to_db($dbh, Model_Signup::$fill_db, $arr) === Model::SUCCESS) {
					$this->verification_email($email, $login, $unique_link);
					return Model::SUCCESS;
				}
			}
			catch(PDOxception $err) {
				$err->getMessage();
				return Model::ERROR;
			}
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

	function verification_email($email, $login, $unique_link) {
		include "config/database.php";
		$subject 	= "Please verify your email address";
		$body 		= "Hi, " . $login . "!" . "\r\n" . "Please verify your email address so we know that it's really you:" . "\r\n" . "http://" . $host . "/signup/confirm/unique_link?" . $unique_link . "\r\n\n" . "Cheers," . "\r\n" . "Camagru";
		$header 	= "From: info@camagru.com";
					"CC: info@camagru.com";
		if (mail($email, $subject, $body, $header)) {
			header('location: ../auth');
			return Model::SUCCESS;
		}
		return Model::ERROR;
	}

	function confirm_user() {
		include "config/database.php";
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$confirm_link = parse_url($url, PHP_URL_QUERY);
		try {
			$dbh = new PDO($dsn, $db_user, $db_password, $options);
			$dbh->exec('USE camagru_db');
			$query = "SELECT * FROM users WHERE unique_link = ?";
			$arr = array($confirm_link);
			$stmt = $dbh->prepare($query);
			$stmt->execute($arr);
			$data = $stmt->fetch();
			if ($data) {
				$query = "UPDATE users SET verified = 1 WHERE unique_link=?";
				$stmt = $dbh->prepare($query);
				$stmt->execute(array($data['unique_link']));
				$hello = $stmt->fetch();
				header('location: ../../main');
				return Model::SUCCESS;
			}
			else {
				echo 'ERROR';
				return Model::ERROR;		
			}
	}
	catch (PDOException $err) {
		$err->getMessage();
		return Model::ERROR;
	}
}
}