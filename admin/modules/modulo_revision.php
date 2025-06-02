<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit();
}
include '../../includes/conexion.php';

$estado_actual = isset($_GET['estado']) ? $_GET['estado'] : 'en_espera';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['estado']) && isset($_POST['comentario_id'])) {
    $estado = $_POST['estado'];
    $id = $_POST['comentario_id'];
    $conn->query("UPDATE comentarios SET estado='$estado' WHERE id=$id");
  }
  if (isset($_POST['eliminar'])) {
    $id = $_POST['comentario_id'];
    $conn->query("DELETE FROM comentarios WHERE id=$id");
  }
}

$comentarios = $conn->query("SELECT * FROM comentarios WHERE estado='$estado_actual' ORDER BY fecha DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestión de Comentarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-50 min-h-screen p-6">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-yellow-700">📝 Revisión de Comentarios</h1>
    <div class="flex gap-4 mb-6">
      <a href="?estado=en_espera" class="px-4 py-2 rounded font-medium 
        <?= $estado_actual == 'en_espera' ? 'bg-yellow-600 text-white' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' ?>">
        En espera
      </a>
      <a href="?estado=aprobado" class="px-4 py-2 rounded font-medium 
        <?= $estado_actual == 'aprobado' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' ?>">
        Aprobados
      </a>
      <a href="?estado=rechazado" class="px-4 py-2 rounded font-medium 
        <?= $estado_actual == 'rechazado' ? 'bg-red-600 text-white' : 'bg-red-100 text-red-700 hover:bg-red-200' ?>">
        Rechazados
      </a>
    </div>

    <?php while($c = $comentarios->fetch_assoc()): ?>
      <form method="POST" class="border p-4 rounded mb-4 shadow bg-gray-50">
        <p class="mb-2 text-gray-800 font-medium">"<?php echo htmlspecialchars($c['comentario']); ?>"</p>
        <p class="text-sm text-gray-500 mb-2">– <?php echo htmlspecialchars($c['nombre']) . ', ' . htmlspecialchars($c['pais']); ?></p>
        <input type="hidden" name="comentario_id" value="<?php echo $c['id']; ?>" />

        <select name="estado" class="border p-2 rounded">
          <option value="en_espera" <?= $c['estado'] == 'en_espera' ? 'selected' : '' ?>>En espera</option>
          <option value="aprobado" <?= $c['estado'] == 'aprobado' ? 'selected' : '' ?>>Aprobado</option>
          <option value="rechazado" <?= $c['estado'] == 'rechazado' ? 'selected' : '' ?>>Rechazado</option>
        </select>
        
        <!-- Botón de Actualizar (siempre visible) -->
        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 transition">Actualizar</button>
        
        <!-- Botón de Eliminar (solo visible en Rechazados) -->
        <?php if ($estado_actual == 'rechazado'): ?>
          <button type="submit" name="eliminar" value="1" onclick="return confirm('¿Eliminar este comentario?')" 
            class="ml-2 bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 transition">
            Eliminar
          </button>
        <?php endif; ?>
      </form>
    <?php endwhile; ?>

    <div class="mt-6">
      <a href="../dashboard.php" class="text-yellow-700 hover:underline">← Volver al panel</a>
    </div>
  </div>
</body>
</html>