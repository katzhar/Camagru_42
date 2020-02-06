<?php
session_start();
class Model_Settings extends Model {
    
private static $edit_profile = "UPDATE users SET `login`=? WHERE `login`=?";
private static $changepassword = "";


function edit_login() {
    include "config/database.php";
    $login = $_SESSION['login'];
    $login_new = $_POST['login_new'];
    if (is_numeric($login_new) or strlen($login_new) < 5) {
        $_SESSION['message'] = "YOUR USERNAME MUST CONTAIN AT LEAST 5 CHARACTERS";
        header('Location: ../settings');
        exit();
    }
    elseif (stripos($login_new, ' ')) {
        $_SESSION['message'] = "YOUR USERNAME MUST NOT CONTAIN ANY SPACES";
        header('Location: ../settings');
        exit();
    }
    elseif (preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',$login_new)) {
        $_SESSION['message'] = "YOUR USERNAME MUST NOT CONTAIN ANY SPECIAL CHARACTERS";
        header('Location: ../settings');
        exit();
    }
    try {
        $dbh = new PDO($dsn, $db_user, $db_password, $options);
        $dbh->exec('USE camagru_db');
        $query = "SELECT * FROM users WHERE login=?";
        $arr = array($login);
        $stmt = $dbh->prepare($query);
        $stmt->execute($arr);
        $data = $stmt->fetch();
        if ($data) {
            $query = "UPDATE users SET login=? WHERE login=?";
            $stmt = $dbh->prepare($query);
            $stmt->execute(array($login_new, $login));
            $hello = $stmt->fetch();
            $_SESSION['login'] = $login_new;
            $_SESSION['message'] = "YOUR USERNAME HAS BEEN CHANGED SUCCESSFULLY";
            header('location: ../settings');
            exit();
            return Model::SUCCESS;
        }
        return Model::ERROR;		
        }
        catch (PDOException $err) {
            $err->getMessage();
            return Model::ERROR;
        }
    }

    // function edit_email() {
    //     include "config/database.php";
    //     $login = $_SESSION['login'];
    //     $email_new = $_POST['email_new'];
    //     print_r($login, $email_new);
    //     try {
    //         $dbh = new PDO($dsn, $db_user, $db_password, $options);
    //         $dbh->exec('USE camagru_db');
    //         $query = "SELECT * FROM users WHERE login=?";
    //         $arr = array($login);
    //         $stmt = $dbh->prepare($query);
    //         $stmt->execute($arr);
    //         $data = $stmt->fetch();
    //         if ($data) {
    //             $query = "UPDATE users SET email=? WHERE login=?";
    //             $stmt = $dbh->prepare($query);
    //             $stmt->execute(array($email_new, $login));
    //             $hello = $stmt->fetch();
    //             $_SESSION['message'] = "YOUR E-MAIL HAS BEEN CHANGED SUCCESSFULLY";
    //             header('location: ../settings');
    //             exit();
    //             return Model::SUCCESS;
    //         }
    //         return Model::ERROR;		
    //         }
    //         catch (PDOException $err) {
    //             $err->getMessage();
    //             return Model::ERROR;
    //         }
    //     }

    function change_password() {}

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
?>