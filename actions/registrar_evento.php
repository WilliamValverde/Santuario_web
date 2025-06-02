<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: ../../public/login.php');
  exit();
}
include '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'];
  $fecha_evento = $_POST['fecha_evento'];
  $imagen = $_POST['imagen'];

  $conn->query("INSERT INTO eventos (titulo, descripcion, fecha_evento, imagen)
                VALUES ('$titulo', '$descripcion', '$fecha_evento', '$imagen')");

  header('Location: ../admin/modules/modulo_eventos.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registrar Evento</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen p-6">
  <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-blue-700 mb-6">➕ Registrar nuevo evento</h1>

    <form method="POST" class="grid gap-4">
      <input type="text" name="titulo" placeholder="Título del evento" required class="border p-3 rounded" />
      <textarea name="descripcion" placeholder="Descripción" required class="border p-3 rounded h-24 resize-none"></textarea>
      <input type="date" name="fecha_evento" required class="border p-3 rounded" />
      <input type="text" name="imagen" placeholder="URL de imagen (opcional)" class="border p-3 rounded" />
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition w-fit">Guardar evento</button>
    </form>

    <div class="mt-6 text-center">
      <button onclick="window.location.href='../admin/modules/modulo_eventos.php'" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
        ← Volver a gestión de eventos
      </button>
    </div>
  </div>
</body>
</html>
