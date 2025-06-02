<?php
$host = "bd";
$user = "usuario";
$password = "1234";
$db = "santuario_web";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}


