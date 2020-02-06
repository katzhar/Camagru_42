<?php
class Model_main extends Model
{
    public function get_data()
    {
        require_once "config/database.php";
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
        $pdo->exec('USE camagru_db');
        $sql = 'SELECT User_ID, Post_ID, Image, Message, Creation_Date
        FROM post_img ORDER BY Creation_Date DESC';
        $sql = $pdo->prepare($sql);
        $sql->execute();
        $data = $sql->fetchAll();
        return($data);
    }
}