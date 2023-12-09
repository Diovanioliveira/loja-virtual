<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "loja_virtual";

$pdo = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);