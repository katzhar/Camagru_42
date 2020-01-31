<?php 
include "database.php";
$dbh = new PDO($dsn, $db_user, $db_password, $options);
$dbh->exec('CREATE DATABASE IF NOT EXISTS camagru_db CHARACTER SET utf8 COLLATE utf8_general_ci');
$dbh->exec('USE camagru_db');

$users_table = "CREATE TABLE IF NOT EXISTS users 
(id INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
`e-mail` VARCHAR(255) NOT NULL, 
`login` VARCHAR(255) NOT NULL, 
`password` VARCHAR(255) NOT NULL,
`unique_link` VARCHAR(255) DEFAULT NULL,
`verified` INT NOT NULL DEFAULT '0')";
        
$dbh->exec($users_table);
