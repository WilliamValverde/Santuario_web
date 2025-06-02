<?php
include '../includes/conexion.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$pais = $_POST['pais'];
$comentario = $_POST['comentario'];

$sql = "INSERT INTO comentarios (nombre, apellido, email, pais, comentario)
        VALUES ('$nombre', '$apellido', '$email', '$pais', '$comentario')";

if ($conn->query($sql) === TRUE) {
  header('Location: ../index.php');
  echo "Comentario enviado con éxito";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
