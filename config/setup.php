<?php 
include "database.php";
try {
    $pdo = new PDO($dsn, $db_user, $db_password);
    $pdo->exec('CREATE DATABASE IF NOT EXISTS camagru_db CHARACTER SET utf8 COLLATE utf8_general_ci;');
    $pdo->exec('USE camagru_db');

} catch (PDOException $err) {
    $err->getMessage();
}
try {
        $users_table = "CREATE TABLE IF NOT EXISTS users 
                (`User_ID` INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
                `e-mail` VARCHAR(255) NOT NULL, 
                `login` VARCHAR(255) NOT NULL, 
                `password` VARCHAR(255) DEFAULT NULL,
                `unique_link` VARCHAR(255) DEFAULT NULL,
                `reset_link` VARCHAR(255) DEFAULT NULL,
                `verified` INT NOT NULL DEFAULT '0')";
    $pdo->exec($users_table);
}
catch(PDOException $err) {
       $err->getMessage();
}

try {
        $post_table = "CREATE TABLE IF NOT EXISTS post_img
                (`User_ID` INT UNSIGNED NOT NULL,
                `Post_ID` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                `Image` VARCHAR(32) NOT NULL,
                `Message` VARCHAR(128),
                `Likes` INT UNSIGNED DEFAULT 0 NOT NULL,
                `Creation_Date` DATETIME DEFAULT NOW() NOT NULL)";
    $pdo->exec($post_table);
} 
catch (PDOException $err) {
        $err->getMessage();
}

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS likes 
                (`Post_ID` INT UNSIGNED  NOT NULL,
                `User_ID` INT UNSIGNED NOT NULL)");
}
catch(PDOException $err) {
        $err->getMessage();
}

try {
    $comments_table = "CREATE TABLE IF NOT EXISTS comments
                (`id` INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
                `Login` VARCHAR(255) NOT NULL,
                `Post_ID` INT UNSIGNED DEFAULT NULL,
                `Comment` VARCHAR(255))";
    $pdo->exec($comments_table);
}
catch(PDOException $err) {
    $err->getMessage();
}
try {
    $pdo->exec('CREATE TABLE IF NOT EXISTS `tmp_img`
    (id INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
    `User_file` BIT DEFAULT 0 ,
    `User_ID` INT UNSIGNED NOT NULL,
    `Image` VARCHAR(32) NOT NULL)');
} catch (PDOException $err) {
    echo 'ERROR creating table tmp_img' . $err->getMessage();

}
