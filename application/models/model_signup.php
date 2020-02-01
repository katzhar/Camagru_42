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
			else if ($password === strtolower($password) or strlen($password) < 8) {
				$_SESSION['message'] = "YOUR PASSWORD MUST CONTAIN AT LEAST 8 CHARACTERS AND 1 UPPERCASE LETTER";
				header('Location: ../signup');
			}
			else {
				try {
						$dbh = new PDO($dsn, $db_user, $db_password, $options);
						$dbh->exec('USE camagru_db');
						if ($password === $password_confirm) {
							$unique_link = time(hash('whirlpool', $_POST['email']));
							$arr = array('email' => $email, 'login' => $login, 'password' => hash("whirlpool", $password), 'unique_link' => $unique_link);
							if ($this->add_info_to_db($dbh, Model_Signup::$fill_db, $arr) === Model::SUCCESS) 
								$this->verification_email($email, $login, $unique_link);
							return Model::ERROR;
					}
				}
				catch(PDOxception $err) {
					$err->getMessage();
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
		$body 		= "Hi, " . $login . "!" . "\r\n" . "Please verify your email address so we know that it's really you:" . "\r\n" . "http://" . $host . "/signup/create/" . $unique_link . "\r\n\n" . "Cheers," . "\r\n" . "Camagru";
		$header 	= "From: info@camagru.com";
					"CC: info@camagru.com";
		if (mail($email, $subject, $body, $header)) {
			header('location: ../auth');
		}
		return Model::ERROR;
	}
}