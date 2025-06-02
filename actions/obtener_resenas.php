
<?php
include 'conexion.php';

$sql = "SELECT nombre, pais, comentario FROM comentarios 
        WHERE estado = 'aprobado' 
        ORDER BY fecha DESC LIMIT 3";

$result = $conn->query($sql);
$resenas = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $resenas[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($resenas);

$conn->close();
?>
