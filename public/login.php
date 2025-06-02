<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio de sesión - Administrador</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-sky-100 to-blue-200 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md">
    <div class="text-center mb-6">
      <h1 class="text-3xl font-bold text-blue-700">Panel Administrativo</h1>
      <p class="text-sm text-gray-500">Ingrese sus credenciales para acceder</p>
    </div>
    <form action="../admin/admin_login.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-sm mb-1 font-medium text-gray-700">Correo electrónico</label>
        <input type="email" name="email" placeholder="admin@santuario.com" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label class="block text-sm mb-1 font-medium text-gray-700">Contraseña</label>
        <input type="password" name="password" placeholder="••••••••" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
        Iniciar sesión
      </button>
    </form>
    <div class="text-center mt-6">
      <a href="../index.php">
      <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
        Volver al sitio web
      </button>
      </a>
    </div>
  </div>

</body>
</html>
