<?php
include "admin/classes/Database.php";
$db = new Database();
$con = $db->connect();
session_start();
if ($_POST) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $result = mysqli_query($con, "SELECT idusuario,
        nombres,
        apellidos,
        email,
        clave,
        idrol,
        lugar_entraga,
        estado
    FROM usuario 
    WHERE estado=1 and  email = '" . $usuario . "' ");
    if ($row = mysqli_fetch_array($result)) {

        if (password_verify($contrasena, $row['clave'])) {
            $_SESSION['idusuario'] = $row['idusuario'];
            $_SESSION['nombres'] = $row['nombres'];
            $_SESSION['idrol'] = $row['idrol'];
            //$_SESSION['idempresa'] = $row['idempresa'];
            echo "<script language='javascript'>window.location='pages/principal.php'</script>;";
        } else {
            $errormsg = "Contraseña incorrecta";
        }
    } else {
        $errormsg = "Errror: Usuario y o contraseña incorrecta ";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login | Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="pages/css/tailwind.min.css"></script>

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 relative overflow-hidden">

        <!-- Decoración -->
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-cyan-100 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-cyan-50 rounded-full"></div>

        <!-- Header -->
        <div class="relative text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-cyan-100 rounded-2xl 
                  flex items-center justify-center mb-4 
                  text-cyan-600 text-3xl shadow">
                🛒
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Bienvenido</h1>
            <p class="text-slate-500 text-sm mt-2">
                Ingresa tus credenciales para continuar
            </p>
        </div>

        <!-- ALERTA ERROR -->
        <?php if (!empty($errormsg)): ?>
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 
                  text-sm rounded-xl p-3 text-center animate-pulse">
                <?= htmlspecialchars($errormsg) ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" autocomplete="off" novalidate class="space-y-5">

            <!-- Usuario -->
            <div>
                <label class="text-slate-600 text-sm mb-1 block">Email / Usuario</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-cyan-600">
                        👤
                    </span>
                    <input type="text" name="usuario" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl 
                   bg-slate-50 text-slate-800 
                   border border-slate-300 
                   focus:outline-none focus:ring-2 
                   focus:ring-cyan-500/40 focus:border-cyan-500
                   transition-all"
                        placeholder="correo@ejemplo.com">
                </div>
            </div>

            <!-- Contraseña -->
            <div>
                <label class="text-slate-600 text-sm mb-1 block">Contraseña</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-cyan-600">
                        🔑
                    </span>

                    <input id="password" type="password" name="contrasena" required
                        class="w-full pl-10 pr-12 py-3 rounded-xl 
                   bg-slate-50 text-slate-800 
                   border border-slate-300 
                   focus:outline-none focus:ring-2 
                   focus:ring-cyan-500/40 focus:border-cyan-500
                   transition-all"
                        placeholder="••••••••">

                    <!-- Toggle -->
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-cyan-600">
                        👁️
                    </button>
                </div>
            </div>

            <!-- Botón -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-cyan-600 to-cyan-500 
               hover:from-cyan-700 hover:to-cyan-600
               text-white font-semibold py-3 rounded-xl 
               transition-all duration-300 
               shadow-lg hover:shadow-xl
               active:scale-95">
                🔓 Ingresar
            </button>

            <!-- Links -->
            <div class="text-center text-base text-slate-600 mt-4">
                <p class="mb-2">
                    ¿No tienes cuenta?
                </p>

                <a href="registrar.php"
                    class="inline-block w-full bg-cyan-50 border border-cyan-200 
                    text-cyan-700 font-bold py-3 rounded-xl 
                    hover:bg-cyan-100 transition shadow-sm">
                    📝 Crear cuenta GRATIS
                </a>
            </div>

            <div class="text-center mt-5">
                <a href="pages/presentacion.php"
                    class="inline-block w-full bg-slate-50 border border-slate-200 
                    text-slate-600 font-semibold py-3 rounded-xl 
                    hover:bg-slate-100 transition">
                    🛒 Ver productos sin iniciar sesión
                </a>
            </div>


        </form>

        <!-- Footer -->
        <p class="text-center text-slate-400 text-xs mt-8">
            © 2026 - Sistema Profesional
        </p>

    </div>

    <!-- JS -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>