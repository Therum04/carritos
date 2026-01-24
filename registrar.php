<?php
include "admin/classes/Database.php";
$db = new Database();
$con = $db->connect();
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombres'] ?? '');
    $apellidos   = trim($_POST['apellidos'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password2 = trim($_POST['password2'] ?? '');
    $lugar_entraga = trim($_POST['lugar_entraga'] ?? '');
    if ($nombre == '' || $email == '' || $password == '' || $password2 == '') {
        $mensaje = "❌ Todos los campos son obligatorios";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "❌ Email no válido";
    } elseif ($password !== $password2) {
        $mensaje = "❌ Las contraseñas no coinciden";
    } elseif (strlen($password) < 6) {
        $mensaje = "❌ La contraseña debe tener al menos 6 caracteres";
    } else {
        // Encriptar contraseña
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // Verificar si email ya existe
        $stmt = $con->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $mensaje = "❌ Este correo ya está registrado";
        } else {
            // Insertar usuario
            $stmt = $con->prepare("INSERT INTO usuario 
            (nombres, apellidos, email, clave, idrol, lugar_entraga, estado)
            VALUES (?, ?, ?, ?, 3, ?, 1)");
            $stmt->bind_param(
                "sssss",
                $nombre,
                $apellidos,
                $email,
                $hash,
                $lugar_entraga
            );
            if ($stmt->execute()) {
                $mensaje = "✅ Cuenta creada correctamente. Ahora puedes iniciar sesión.";
            } else {
                $mensaje = "❌ Error al registrar usuario";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar cuenta</title>
   <script src="pages/css/tailwind.min.css"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">📝 Crear cuenta</h2>

        <?php if ($mensaje): ?>
            <div class="mb-4 p-3 rounded 
            <?= str_contains($mensaje, '❌') ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nombre completo</label>
                <input type="text" name="nombres" class="w-full border rounded-lg p-3 focus:ring focus:ring-cyan-200" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Apellidos</label>
                <input type="text" name="apellidos" class="w-full border rounded-lg p-3 focus:ring focus:ring-cyan-200" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Correo electrónico</label>
                <input type="email" name="email" class="w-full border rounded-lg p-3 focus:ring focus:ring-cyan-200" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Contraseña</label>
                <input type="password" name="password" class="w-full border rounded-lg p-3 focus:ring focus:ring-cyan-200" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                <input type="password" name="password2" class="w-full border rounded-lg p-3 focus:ring focus:ring-cyan-200" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Lugar entraga</label>
                <input type="text" name="lugar_entraga" class="w-full border rounded-lg p-3 focus:ring focus:ring-cyan-200" required>
            </div>

            <button type="submit"
                class="w-full bg-cyan-600 hover:bg-cyan-700 text-white py-3 rounded-lg font-semibold transition">
                Crear cuenta
            </button>
        </form>

        <div class="mt-4 text-center text-sm">
            <a href="index.php" class="text-cyan-600 hover:text-cyan-700">
                🔐 Ya tengo cuenta, iniciar sesión
            </a>
        </div>
    </div>

</body>

</html>