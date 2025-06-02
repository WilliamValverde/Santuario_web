<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: ../../public/login.php');
  exit();
}
include '../../includes/conexion.php';

if (isset($_GET['eliminar'])) {
  $id = intval($_GET['eliminar']);
  $conn->query("DELETE FROM recomendaciones WHERE id = $id");
  header('Location: modulo_recomendaciones.php');
  exit();
}

if (isset($_POST['editar'])) {
  $id = intval($_POST['id']);
  $nombre = $_POST['nombre_entidad'];
  $tipo = $_POST['tipo_entidad'];
  $direccion = $_POST['direccion'];
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];
  $descripcion = $_POST['descripcion'];

  $conn->query("UPDATE recomendaciones SET nombre_entidad='$nombre', tipo_entidad='$tipo', direccion='$direccion',
                correo='$correo', telefono='$telefono', descripcion='$descripcion' WHERE id=$id");
  header('Location: modulo_recomendaciones.php');
  exit();
}

$recomendaciones = $conn->query("SELECT * FROM recomendaciones ORDER BY fecha_registro DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Recomendaciones</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleEditar(id) {
      const form = document.getElementById('editar-' + id);
      form.classList.toggle('hidden');
    }
  </script>
</head>
<body class="bg-purple-50 min-h-screen p-6">
  <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-purple-700">🏨 Gestión de Entidades Recomendadas</h1>
      <button onclick="window.location.href='../../actions/registrar_recomendacion.php'" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
        Añadir recomendación
      </button>
    </div>
    <div class="grid md:grid-cols-2 gap-6">
      <?php while($r = $recomendaciones->fetch_assoc()): ?>
        <div class="border rounded p-4 bg-gray-50 shadow">
          <h3 class="font-bold text-purple-800 text-lg"><?php echo htmlspecialchars($r['nombre_entidad']); ?> (<?php echo htmlspecialchars($r['tipo_entidad']); ?>)</h3>
          <p class="text-sm text-gray-700"><strong>Dirección:</strong> <?php echo htmlspecialchars($r['direccion']); ?></p>
          <p class="text-sm text-gray-700"><strong>Email:</strong> <?php echo htmlspecialchars($r['correo']); ?></p>
          <p class="text-sm text-gray-700"><strong>Teléfono:</strong> <?php echo htmlspecialchars($r['telefono']); ?></p>
          <?php if (!empty($r['descripcion'])): ?>
            <p class="text-sm text-gray-600 mt-1"><strong>Descripción:</strong> <?php echo htmlspecialchars($r['descripcion']); ?></p>
          <?php endif; ?>
          <div class="mt-2 space-x-2">
            <button onclick="toggleEditar(<?php echo $r['id']; ?>)" class="text-purple-600 hover:underline text-sm">Editar</button>
            <a href="?eliminar=<?php echo $r['id']; ?>" onclick="return confirm('¿Eliminar esta entidad?')" class="text-red-600 hover:underline text-sm">Eliminar</a>
          </div>

          <form method="POST" id="editar-<?php echo $r['id']; ?>" class="hidden mt-4 bg-white p-4 rounded shadow space-y-3">
            <input type="hidden" name="editar" value="1" />
            <input type="hidden" name="id" value="<?php echo $r['id']; ?>" />
            <input type="text" name="nombre_entidad" value="<?php echo htmlspecialchars($r['nombre_entidad']); ?>" required class="border p-2 rounded w-full" />
            <select name="tipo_entidad" class="border p-2 rounded w-full" required>
              <option <?php if ($r['tipo_entidad'] == 'Hotel') echo 'selected'; ?>>Hotel</option>
              <option <?php if ($r['tipo_entidad'] == 'Restaurante') echo 'selected'; ?>>Restaurante</option>
              <option <?php if ($r['tipo_entidad'] == 'Agencia de viajes') echo 'selected'; ?>>Agencia de viajes</option>
              <option <?php if ($r['tipo_entidad'] == 'Otro') echo 'selected'; ?>>Otro</option>
            </select>
            <input type="text" name="direccion" value="<?php echo htmlspecialchars($r['direccion']); ?>" required class="border p-2 rounded w-full" />
            <input type="email" name="correo" value="<?php echo htmlspecialchars($r['correo']); ?>" required class="border p-2 rounded w-full" />
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($r['telefono']); ?>" required class="border p-2 rounded w-full" />
            <textarea name="descripcion" class="border p-2 rounded w-full h-20"><?php echo htmlspecialchars($r['descripcion']); ?></textarea>
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">Actualizar</button>
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
