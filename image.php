<?php 
header('Content-type: image/svg+xml');
require_once 'access.php';
include_once 'bdd.php';

$req = sprintf("SELECT image FROM pays WHERE id=%d, $_GET[$id]");
$stmt = $cnx->query($req);
$res=$stmt -> fetch();
echo $res[0];
