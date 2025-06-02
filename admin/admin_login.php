<?php
session_start();
include '../includes/conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    $_SESSION['admin'] = $row['id'];
    header('Location: ../admin/dashboard.php');
  } else {
    header('Location: ../public/login.php');
  }
} else {
}
$conn->close();
?>
