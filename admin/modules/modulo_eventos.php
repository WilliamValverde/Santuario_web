<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: ../../public/login.php');
  exit();
}
include '../../includes/conexion.php';

if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  $conn->query("DELETE FROM eventos WHERE id = $id");
  header('Location: modulo_eventos.php');
  exit();
}

if (isset($_POST['editar'])) {
  $id = intval($_POST['id']);
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'];
  $fecha_evento = $_POST['fecha_evento'];
  $imagen = $_POST['imagen'];
  $conn->query("UPDATE eventos SET titulo='$titulo', descripcion='$descripcion', fecha_evento='$fecha_evento', imagen='$imagen' WHERE id=$id");
  header('Location: modulo_eventos.php');
  exit();
}

$eventos = $conn->query("SELECT * FROM eventos ORDER BY fecha_evento ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestión de Eventos</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleEditar(id) {
      document.getElementById('editar-' + id).classList.toggle('hidden');
    }
  </script>
</head>
<body class="bg-blue-50 min-h-screen p-6">
  <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-blue-700">🗓️ Gestión de Eventos</h1>
      <button onclick="window.location.href='../../actions/registrar_evento.php'" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        Registrar Evento
      </button>
    </div>

    <h2 class="text-xl font-semibold mb-6 text-gray-800">Eventos registrados</h2>
    <div class="space-y-6">
      <?php while($e = $eventos->fetch_assoc()): ?>
        <div class="border rounded p-4 shadow bg-gray-50">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="font-bold text-lg text-blue-800"><?php echo htmlspecialchars($e['titulo']); ?></h3>
              <p class="text-sm text-gray-700 mb-1"><?php echo htmlspecialchars($e['descripcion']); ?></p>
              <p class="text-xs text-gray-500">📅 <?php echo $e['fecha_evento']; ?></p>
            </div>
            <div class="text-right">
              <button onclick="toggleEditar(<?php echo $e['id']; ?>)" class="text-blue-600 hover:underline text-sm">Editar</button>
              <a href="?eliminar=<?php echo $e['id']; ?>" onclick="return confirm('¿Eliminar este evento?')" class="text-red-600 hover:underline text-sm ml-2">Eliminar</a>
            </div>
          </div>
          <form method="POST" id="editar-<?php echo $e['id']; ?>" class="grid gap-3 mt-4 hidden bg-white p-4 rounded shadow">
            <input type="hidden" name="editar" value="1" />
            <input type="hidden" name="id" value="<?php echo $e['id']; ?>" />
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($e['titulo']); ?>" required class="border p-2 rounded" />
            <textarea name="descripcion" required class="border p-2 rounded h-20"><?php echo htmlspecialchars($e['descripcion']); ?></textarea>
            <input type="date" name="fecha_evento" value="<?php echo $e['fecha_evento']; ?>" required class="border p-2 rounded" />
            <input type="text" name="imagen" value="<?php echo $e['imagen']; ?>" class="border p-2 rounded" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Actualizar</button>
          </form>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="mt-10 text-center">
      <button onclick="window.location.href='../dashboard.php'" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
        ← Volver al panel
      </button>
    </div>
  </div>
</body>
</html>
