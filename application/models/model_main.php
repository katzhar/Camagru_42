<?php
session_start();
class Model_main extends Model
{
    public function get_data()
    {
        require_once "config/database.php";
        require_once "config/setup.php";
        $param_start = 0;
        $param_val = 5;
        if(isset($_POST['number_page']))
        {
            $param_start = intval($_POST['number_page']) * 5 - 5;;
            $param_val = 5;
        }
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $count = 'SELECT COUNT(*) FROM post_img';
        $count = $pdo->prepare($count);
        $count->execute();
        $countpost = $count->fetchColumn();
        $_SESSION['count_post'] = $countpost;
        $param_page[0] = 0;
        $sql = 'SELECT users.login, post_img.* FROM post_img JOIN users  ON users.User_ID = post_img.User_ID ORDER BY Creation_Date DESC LIMIT ?, ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array(  $param_start,$param_val));
        $data = $sql->fetchAll();
        $sql = 'SELECT * FROM comments';
        $sql = $pdo->prepare($sql);
        $sql->execute();
        $comments = $sql->fetchAll();
        if ($comments != NULL)
            $data = $this->get_data_usercom($data, $comments, 'comments');
        else
            $data['comments'] = NULL;
        if (isset($_SESSION['login'])) {
            $sql = 'SELECT Post_ID FROM likes WHERE User_ID = ?';
            $sql = $pdo->prepare($sql);
            $sql->execute(array($_SESSION['id']));
            $userdata = $sql->fetchAll();
            if ($userdata != NULL)
                $data = $this->get_data_user($data, $userdata, 'like_post');
            else
                $data['like_post'] = NULL;
        }
        return ($data);
    }

//тут добавляется массив like
    public function get_data_user($data, $userdata, $name)
    {
        array_push($data, $userdata);
        $count = count($data) - 2;
        foreach ($data as $key => $value) {
            if ($key === $count)
                $newdata[$name] = $value;
            else
                $newdata[$key] = $value;
        }
        return ($newdata);
    }

    //тут добавляется массив сщььутеы
    public function get_data_usercom($data, $comments, $name)
    {
        array_push($data, $comments);
        $count = count($data) - 1;
        foreach ($data as $key => $value) {
            if ($key === $count)
                $newdata[$name] = $value;
            else
                $newdata[$key] = $value;
        }
        return ($newdata);
    }

    public function change_likes($param)
    {
        require_once "config/database.php";
        if (isset($_SESSION['login'])) {
            $value = explode('_', $param);
            $pdo = new PDO($dsn, $db_user, $db_password, $options);
            $pdo->exec('USE camagru_db');
            if ($value[1] === 'like') {
                $sql = 'UPDATE post_img SET `Likes`=`Likes` + 1 WHERE `Post_ID`=?';
                $sql = $pdo->prepare($sql);
                $sql->execute(array($value[0]));
                $sql = 'INSERT INTO `likes` (`Post_ID`,`User_ID`) VALUES (?, ?)';
                $sql = $pdo->prepare($sql);
                $value[1] = $_SESSION['id'];
                $sql->execute($value);
            } else {
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

    public function change_comments()
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);
        $comment = htmlspecialchars($data['comment']);
        $post_id = $data['post_id'];
        if ($comment && $post_id && $_SESSION['id']) {

            $addComment = $this->comment_db($comment, $post_id);
            if ($addComment) {
                $data['login'] = $_SESSION['login'];
                $data['comm_id'] = $addComment;
                header('Content-Type: application/json');
                echo json_encode($data);
            } else
                echo json_encode(array('error' => "Произошла ошибка"));
        }
        return true;
    }

    public function comment_db($comment, $post_id)
    {
        require_once "config/database.php";
        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            $dbh = new PDO($dsn, $db_user, $db_password, $options);
            $dbh->exec('USE camagru_db');
            $sql = 'INSERT INTO comments (`Login`, `Post_ID`, `Comment`) VALUES (?, ?, ?)';
            $arr = array($login, $post_id, $comment);
            if ($this->add_info_to_db($dbh, $sql, $arr) === Model::SUCCESS) {
                $sql = "SELECT `User_ID` FROM `post_img` WHERE `Post_ID`=?";
                $arr = array($post_id);
                $stmt = $dbh->prepare($sql);
                $stmt->execute($arr);
                $data = $stmt->fetch();
                if ($data) {
                    $id = $data['User_ID'];
                    $sql = "SELECT `e-mail` FROM `users` WHERE `User_ID`=?";
                    $arr = array($id);
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute($arr);
                    $data = $stmt->fetch();
                    if ($data) {
                        $email = $data['e-mail'];
                        $this->notification_email($email, $login);
                        //   header ('Location:/');
                    }
                }
            }
        }
        $sql = 'SELECT id FROM comments WHERE Login =? AND Comment =? AND Post_ID =?';
        $sql = $dbh->prepare($sql);
        $sql->execute(array($_SESSION['login'], $comment, $post_id));
        $data = $sql->fetch();
        return ($data['id']);
    }

    private function add_info_to_db($dbh, $sql, $arr)
    {
        try {
            $stmt = $dbh->prepare($sql);
            $stmt->execute($arr);
            return Model::SUCCESS;
        } catch (PDOException $err) {
            $err->getMessage();
            return Model::ERROR;
        }
    }

    public function notification_email($email, $login)
    {
        include "config/database.php";
        $subject = "Someone comments on your picture!";
        $body = "Hi, " . $login . "!" . "\r\n" . "Checkout the latest actions in your profile!" . "\r\n\n" . "Cheers," . "\r\n" . "Camagru";
        $header = "From: notification@camagru.com";
        "CC: notification@camagru.com";
        if (mail($email, $subject, $body, $header))
            return Model::SUCCESS;
        return Model::ERROR;
    }

    public function delete($param)
    {
        print_r($param);
        $data = explode('_', $param);
        if (!isset($data[1]))
            $this->deletepost($data[0]);
        else
            $this->deletecomments($data[0]);
    }

    public function deletepost($param)
    {
        require_once "config/database.php";
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = 'DELETE FROM post_img WHERE post_img.Post_ID = ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array($param));
        $sql = 'DELETE FROM likes WHERE likes.Post_ID = ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array($param));
        $sql = 'DELETE FROM comments WHERE comments.Post_ID = ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array($param));
    }

    public function deletecomments($param)
    {
        require_once "config/database.php";
        $param = intval($param);
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = 'DELETE FROM comments WHERE id = ?';
        $sql = $pdo->prepare($sql);
        $sql->execute(array($param));
    }
}