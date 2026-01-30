<?php include_once("template/cabecera.php"); ?>
<style>
  .thumb {
    width: 64px;
    height: 64px;
    flex-shrink: 0;
  }

  .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0.75rem;
    cursor: pointer;
  }
</style>
<main class="flex-1 p-8 w-full">

  <!-- HEADER -->
  <div class="flex items-center justify-between mb-4 md:hidden">
    <button onclick="toggleMenu()" class="text-2xl">☰</button>
    <span class="font-semibold">Producto</span>
  </div>



  <!-- HEADER / TOOLBAR -->
  <div class="bg-white p-6 rounded-xl shadow mb-6">

    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

      <!-- TÍTULO -->
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Pedidos</h1>
        <p class="text-sm text-gray-500">Gestión de Pedidos del sistema</p>
      </div>

      <!-- BUSCADOR + BOTONES -->
      <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">

        <!-- INPUT -->
        <div class="md:w-64">
          <input
            type="text"
            name="q"
            id="q"
            maxlength="50"
            placeholder="Buscar Pedidos..."
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- BOTÓN BUSCAR -->
        <button
          type="button"
          onclick="load(1);"
          class="bg-teal-500 hover:bg-teal-600 text-white px-5 py-2 rounded-lg
               text-sm flex items-center justify-center gap-2 transition shadow">
          <i class="fas fa-search"></i>
          Buscar
        </button>

       

      </div>

    </div>
  </div>


  <div class="col-md-12">
    <div id="loader"></div><!-- Carga de datos ajax aqui -->
    <div id="resultados"></div><!-- Carga de datos ajax aqui -->
    <div class='outer_div'></div><!-- Carga de datos ajax aqui -->
  </div>
<br>
 <div class="col-md-12">
    <div id="loader2"></div><!-- Carga de datos ajax aqui -->
    <div id="resultados2"></div><!-- Carga de datos ajax aqui -->
    <div class='outer_div2'></div><!-- Carga de datos ajax aqui -->
  </div>

</main>








<?php include_once("template/pie.php"); ?>
<script type="text/javascript" src="./js/pedidos.js"></script>