<?php
session_start();
class Model_Signup extends Model {
	private static $fill_db = "INSERT INTO users (`e-mail`, `login`, `password`, `unique_link`) VALUES (:email, :login, :password, :unique_link)";

	function check_email($email) {
		include "config/database.php";
		$dbh = new PDO($dsn, $db_user, $db_password, $options);
		$dbh->exec('USE camagru_db');
		$sql_checkemail = "SELECT COUNT(*) FROM users WHERE `e-mail`=?";
		$stmt = $dbh->prepare($sql_checkemail);
		$stmt->execute(array($email));
		$data = $stmt->fetch();
		$count = count($data);
		foreach ($data as $value) {
			if ($value === 0) 
				return Model::SUCCESS;
			return Model::ERROR;
		}
	}

	function check_login($login) {
		include "config/database.php";
		$dbh = new PDO($dsn, $db_user, $db_password, $options);
		$dbh->exec('USE camagru_db');
		$sql_checklogin = "SELECT COUNT(*) FROM users WHERE `login`=?";
		$stmt = $dbh->prepare($sql_checklogin);
		$stmt->execute(array($login));
		$data = $stmt->fetch();
		$count = count($data);
		foreach ($data as $value) {
			if ($value === 0) 
				return Model::SUCCESS;
			return Model::ERROR;
		}
	}	

	public function create_acc($email, $login, $password, $password_confirm) {
		include "config/database.php";
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['message'] = "INVALID E-MAIL";
			header('Location: ../signup');
			exit();
		}
		else if ($this->check_email($email) === Model::ERROR) {
			$_SESSION['message'] = "THIS E-MAIL ALREADY EXISTS";
			header('Location: ../signup');
			exit();
		}
		else if ($this->check_login($login) === Model::ERROR) {
			$_SESSION['message'] = "THIS USERNAME IS ALREADY IN USE";
			header('Location: ../signup');
			exit();
		}
		else if ($password !== $password_confirm) {
			$_SESSION['message'] = "PASSWORDS DOESN'T MATCH";
			header('Location: ../signup');
			exit();
		}
		else if ($password === strtolower($password) or strlen($password) < 5) {
			$_SESSION['message'] = "YOUR PASSWORD MUST CONTAIN AT LEAST 5 CHARACTERS AND 1 UPPERCASE LETTER";
			header('Location: ../signup');
			exit();
		}
		elseif (is_numeric($login) or strlen($login) < 5) {
			$_SESSION['message'] = "YOUR USERNAME MUST CONTAIN AT LEAST 5 CHARACTERS";
			header('Location: ../signup');
			exit();
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
			return Model::ERROR;		
		}
		catch (PDOException $err) {
			$err->getMessage();
			return Model::ERROR;
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
			$_SESSION['message'] = "WE SEND A VERIFICATION LINK TO YOUR E-MAIL, PLEASE CHECK IT";
			header('location: ../auth');
			exit();
			return Model::SUCCESS;
		}
		return Model::ERROR;
	}
}