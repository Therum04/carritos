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
        <h1 class="text-2xl font-bold text-gray-800">Producto</h1>
        <p class="text-sm text-gray-500">Gestión de Producto del sistema</p>
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
            placeholder="Buscar Producto..."
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

        <!-- BOTÓN AGREGAR -->
        <button
          type="button"
          onclick="openModal();"
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




<!-- MODAL -->
<div id="modalProducto"
  class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">

  <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg overflow-hidden">

    <!-- FORM -->
    <form id="productoForm"
      method="POST"
      enctype="multipart/form-data">
      <input type="hidden" name="guardarProducto" id="guardarProducto" value="1">
      <!-- HEADER -->
      <div class="flex items-center justify-between px-6 py-4 border-b">
        <h2 class="text-lg font-semibold">Detalles del producto</h2>
        <button type="button" onclick="closeModal()"
          class="text-gray-400 hover:text-gray-600">
          ✕
        </button>
      </div>

      <!-- BODY -->
      <div class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">

        <!-- Nombre -->
        <div>
          <label class="block text-sm font-medium mb-1">Nombre <span class="text-red-500">*</span></label>
          <input type="text" name="nombre" id="nombre"
            placeholder="Ej: Audífonos Bluetooth"
            class="w-full rounded-lg border px-3 py-2 focus:ring focus:ring-emerald-200">
        </div>

        <!-- Descripción -->
        <div>
          <label class="block text-sm font-medium mb-1">Descripción <span class="text-red-500">*</span></label>
          <textarea name="descripcion" id="descripcion" rows="3"
            placeholder="Descripción breve..."
            class="w-full rounded-lg border px-3 py-2 focus:ring focus:ring-emerald-200"></textarea>
        </div>

        <!-- Categoría -->
        <div>
          <label class="block text-sm font-medium mb-1">Categoría <span class="text-red-500">*</span></label>
          <select name="idcategorias" id="idcategorias"
            class="w-full rounded-lg border px-3 py-2 focus:ring focus:ring-emerald-200 tipoCategoria_list">
            <option value="">Seleccione</option>
          </select>
        </div>

        <!-- Precio / Estado -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Precio <span class="text-red-500">*</span></label>
            <input type="number" id="precio" name="precio" value="0"
              class="w-full rounded-lg border px-3 py-2">
            <p class="text-xs text-gray-500 mt-1">Precio normal del producto.</p>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Stock <span class="text-red-500">*</span></label>
            <input type="number" name="stock" id="stock" value="0"
              class="w-full rounded-lg border px-3 py-2">

          </div>

        </div>

        <!-- Oferta / Descuento -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Precio oferta</label>
            <input type="number" id="precio_oferta" name="precio_oferta"
              placeholder="Precio oferta (opcional)"
              class="w-full rounded-lg border px-3 py-2"
              oninput="calcularDescuento()">
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">% Descuento</label>
            <input type="number" id="descuento" name="descuento"
              placeholder="% descuento (opcional)"
              class="w-full rounded-lg border px-3 py-2">
          </div>
        </div>

        <!-- Imagen principal -->
        <div class="flex items-center gap-2">
          <label
            class="border rounded-lg px-4 py-2 flex items-center gap-2 cursor-pointer hover:bg-gray-50">
            ⬆️ Subir imagen principal
            <input type="file" id="imgPrincipal"
              name="imgPrincipal"
              accept="image/*"
              class="hidden"
              onchange="previewPrincipal(event)">
          </label>

          <button type="button"
            id="btnQuitarPrincipal"
            onclick="clearPrincipal()"
            class="border rounded-lg px-4 py-2 hover:bg-gray-50 hidden">
            ✖ Quitar selección
          </button>
        </div>

        <p id="txtPrincipal"
          class="text-xs text-gray-500 mt-1 hidden"></p>

        <!-- Galería -->
        <div>
          <label class="block text-sm font-medium mb-2">
            Galería (Carrusel)
          </label>

          <label
            class="border rounded-lg px-4 py-2 w-full cursor-pointer flex items-center gap-2 hover:bg-gray-50">
            🖼️ Subir hasta 6 imágenes <span class="text-red-500">*</span>
            <input type="file" id="galeria" name="galeria[]"
              accept="image/*" multiple
              class="hidden"
              onchange="previewGallery(event)">
          </label>

          <p class="text-xs text-gray-500 mt-1">
            Máx 6 por producto.
          </p>

          <div id="galleryPreview"
            class="grid grid-cols-3 gap-3 mt-3"></div>
        </div>

      </div>

      <!-- FOOTER -->
      <div class="flex justify-end gap-3 px-6 py-4 border-t">
        <button type="button" onclick="closeModal()"
          class="px-4 py-2 rounded-lg border hover:bg-gray-100">
          Cancelar
        </button>

        <button type="button"
          class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 add-insert">
          Guardar
        </button>
      </div>

    </form>
  </div>
</div>



<!-- MODAL -->
<div id="productoModal"
  class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden">

  <div
    class="relative bg-white rounded-2xl w-full max-w-5xl mx-4 shadow-xl">

    <!-- Cerrar -->
    <button onclick="closeModalDetalle()"
      class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl z-20">
      ✕
    </button>

    <div class="grid md:grid-cols-2 gap-6 p-6">

      <!-- IMÁGENES -->
      <div>

        <!-- Imagen principal -->
        <div class="bg-gray-50 rounded-xl p-4 mb-4 relative">

          <!-- 🔥 DESCUENTO -->
          <div
            class="absolute top-[14px] right-[14px] z-10
         px-3 py-2 rounded-full
         bg-[#fde7b3]
         border border-black/10
         font-extrabold text-[12px]
         text-black/80
         shadow-[0_16px_26px_rgba(17,24,39,0.12)]
         backdrop-blur-md
         whitespace-nowrap descuento hidden">
          </div>

          <img id="mainImg"
            class="mx-auto max-h-80 object-contain rounded-xl">
        </div>

        <!-- MINIATURAS -->
        <div class="relative w-full max-w-[720px] mx-auto">

          <!-- Flecha izquierda -->
          <button onclick="scrollThumbs(-1)"
            class="hidden absolute left-0 top-1/2 -translate-y-1/2 z-10
                   bg-white shadow rounded-full w-8 h-8 flex items-center justify-center">
            ‹
          </button>

          <div class="overflow-hidden">
            <div id="thumbs"
              class="flex gap-2 transition-transform duration-300">
            </div>
          </div>

          <!-- Flecha derecha -->
          <button onclick="scrollThumbs(1)"
            class="hidden absolute right-0 top-1/2 -translate-y-1/2 z-10
                   bg-white shadow rounded-full w-8 h-8 flex items-center justify-center">
            ›
          </button>

        </div>
      </div>

      <!-- INFO -->
      <div>
        <p class="text-gray-400 uppercase text-sm">Producto</p>

        <h2 class="text-2xl font-bold mb-2"></h2>

        <div class="mb-4 flex flex-col">
          <span class="precio text-2xl font-bold text-emerald-500"></span>
          <span class="precio_old line-through text-gray-400 text-sm"></span>
        </div>

        <div>
          <h3 class="font-semibold mb-1">Descripción</h3>
          <p class="descripcion text-gray-600 text-sm"></p>
        </div>

      </div>

    </div>
  </div>
</div>


<?php include_once("template/pie.php"); ?>
<script type="text/javascript" src="./js/producto.js"></script>