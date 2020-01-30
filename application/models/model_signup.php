<?php
class Model_Signup extends Model {
	private static $fill_db = "INSERT INTO users (`e-mail`, `login`, `password`, `unique_link`) VALUES (:email, :login, :password, :unique_link)";

	public function create_acc($email, $login, $password, $unique_link) {
			include "config/database.php";
			try {
				$dbh = new PDO($dsn, $db_user, $db_password, $options);
				$dbh->exec('USE camagru_db');
				$unique_link = hash('whirlpool', $_POST['email']);
				$arr = array('email' => $email, 'login' => $login, 'password' => hash("whirlpool", $password), 'unique_link' => $unique_link);
				if ($this->add_info_to_db($dbh, Model_Signup::$fill_db, $arr) === Model::SUCCESS) 
					$this->verification_email($email, $login, $unique_link);
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

	function verification_email($email, $login, $unique_link) {
		include "config/database.php";
		$to 		= $email;
		$subject 	= "Please verify your email address";
		$body 		= "Hi, " . $login . "!" . "\r\n" . "Please verify your email address so we know that it's really you:" . "\r\n" . "http://" . $host . "/signup/create/" . $unique_link . "\r\n\n" . "Cheers," . "\r\n" . "Camagru";
		$header 	= "From: info@camagru.com";
					"CC: info@camagru.com";
		if (mail($email, $subject, $body, $header)) 
			header('location: ../main');
		return Model::ERROR;
	}
}