<?php 
include "database.php";
$dbh = new PDO($dsn, $db_user, $db_password, $options);
try {
        $dbh->exec('CREATE DATABASE IF NOT EXISTS camagru_db CHARACTER SET utf8 COLLATE utf8_general_ci');
        $dbh->exec('USE camagru_db');
        echo 'DB camagru_db create succesfully';
}
catch(PDOException $err) {
        echo 'ERROR creating DB camagru_db' . $err->getMessage();
}

try {
        $users_table = "CREATE TABLE IF NOT EXISTS users 
                (id INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
                `e-mail` VARCHAR(255) NOT NULL, 
                `login` VARCHAR(255) NOT NULL, 
                `password` VARCHAR(255) NOT NULL,
                `unique_link` VARCHAR(255) DEFAULT NULL,
                `verified` INT NOT NULL DEFAULT '0')";
        $dbh->exec($users_table);
        echo 'table users create succesfully';

}
catch(PDOException $err) {
        echo 'ERROR creating table users' . $err->getMessage();
}
try {
    $dbh->exec('CREATE TABLE IF NOT EXISTS `post_img`
    (
        `Post_ID` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        `User_ID` INT UNSIGNED NOT NULL,
        `Image` VARCHAR(32) NOT NULL,
        `Message` VARCHAR(128),
        `Likes` INT UNSIGNED DEFAULT 0 NOT NULL,
        `Creation_Date` DATETIME DEFAULT NOW() NOT NULL
    )');
    echo 'table post_img create succesfully';

} catch (PDOException $err) {
    echo 'ERROR creating table post_img' . $err->getMessage();
}