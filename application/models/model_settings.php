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
            $get_email = "SELECT `e-mail` FROM users WHERE login=?";
            $stmt = $dbh->prepare($get_email);
            $stmt->execute($arr);
            $data = $stmt->fetch();
            $_SESSION['email'] = $data['e-mail'];
            return Model::SUCCESS;
        }
        catch (PDOException $err) {
            $err->getMessage();
            return Model::ERROR;
        }
    }

    function change_login() {
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

    function change_email() {
        include "config/database.php";
        $email = $_SESSION['email'];
        $email_new = $_POST['email_new'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
                $query = "UPDATE users SET `e-mail`=? WHERE `e-mail`=?";
                $stmt = $dbh->prepare($query);
                $stmt->execute(array($email_new, $email));
                $data = $stmt->fetch();
                $_SESSION['email'] = $email_new;
                $_SESSION['message'] = "YOUR E-MAIL HAS BEEN CHANGED SUCCESSFULLY";
                header('location: ../settings/changeemail');
                exit();
                return Model::SUCCESS;
            }
            catch (PDOException $err) {
                $err->getMessage();
                return Model::ERROR;
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
                    $arr = array($password, $login);
                    $this->add_info_to_db($dbh, $sql_getpas, $arr);
                    $_SESSION['password'] = $password_new;
                    $_SESSION['message'] = "YOUR PASSWORD HAS BEEN CHANGED SUCCESSFULLY";
                    header('location: ../settings/changepassword');
                    exit();
                    return Model::SUCCESS;    
                }
            }
            catch (PDOException $err) {
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
}
?>