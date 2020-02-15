<?php 
session_start();
class Model_Reset extends Model {
    private static $update_db = "UPDATE users SET `reset_link`=:reset_link WHERE `e-mail`=:email";
    private static $update_password = "UPDATE users SET password=:password WHERE reset_link=:reset_link";

	function set_reset_link() {
		include "config/database.php";
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $reset_link = parse_url($url, PHP_URL_QUERY);
		try {
			$dbh = new PDO($dsn, $db_user, $db_password, $options);
			$dbh->exec('USE camagru_db');
			$query = "SELECT * FROM users WHERE reset_link = ?";
            $arr = array($reset_link);
			$stmt = $dbh->prepare($query);
			$stmt->execute($arr);
			$data = $stmt->fetch();
			if ($data) {
				$query = "UPDATE users SET password=NULL WHERE reset_link=?";
				$stmt = $dbh->prepare($query);
				$stmt->execute(array($data['reset_link']));
				$hello = $stmt->fetch();
                $_SESSION['reset_link'] = $reset_link;
                return Model::SUCCESS;
			}
		}
		catch (PDOException $err) {
			$err->getMessage();
			return Model::ERROR;
		}
	}

    function update_password($password_new, $password_confirm) {
		include "config/database.php";
		$password_new = $_POST['password_new'];
		$password_confirm = $_POST['password_confirm'];
		if ($password_new !== $password_confirm) {
			$_SESSION['message'] = "PASSWORDS DOESN'T MATCH";
			header('Location: ../reset/newpassword');
			exit();
		}
		else if ($password_new === strtolower($password_new) or strlen($password_new) < 4) {
			$_SESSION['message'] = "YOUR PASSWORD MUST CONTAIN AT LEAST 5 CHARACTERS AND 1 UPPERCASE LETTER";
			header('Location: ../reset/newpassword');
			exit();
		}
		else {
			try {
				$reset_link = $_SESSION['reset_link'];
				$password_new = $_POST['password_new'];
				$dbh = new PDO($dsn, $db_user, $db_password, $options);
				$dbh->exec('USE camagru_db');
				$query = "SELECT * FROM users WHERE reset_link = ?";
				$arr = array($reset_link);
				if ($this->add_info_to_db($dbh, $query, $arr) === Model::SUCCESS) {
					$query = "UPDATE users SET password=:password WHERE reset_link=:reset_link";
					$arr = array('reset_link' => $reset_link, 'password' => hash('whirlpool', $password_new));
					$this->add_info_to_db($dbh, $query, $arr);
					$_SESSION['message'] = "YOUR PASSWORD HAS BEEN CHANGED SUCCESSFULLY";
					header('location: ../auth');
					exit();
					return Model::SUCCESS;
				}	
			}		
			catch(PDOxception $err) {
				$err->getMessage();
				return Model::ERROR;
			}
		}
	}

	function reset_password($email) {
        include "config/database.php";
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['message'] = "INVALID E-MAIL";
			header('Location: ../reset');
			exit();
		}
		if ($this->check_email($_POST['email']) === Model::ERROR) {
			$_SESSION['message'] = "SUCH E-MAIL ISN'T REGISTERED";
			header('Location: ../reset');
			exit();
		}
        else {
            try {
                $dbh = new PDO($dsn, $db_user, $db_password, $options);
                $dbh->exec('USE camagru_db');
                $reset_link = time(hash('whirlpool', $email));
                $arr = array('email' => $email, 'reset_link' => $reset_link);
                if ($this->add_info_to_db($dbh, Model_Reset::$update_db, $arr) === Model::SUCCESS) {
                    $this->reset_email($email, $reset_link);
                    return Model::SUCCESS;
                }
            return Model::ERROR;
            }
            catch (PDOException $err) {
                $err->getMessage();
                return Model::ERROR;
            }
        }
	}

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
				return Model::ERROR;
			return Model::SUCCESS;
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
    
	function reset_email($email, $reset_link) {
		include "config/database.php";
		$subject 	= "Reset you Camagru password";
		$body 		= "Hi!" . "\r\n\n" . "Don't worry, we all forget sometimes! You've recently asked to reset the password for this Camagru account:" . "\r\n" . $email . "\r\n\n" . "To update your password, follow this link: http://" . $host . "/reset/confirm/reset_link?" . $reset_link . "\r\n\n" . "Cheers," . "\r\n" . "Camagru";
		$header 	= "From: info@camagru.com";
					"CC: info@camagru.com";
		if (mail($email, $subject, $body, $header)) {
			$_SESSION['message'] = "WE SEND A VERIFICATION LINK TO YOUR E-MAIL, PLEASE CHECK IT";
			return Model::SUCCESS;
		}
		return Model::ERROR;
    }
}
