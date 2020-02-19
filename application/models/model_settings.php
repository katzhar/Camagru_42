<?php
session_start();
class Model_Settings extends Model {

    function get_email() {
        include "config/database.php";
        $login = $_SESSION['login'];
        try {
            $dbh = new PDO($dsn, $db_user, $db_password, $options);
            $dbh->exec('USE camagru_db');
            $arr = array($login);
            $sql_get_email = "SELECT `e-mail` FROM users WHERE login=?";
            $stmt = $dbh->prepare($sql_get_email);
            $stmt->execute($arr);
            $data = $stmt->fetch();
            $_SESSION['email'] = $data['e-mail'];
        }
        catch (PDOException $err) {
            $err->getMessage();
        }
    }

    function change_login() {
        include "config/database.php";
        $login = $_SESSION['login'];
        $login_new = $_POST['login_new'];
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = "SELECT * FROM users WHERE login=?";
        $sql = $pdo->prepare($sql);
        $sql->execute(array($login_new));
        $checklogin = $sql->fetch();
        if (is_numeric($login_new) or strlen($login_new) < 5) {
            $_SESSION['message'] = "YOUR USERNAME MUST CONTAIN AT LEAST 5 CHARACTERS";
           header('Location: ../settings');
            exit();
        }
        else if (stripos($login_new, ' ')) {
            $_SESSION['message'] = "YOUR USERNAME MUST NOT CONTAIN ANY SPACES";
            header('Location: ../settings');
            exit();
        }
        else if (preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',$login_new)) {
            $_SESSION['message'] = "YOUR USERNAME MUST NOT CONTAIN ANY SPECIAL CHARACTERS";
            header('Location: ../settings');
            exit();
        }
      else if ($checklogin['login'] === $login_new ){
           $_SESSION['message'] = "THIS USERNAME IS ALREADY IN USE, CHOOSE ANOTHER ONE";
           header('Location: ../settings');
           exit();
       }

        try {
            $dbh = new PDO($dsn, $db_user, $db_password, $options);
            $dbh->exec('USE camagru_db');
            $sql_getlog = "SELECT * FROM users WHERE login=?";
            $arr = array($login);
            if ($this->add_info_to_db($dbh, $sql_getlog, $arr) === Model::SUCCESS) {
                $sql_updlog = "UPDATE users SET login=? WHERE login=?";
                $arr = array($login_new, $login);
                $this->add_info_to_db($dbh, $sql_updlog, $arr);
                $_SESSION['login'] = $login_new;
                $sql_updlog_comm = "UPDATE comments SET Login=? WHERE Login=?";
                $this->add_info_to_db($dbh, $sql_updlog_comm, $arr);
                $_SESSION['message'] = "YOUR USERNAME HAS BEEN CHANGED SUCCESSFULLY";
               header('location: ../settings');
                exit();
            }	
        }
        catch (PDOException $err) {
            $err->getMessage();
        }
    }

    function change_email() {
        include "config/database.php";
        $email = $_SESSION['email'];
        $email_new = $_POST['email_new'];
        if (!filter_var($email_new, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "INVALID E-MAIL";
            header('Location: ../settings/changeemail');
            exit();
        }
        elseif ($email == $email_new) {
            $_SESSION['message'] = "YOUR NEW E-MAIL MUST BE DIFFER FROM YOUR PREVIOUS E-MAIL";
			header('Location: ../settings/changeemail');
            exit();
        }
        else {
            try {
                $dbh = new PDO($dsn, $db_user, $db_password, $options);
                $dbh->exec('USE camagru_db');
                $sql_updemail = "UPDATE users SET `e-mail`=? WHERE `e-mail`=?";
                $arr = array($email_new, $email);
                if ($this->add_info_to_db($dbh, $sql_updemail, $arr) === Model::SUCCESS) {
                    $_SESSION['email'] = $email_new;
                    $_SESSION['message'] = "YOUR E-MAIL HAS BEEN CHANGED SUCCESSFULLY";
                    header('location: ../settings/changeemail');
                    exit();
                }
            }
            catch (PDOException $err) {
                $err->getMessage();
            }
        }
    }

    function change_password() {
        include "config/database.php";
        $login = $_SESSION['login'];
        $password = $_SESSION['password'];
        $password_old = hash('whirlpool', $_POST['password_old']);
        $password_new = hash('whirlpool', $_POST['password_new']);
        $password_confirm = hash('whirlpool', $_POST['password_confirm']);
        if ($password !== $password_old) {
            $_SESSION['message'] = "WRONG PASSWORD";
            header ('Location: ../settings/changepassword');
            exit();
		}
        elseif ($password_new !== $password_confirm) {
			$_SESSION['message'] = "PASSWORDS DOESN'T MATCH";
			header('Location: ../settings/changepassword');
			exit();
        }
        else if ($_POST['password_new'] === strtolower($_POST['password_new']) or strlen($_POST['password_new']) < 4) {
			$_SESSION['message'] = "YOUR PASSWORD MUST CONTAIN AT LEAST 5 CHARACTERS AND 1 UPPERCASE LETTER";
			header('Location: ../settings/changepassword');
            exit();
        }
        elseif ($password == $password_new) {
            $_SESSION['message'] = "YOUR PASSWORD MUST BE DIFFER FROM YOUR PREVIOUS PASSWORD";
			header('Location: ../settings/changepassword');
            exit();
        }
        else {
            try {
                $dbh = new PDO($dsn, $db_user, $db_password, $options);
                $dbh->exec('USE camagru_db');
                $sql_getlog = "SELECT * FROM users WHERE `login`=?";
                $arr = array($login);
                if ($this->add_info_to_db($dbh, $sql_getlog, $arr) === Model::SUCCESS) {
                    $sql_getpas = "UPDATE users SET password=? WHERE `login`=?";
                    $arr = array($password_new, $login);
                    $this->add_info_to_db($dbh, $sql_getpas, $arr);
                    $_SESSION['password'] = $password_new;
                    $_SESSION['message'] = "YOUR PASSWORD HAS BEEN CHANGED SUCCESSFULLY";
                    header('location: ../settings/changepassword');
                    exit();
                }
            }
            catch (PDOException $err) {
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
}