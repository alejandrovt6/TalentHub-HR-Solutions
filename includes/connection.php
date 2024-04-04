<?php

// Connection
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'talenthub';

$db = mysqli_connect($server, $username, $password, $database);

mysqli_query($db, "SET NAMES 'utf8'");

if(!isset($_SESSION)) {
    session_start();
}