<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Productos | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="fixed md:static z-40 w-80 h-screen bg-white shadow-lg
flex flex-col justify-between
p-6 transform -translate-x-full md:translate-x-0 transition-transform duration-300">

            <!-- TOP -->
            <div>
                <!-- LOGO -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-teal-500 text-white flex items-center justify-center rounded-full font-bold">
                        AL
                    </div>
                    <div>
                        <p class="font-semibold">ALEX MARKET</p>
                        <span class="text-sm text-gray-500">Dashboard</span>
                    </div>
                </div>

                <!-- MENU -->
                <nav class="space-y-3 mt-6">
                    <a href="producto.php" class="flex items-center gap-3 bg-teal-50 border border-teal-200 p-3 rounded-lg text-teal-600 font-medium">
                        🛒 Productos
                    </a>
                    <a href="categoria.php" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100">📂 Categorías</a>
                    <a href="baner.php" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100">🖼 Banner</a>
                    <a class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100">👤 Perfil</a>
                </nav>
            </div>

            <!-- BOTTOM -->
            <button class="w-full border border-red-300 text-red-500 p-3 rounded-lg hover:bg-red-50">
                🚪 Cerrar sesión
            </button>

        </aside>


        <!-- OVERLAY MOBILE -->
        <div id="overlay" class="fixed inset-0 bg-black/40 hidden md:hidden" onclick="toggleMenu()"></div>