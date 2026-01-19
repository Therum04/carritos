<?php include_once("template/cabecera.php");?>
<main class="flex-1 p-8 w-full">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-4 md:hidden">
        <button onclick="toggleMenu()" class="text-2xl">☰</button>
        <span class="font-semibold">Productos</span>
    </div>



    <!-- TITLE -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Productos</h1>
            <p class="text-gray-500">Gestiona tu catálogo</p>
        </div>
        <button class="bg-teal-500 text-white px-5 py-3 rounded-lg shadow flex items-center justify-center gap-2">
            ➕ Agregar producto
        </button>
    </div>

    <!-- TABLE DESKTOP -->
    <div class="hidden md:block bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="p-4 text-left">Producto</th>
                    <th class="p-4 text-left">Precio</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">

                <tr>
                    <td class="p-4 font-medium">Prueba</td>
                    <td class="p-4">S/12.00</td>
                    <td class="p-4">
                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">● Activo</span>
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <button class="border p-2 rounded">✏️</button>
                            <button class="border border-red-300 text-red-500 p-2 rounded">🗑</button>
                            <button class="border p-2 rounded">👁</button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

   

</main>

<?php include_once("template/pie.php"); ?>