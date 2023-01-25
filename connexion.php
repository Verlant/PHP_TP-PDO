<?php
$dsn = "mysql:host=localhost;dbname=collection_jeux;charset=utf8";
$username = "root"; //A changer si besoin
$password = ""; //A changer si besoin
$pdo = new PDO(
    $dsn,
    $username,
    $password,
    array(PDO::ATTR_PERSISTENT => TRUE)
);
