<?php
include '../includes/conexion.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$fecha_visita = $_POST['fecha_visita'];
$mensaje = $_POST['mensaje'];

$sql = "INSERT INTO contactos (nombre, apellido, email, fecha_visita, mensaje)
        VALUES ('$nombre', '$apellido', '$email', '$fecha_visita', '$mensaje')";

if ($conn->query($sql) === TRUE) {
  header('Location: ../index.php');
  echo "Contacto enviado correctamente";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
