<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: ../../public/login.php');
  exit();
}
include '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_POST['nombre_entidad'];
  $tipo = $_POST['tipo_entidad'];
  $direccion = $_POST['direccion'];
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];
  $descripcion = $_POST['descripcion'];

  $conn->query("INSERT INTO recomendaciones (nombre_entidad, tipo_entidad, direccion, correo, telefono, descripcion)
                VALUES ('$nombre', '$tipo', '$direccion', '$correo', '$telefono', '$descripcion')");

  header('Location: ../admin/modules/modulo_recomendaciones.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registrar Recomendación</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-50 min-h-screen p-6">
  <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-purple-700 mb-6">➕ Registrar una nueva entidad</h1>

    <form method="POST" class="grid gap-4">
      <input type="text" name="nombre_entidad" placeholder="Nombre de la entidad" required class="border p-3 rounded" />
      <select name="tipo_entidad" required class="border p-3 rounded">
        <option value="">-- Tipo de entidad --</option>
        <option value="Hotel">Hotel</option>
        <option value="Restaurante">Restaurante</option>
        <option value="Agencia de viajes">Agencia de viajes</option>
        <option value="Otro">Otro</option>
      </select>
      <input type="text" name="direccion" placeholder="Dirección" required class="border p-3 rounded" />
      <input type="email" name="correo" placeholder="Correo electrónico" required class="border p-3 rounded" />
      <input type="text" name="telefono" placeholder="Teléfono" required class="border p-3 rounded" />
      <textarea name="descripcion" placeholder="Descripción (opcional)" class="border p-3 rounded h-24 resize-none"></textarea>
      <button type="submit" class="bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700 transition w-fit">Guardar recomendación</button>
    </form>

    <div class="mt-6 text-center">
      <button onclick="window.location.href='../admin/modules/modulo_recomendaciones.php'" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
        ← Volver al módulo
      </button>
    </div>
  </div>
</body>
</html>
