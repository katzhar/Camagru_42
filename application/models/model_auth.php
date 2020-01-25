<?php
class Model_Auth extends Model {
    public function auth($login, $passwd) {
        if (!$login || !$passwd) {
            return false;
        }
        $users_db = unserialize(file_get_contents('../private/passwd'));
        foreach ($users_db as $key => $user) {
            if ($user['login'] === $login && $user['password'] === hash('whirlpool', $passwd)) {
                return true;
            }
        }
        return false;
    }
    public function login() {
        if ($_POST['login'] && $_POST['password'] && auth($_POST['login'], $_POST['password'])) {
            $_SESSION['loggued_on_user'] = $_POST['login'];
            return "OK";
        } 
        else {
            $_SESSION['loggued_on_user'] = "";
            return "ERROR";
        }
    }
}



