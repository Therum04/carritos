<?php include_once("template/cabecera.php"); ?>
<main class="flex-2 p-5 w-full">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-4 md:hidden">
        <button onclick="toggleMenu()" class="text-2xl">☰</button>
        <span class="font-semibold">Baner</span>
    </div>



    <!-- HEADER / TOOLBAR -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

            <!-- TÍTULO -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Baner</h1>
                <p class="text-sm text-gray-500">Gestión de baner del sistema</p>
            </div>

            <!-- BUSCADOR + BOTONES -->
            <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">


                <!-- BOTÓN AGREGAR -->
                <button
                    type="button"
                    onclick="abrirBanner();"
                    class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-lg
               text-sm flex items-center justify-center gap-2 transition shadow">
                    <i class="fas fa-plus-circle"></i>
                    Agregar
                </button>

            </div>

        </div>
    </div>


    <div class="col-md-12">
        <div id="loader"></div><!-- Carga de datos ajax aqui -->
        <div id="resultados"></div><!-- Carga de datos ajax aqui -->
        <div class='outer_div'></div><!-- Carga de datos ajax aqui -->
    </div>



</main>

<div id="bannerModal"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">

    <!-- Caja modal -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">

        <!-- Header -->
        <div class="flex justify-between items-center border-b px-6 py-3">
            <h4 class="text-lg font-semibold text-gray-800">Registro de Banner</h4>
            <button type="button"
                class="text-gray-500 hover:text-red-500 text-2xl font-bold"
                onclick="cerrarBanner()">&times;</button>
        </div>

        <!-- Body -->
        <div class="p-6">
            <form id="form_baner" class="grid grid-cols-1 gap-4">
                <input type="hidden" name="add_baner" id="add_baner" value="1">
                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Imagen <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                        name="imagen"
                        id="imagen"
                        accept="image/*"
                        required
                        class="mt-1 w-full border border-gray-300 rounded px-3 py-2 text-gray-900
                        focus:outline-none focus:ring focus:border-blue-400 bg-white">
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="flex justify-between items-center border-t px-6 py-3 bg-gray-50">
            <button type="button"
                onclick="cerrarBanner()"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded">
                Cerrar
            </button>

            <button
                type="button"
                class="add-insert-upadate bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-lg
               text-sm flex items-center justify-center gap-2 transition shadow">
                <i class="fas fa-plus-circle"></i>
                Agregar
            </button>
        </div>

    </div>
</div>

<?php include_once("template/pie.php"); ?>
<script type="text/javascript" src="./js/baner.js"></script>