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
            $errormsg = "<center>Contraseña incorrecta</center>";
        }
    } else {
        $errormsg = "<strong>Errror:</strong> Usuario y o contraseña incorrecta <strong> ";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login | Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN -->
    <script src="pages/css/tailwind.min.css"></script>
    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-slate-100">

    <!-- Card -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        <!-- Logo / Título -->
        <div class="text-center mb-8">
            <div class="mx-auto w-14 h-14 bg-cyan-100 rounded-xl 
                  flex items-center justify-center mb-4 text-cyan-600 text-2xl">
                🔐
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Iniciar Sesión</h1>
            <p class="text-slate-500 text-sm mt-2">
                Accede a tu panel de control
            </p>
        </div>

        <!-- Formulario -->
        <form method="POST" autocomplete="off" novalidate action="<?php echo $_SERVER['PHP_SELF']; ?>" class="space-y-5">

            <!-- Usuario -->
            <div>
                <label class="text-slate-600 text-sm mb-1 block">Usuario</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        👤
                    </span>
                    <input type="text" name="usuario" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl 
                   bg-slate-50 text-slate-800 
                   border border-slate-300 
                   focus:outline-none focus:ring-2 
                   focus:ring-cyan-500/40 focus:border-cyan-500
                   transition"
                        placeholder="Ingrese su usuario">
                </div>
            </div>

            <!-- Contraseña -->
            <div>
                <label class="text-slate-600 text-sm mb-1 block">Contraseña</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        🔑
                    </span>
                    <input type="password" name="contrasena" required
                        class="w-full pl-10 pr-4 py-3 rounded-xl 
                   bg-slate-50 text-slate-800 
                   border border-slate-300 
                   focus:outline-none focus:ring-2 
                   focus:ring-cyan-500/40 focus:border-cyan-500
                   transition"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Opciones -->
            <div class="flex items-center justify-between text-sm">

                <a href="#" class="text-cyan-600 hover:text-cyan-700 font-medium transition">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <!-- Botón -->
            <button type="submit"
                class="w-full bg-cyan-600 hover:bg-cyan-700 
               text-white font-semibold py-3 rounded-xl 
               transition-all duration-300 
               shadow-md hover:shadow-lg">
                Ingresar
            </button>
            <div class="form-group">
                <label class="small mb-1 text-red-600">
                    <?php if (isset($errormsg)) {
                        echo $errormsg;
                    } ?>
                </label>
            </div>
        </form>

        <!-- Footer -->
        <p class="text-center text-slate-400 text-xs mt-8">
            © 2026 - Sistema Profesional
        </p>

    </div>

</body>

</html>