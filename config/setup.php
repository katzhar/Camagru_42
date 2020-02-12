<?php 
include "database.php";
$dbh = new PDO($dsn, $db_user, $db_password, $options);
$dbh->exec('CREATE DATABASE IF NOT EXISTS camagru_db CHARACTER SET utf8 COLLATE utf8_general_ci');
$dbh->exec('USE camagru_db');

try {
        $users_table = "CREATE TABLE IF NOT EXISTS users 
<<<<<<< HEAD
                (User_ID INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
=======
                (`User_ID` INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
>>>>>>> 4cfc45e20e77fc38ff5ba1e0555d549043490b4e
                `e-mail` VARCHAR(255) NOT NULL, 
                `login` VARCHAR(255) NOT NULL, 
                `password` VARCHAR(255) DEFAULT NULL,
                `unique_link` VARCHAR(255) DEFAULT NULL,
                `reset_link` VARCHAR(255) DEFAULT NULL,
                `verified` INT NOT NULL DEFAULT '0')";
        $dbh->exec($users_table);

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
        $dbh->exec($post_table);
} 
catch (PDOException $err) {
        $err->getMessage();
}

try {
<<<<<<< HEAD
    $dbh->exec("CREATE TABLE IF NOT EXISTS likes 
                (`Post_ID` INT UNSIGNED  NOT NULL,
        `User_ID` INT UNSIGNED NOT NULL)");
}
catch(PDOException $err) {
    echo 'ERROR creating table likes' . $err->getMessage();
=======
        $dbh->exec("CREATE TABLE IF NOT EXISTS likes 
                (`Post_ID` INT UNSIGNED  NOT NULL,
                `User_ID` INT UNSIGNED NOT NULL)");
}
catch(PDOException $err) {
        $err->getMessage();
>>>>>>> 4cfc45e20e77fc38ff5ba1e0555d549043490b4e
}

try {
<<<<<<< HEAD
    $dbh->exec( "CREATE TABLE IF NOT EXISTS comments
                (id INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT,
                `Post_ID` INT UNSIGNED NOT NULL,
                `User_ID` INT UNSIGNED NOT NULL,
                `Comment` VARCHAR(128))");
}
catch(PDOException $err) {
    echo 'ERROR creating table comments' . $err->getMessage();
}
try {
    $dbh->exec('CREATE TABLE IF NOT EXISTS `tmp_img`
    (id INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
    `User_file` BIT DEFAULT 0 ,
    `User_ID` INT UNSIGNED NOT NULL,
    `Image` VARCHAR(32) NOT NULL)');
} catch (PDOException $err) {
    echo 'ERROR creating table tmp_img' . $err->getMessage();
=======
        $comments_table = "CREATE TABLE IF NOT EXISTS comments
                (`Login` VARCHAR(255) NOT NULL,
                `Post_ID` INT UNSIGNED DEFAULT NULL,
                `Comment` VARCHAR(255))";
        $dbh->exec($comments_table);
}
catch(PDOException $err) {
        $err->getMessage();
>>>>>>> 4cfc45e20e77fc38ff5ba1e0555d549043490b4e
}
