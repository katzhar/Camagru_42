<?php 
include "database.php";
try {
        $dbh = new PDO($dsn, $db_user, $db_password, $options);
        $dbh->exec('CREATE DATABASE IF NOT EXISTS camagru_db');
        $dbh->exec('USE camagru_db');
        echo 'DB camagru_db create succesfully';
}
catch(PDOException $err) {
        echo 'ERROR creating DB camagru_db' . $err->getMessage();
}

try {
        $dbh = new PDO($dsn, $db_user, $db_password, $options);
        $users_table = 'CREATE TABLE IF NOT EXISTS users 
                (id INT NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT, 
                `e-mail` VARCHAR(255) NOT NULL, 
                `login` VARCHAR(255) NOT NULL, 
                `password` VARCHAR(255) NOT NULL)';

        $dbh->exec($users_table);
        echo 'Table users create succesfully';
}
catch(PDOException $err) {
        echo 'ERROR creating table users' . $err->getMessage();
}

?>