<?php

$host = '127.0.0.1';
$port = 3306;
$db   = 'laguingettedevilledubert';
$user = 'root';
$pass = 'root';


$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";

try {

    $connexion = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion :" . $e->getMessage());
}
