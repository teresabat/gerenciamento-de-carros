<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oficina";

//criar conexão

$conn = new mysqli($servername, $username, $password, $dbname);

//verificar conexão

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}