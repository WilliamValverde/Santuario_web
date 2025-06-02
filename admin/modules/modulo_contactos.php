<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit();
}
include '../../includes/conexion.php';

$contactos = $conn->query("SELECT * FROM contactos WHERE respondido = 0 ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contactos sin responder</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-green-700">📨 Contactos sin responder</h1>

    <?php while($c = $contactos->fetch_assoc()): ?>
      <div class="border p-4 rounded mb-4 shadow bg-gray-50">
        <p class="font-semibold text-gray-800">De: <?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido']); ?></p>
        <p class="text-sm text-gray-500 mb-2">Email: <?php echo $c['email']; ?> | Visita: <?php echo $c['fecha_visita']; ?></p>
        <p class="text-gray-700 mb-3">Mensaje: <?php echo htmlspecialchars($c['mensaje']); ?></p>
        <a href="../../actions/responder_contacto.php?id=<?php echo $c['id']; ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Responder</a>
      </div>
    <?php endwhile; ?>

    <div class="mt-6">
      <a href="../dashboard.php" class="text-green-700 hover:underline">← Volver al panel</a>
    </div>
  </div>
</body>
</html>
