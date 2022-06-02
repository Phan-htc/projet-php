<?php

$bdd = 'tp_mysql';
$host = 'localhost';
$user = 'charbila';
$pwd = '12345';
$port = 3306;
try {
    return $cnx = new PDO(
        "mysql:host=" . $host . ";port=" . $port . ";dbname=" . $bdd . ";charset=utf8",
        $user,
        $pwd,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    ); // Erreur mode = Description Exception (Debug)
} catch (exception $ex) {
    die("Erreur -> " . $ex->getMessage());
}