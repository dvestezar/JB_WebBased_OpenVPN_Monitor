<?php
define('VersioN','2.0.0');
include 'config.php';
include 'lib/php/init.php';

$app=new class_crossroad();
/*
$app->ht = jbhtml class
$app->cnf = config class
$app->openVPN = Open VPN class

$app->cmd = default comand from request named 's'
*/
$app->where($cmd);
?>
