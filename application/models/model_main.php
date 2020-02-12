<?php
session_start();
class Model_main extends Model {
    public function get_data() {
        require_once "config/database.php";
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = 'SELECT * FROM post_img ORDER BY Creation_Date DESC';
        $sql = $pdo->prepare($sql);
        $sql->execute();
        $data = $sql->fetchAll();
        if (isset($_SESSION['login'])) {
            $sql = 'SELECT Post_ID FROM likes WHERE User_ID = ?';
            $sql = $pdo->prepare($sql);
            $sql->execute(array($_SESSION['id']));
            $userdata = $sql->fetchAll();
            if ($userdata != NULL)
                $data = $this->get_data_user($data, $userdata, 'like_post');
            else
                $data['like_post'] = NULL;
            $sql = 'SELECT * FROM comments';
            $sql = $pdo->prepare($sql);
            $comments = $sql->fetchAll();
            if ($comments != NULL)
                $data = $this->get_data_user($data, $userdata, 'comments');
            else
                $data['comments'] = NULL;
        }
        return($data);
    }

    public function get_data_user($data, $userdata, $name){
        array_push($data, $userdata);
        $count = count($data) - 1;
        foreach ($data as $key=> $value) {
            if ($key === $count)
                $newdata[$name] = $value;
            else
                $newdata[$key] = $value;
        }
        return($newdata);
    }

    public function change_likes($param) {
        require_once "config/database.php";
        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            $value = explode('_', $param);
            $pdo = new PDO($dsn, $db_user, $db_password, $options);
            $pdo->exec('USE camagru_db');
            if($value[1] === 'like') {
                $sql = 'UPDATE post_img SET `Likes`=`Likes` + 1 WHERE `Post_ID`=?';
                $sql = $pdo->prepare($sql);
                $sql->execute(array($value[0]));
                $sql = 'INSERT INTO `likes` (`Post_ID`,`User_ID`) VALUES (?, ?)';
                $sql = $pdo->prepare($sql);
                $value[1] = $_SESSION['id'];
                $sql->execute($value);
                $sql = "SELECT 'e-mail' FROM users WHERE `login`=?";
				$stmt->execute(array($login));
                $hello = $stmt->fetch();
                $email = $hello['e-mail'];
                echo $email;
                $this->notification_email($email);
            }
            else {
                $sql = 'UPDATE post_img SET `Likes`=`Likes` - 1 WHERE `Post_ID`=?';
                $sql = $pdo->prepare($sql);
                $sql->execute(array($value[0]));
                $sql = 'DELETE FROM likes WHERE `Post_ID`=? AND `User_ID`=?';
                $sql = $pdo->prepare($sql);
                $value[1] = $_SESSION['id'];
                $sql->execute($value);
            }
        }
    }

    public function change_comments($param) {
        require_once "config/database.php";
        if (isset($_SESSION['login'])) {
            $value = explode('_', $param);
            $pdo = new PDO($dsn, $db_user, $db_password, $options);
            $pdo->exec('USE camagru_db');
            $sql = 'SELECT * FROM comments post_img SET `Likes` = `Likes` + 1 WHERE `Login` = ?';
            $sql = $pdo->prepare($sql);
            $sql->execute(array($value[0]));
            $sql = 'INSERT INTO `comments` (`Post_ID`, `Login`, `Comment`) VALUES (?, ?, ?)';
            $login = $_SESSION['login'];
            $sth = $pdo->prepare($sql);
            $sth->execute(array($value[0], $login, $value[1]));
        }
    }

    public function notification_email($email) {
		include "config/database.php";
		$subject 	= "Checkout the latest actions in your pofile";
		$body 		= "Hi, " . $login . "!" . "\r\n" . "Checkout the latest actions in your pofile!" . "\r\n\n" . "Cheers," . "\r\n" . "Camagru";
		$header 	= "From: notification@camagru.com";
					"CC: notification@camagru.com";
		if (mail($email, $subject, $body, $header)) 
			return Model::SUCCESS;
		return Model::ERROR;
	}
}