<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit();
}
include '../includes/conexion.php';

require '../includes/PHPMailer/src/PHPMailer.php';
require '../includes/PHPMailer/src/SMTP.php';
require '../includes/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id = $_GET['id'];
$contacto = $conn->query("SELECT * FROM contactos WHERE id = $id")->fetch_assoc();
$recomendaciones = $conn->query("SELECT * FROM recomendaciones ORDER BY fecha_registro DESC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $respuesta = $_POST['respuesta'];
  $para = $contacto['email'];
  $asunto = "Respuesta a tu mensaje - Santuario de Las Lajas";

  $mensaje = "Hola " . $contacto['nombre'] . ",\n\n";
  $mensaje .= "Gracias por contactarnos. A continuación, te respondemos:\n\n";
  $mensaje .= $respuesta;
  $mensaje .= "\n\nAtentamente,\nEquipo del Santuario de Las Lajas";

  $mail = new PHPMailer(true);

  try {
    // Configuración SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'iachatgpttesting@gmail.com';
    $mail->Password = 'tzdiqgfbqdmsddyk';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    
    // Configuración SSL para Docker
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => true,
            'verify_peer_name' => true,
            'allow_self_signed' => false,
            'cafile' => '/etc/ssl/certs/ca-certificates.crt'
        )
    );
    
    // Configuración del correo
    $mail->setFrom('iachatgpttesting@gmail.com', 'Santuario de Las Lajas');
    $mail->addAddress($para, $contacto['nombre']);
    $mail->isHTML(false);
    $mail->Subject = $asunto;
    $mail->Body = $mensaje;
    $mail->CharSet = 'UTF-8';
    
    // Debug (sólo para desarrollo)
    // $mail->SMTPDebug = 2;
    // $mail->Debugoutput = function($str, $level) { echo "debug level $level; message: $str"; };
    
    $mail->send();
    
    // Actualizar estado en la base de datos
    $conn->query("UPDATE contactos SET respondido = 1 WHERE id = $id");
    
    echo "<script>alert('Correo enviado correctamente.'); window.location.href = '../admin/modules/modulo_contactos.php';</script>";
    exit();
  } catch (Exception $e) {
    echo "<script>alert('Error al enviar el correo: " . addslashes($mail->ErrorInfo) . "');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responder contacto</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .modal { display: none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.5); z-index: 20; }
    .modal-content { background: white; margin: 10% auto; padding: 20px; width: 90%; max-width: 600px; border-radius: 10px; }
  </style>
</head>
<body class="bg-green-50 min-h-screen p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold text-green-700 mb-4">✉️ Responder a <?php echo htmlspecialchars($contacto['nombre']); ?></h1>

    <form method="POST" action="#" class="space-y-4">
      <p><strong>Email:</strong> <?php echo $contacto['email']; ?></p>
      <p><strong>Mensaje:</strong> <?php echo htmlspecialchars($contacto['mensaje']); ?></p>

      <textarea name="respuesta" id="respuesta" placeholder="Escribe tu respuesta..." class="w-full border p-3 rounded h-40"></textarea>

      <button type="button" onclick="abrirModal()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        Añadir Recomendación
      </button>

      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
        Enviar Respuesta
      </button>
    </form>

    <div class="mt-6">
      <a href="../admin/modules/modulo_contactos.php" class="text-green-700 hover:underline">← Volver</a>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <h2 class="text-xl font-bold mb-4">📌 Recomendaciones</h2>
      <div class="space-y-2 max-h-64 overflow-y-auto">
        <?php while($r = $recomendaciones->fetch_assoc()): ?>
          <label class="flex items-start gap-2">
            <input type="checkbox" class="reco-checkbox mt-1" data-content="<?php
              echo '* ' . htmlspecialchars($r['nombre_entidad']) . ' (' . $r['tipo_entidad'] . ')\n' .
              'Dirección: ' . $r['direccion'] . '\n' .
              'Email: ' . $r['correo'] . '\n' .
              'Tel: ' . $r['telefono'] .
              (!empty($r['descripcion']) ? '\n' . $r['descripcion'] : '');
            ?>" />
            <span><?php echo htmlspecialchars($r['nombre_entidad']) . " (" . $r['tipo_entidad'] . ")"; ?></span>
          </label>
        <?php endwhile; ?>
      </div>

      <div class="flex justify-end gap-4 mt-6">
        <button onclick="seleccionarTodo()" class="text-sm text-gray-700 bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">Seleccionar todo</button>
        <button onclick="añadirSeleccionados()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Añadir lo seleccionado</button>
        <button onclick="cerrarModal()" class="text-red-600 hover:underline">Cancelar</button>
      </div>
    </div>
  </div>

<script>
  function abrirModal() {
    document.getElementById("modal").style.display = "block";
  }

  function cerrarModal() {
    document.getElementById("modal").style.display = "none";
  }

  function seleccionarTodo() {
    let texto = "";
    document.querySelectorAll(".reco-checkbox").forEach(cb => {
      cb.checked = true;
      texto += cb.dataset.content.replace(/\\n/g, "\n") + "\n\n";
    });
    document.getElementById("respuesta").value += "\n\n" + texto;
    cerrarModal();
  }

  function añadirSeleccionados() {
    let texto = "";
    document.querySelectorAll(".reco-checkbox:checked").forEach(cb => {
      texto += cb.dataset.content.replace(/\\n/g, "\n") + "\n\n";
    });
    document.getElementById("respuesta").value += "\n\n" + texto;
    cerrarModal();
  }
</script>
</body>
</html>
