<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Administrativo</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="max-w-5xl w-full p-8 bg-white shadow-xl rounded-xl">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-blue-700">Panel de Administración</h1>
      <button onclick="window.location.href='../public/logout.php'" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm transition">
        Cerrar sesión
      </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <a href="modules/modulo_eventos.php" class="bg-blue-100 hover:bg-blue-200 transition p-6 rounded-lg shadow text-center font-semibold text-blue-800">🗓️ Gestionar Eventos</a>
      <a href="modules/modulo_revision.php" class="bg-yellow-100 hover:bg-yellow-200 transition p-6 rounded-lg shadow text-center font-semibold text-yellow-800">📝 Revisar Comentarios</a>
      <a href="modules/modulo_contactos.php" class="bg-green-100 hover:bg-green-200 transition p-6 rounded-lg shadow text-center font-semibold text-green-800">📨 Responder Contactos</a>
      <a href="modules/modulo_recomendaciones.php" class="bg-purple-100 hover:bg-purple-200 transition p-6 rounded-lg shadow text-center font-semibold text-purple-800">🏨 Añadir Recomendaciones</a>
    </div>
    <div class="text-center mt-10">
      <button onclick="window.location.href='../index.php'" class="mt-4 bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
        Volver al sitio web
      </button>
    </div>
  </div>
</body>
</html>
