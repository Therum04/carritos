<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Opcional: fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-white flex items-center justify-center">


    <div class="w-full max-w-md bg-slate-800 rounded-2xl shadow-2xl p-8">
        
        <!-- Logo / Título -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white">Iniciar Sesión</h1>
            <p class="text-slate-400 text-sm mt-2">Accede a tu panel</p>
        </div>

        <!-- Formulario -->
        <form method="POST" action="login.php" class="space-y-6">

            <!-- Usuario -->
            <div>
                <label class="text-slate-300 text-sm">Usuario</label>
                <input type="text" name="usuario" required
                    class="w-full mt-1 px-4 py-3 rounded-xl bg-slate-700 text-white 
                           border border-slate-600 focus:outline-none focus:ring-2 
                           focus:ring-cyan-400 focus:border-transparent"
                    placeholder="Ingrese su usuario">
            </div>

            <!-- Contraseña -->
            <div>
                <label class="text-slate-300 text-sm">Contraseña</label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-3 rounded-xl bg-slate-700 text-white 
                           border border-slate-600 focus:outline-none focus:ring-2 
                           focus:ring-cyan-400 focus:border-transparent"
                    placeholder="********">
            </div>

            <!-- Recordar -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-slate-400">
                    <input type="checkbox" class="mr-2 accent-cyan-400">
                    Recordarme
                </label>
                <a href="#" class="text-cyan-400 hover:underline">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <!-- Botón -->
            <button type="submit"
                class="w-full bg-cyan-500 hover:bg-cyan-600 text-white 
                       font-semibold py-3 rounded-xl transition 
                       duration-300 shadow-lg">
                Ingresar
            </button>

        </form>

        <!-- Footer -->
        <p class="text-center text-slate-500 text-xs mt-8">
            © 2026 - Sistema Profesional
        </p>

    </div>

</body>
</html>
