<?php
$host = 'localhost:3306';
$root = 'root';
$pass = '';
$bd = 'amictus';
$servidor = 'mysql:dbname=' . $bd . ';host=' . $host . ';';
try {
    $pdo = new PDO($servidor, $root, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Error: ' . $e;
}
