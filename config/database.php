<?php
require_once 'config/setup.php';
$db_name = "camagru_db";
$db_hostname = "172.17.0.3";
$db_user = "root";
$db_password = "root";
$db_charset = "utf8_general_ci";

#mysql container's ip
$dsn = "mysql:host=172.17.0.3;dbname=" . $db_name;"charset=" . $db_charset;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

<<<<<<< HEAD
$host = "localhost:8080";
=======
$host = "at-k8.21-school.ru:8080";
>>>>>>> 4cfc45e20e77fc38ff5ba1e0555d549043490b4e
