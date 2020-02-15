<?php
require_once 'config/setup.php';
$db_name = "camagru_db";
$db_host = "172.17.0.3";
$db_user = "root";
$db_password = "root";
$db_charset = "utf8";

$dsn = "mysql:host=172.17.0.3;dbname=" . $db_name;"charset=utf8";

$dsn = "mysql:host=$db_host;charset=$db_charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$host = "localhost:8080";
