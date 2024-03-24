<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "sm_1";

// $servername = "119.46.163.140";
// $username = "mtts-db";
// $password = "Mzk@b686@2";
// $dbname = "mtts-db";

try {
    $PDOconn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
    $PDOconn->exec("SET CHARACTER SET utf8");
    $PDOconn->exec("set names utf8");
    $PDOconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fail to connect database" . $e->getMessage();
}