<?php include_once("template/cabecera.php"); ?>
<main class="flex-1 p-8 w-full">
  <!-- HEADER -->
  <div class="flex items-center justify-between mb-4 md:hidden">
    <button onclick="toggleMenu()" class="text-2xl">☰</button>
    <span class="font-semibold">Principal</span>
  </div>
  <!-- ===== BANNER SLIDER ===== -->
  <section class="w-full bg-white py-4">

    <div class="relative max-w-7xl mx-auto overflow-hidden">

      <!-- TRACK -->
      <div id="promoTrack"
        class="flex transition-transform duration-500 ease-out">

        <?php
        $banners = [
          "img/21797.png",
          "img/21798.png",
          "img/81525.png",
          "img/Screenshot_20260115-094643.png",
          "img/unnamed.jpg"
        ];
        foreach ($banners as $img) { ?>
          <article class="min-w-full px-2">
            <div class="rounded-xl overflow-hidden shadow">
              <img
                src="<?= $img ?>"
                alt="Banner"
                class="w-full h-[180px] sm:h-[220px] md:h-[260px] object-cover">
            </div>
          </article>
        <?php } ?>
      </div>

      <!-- BOTÓN PREV -->
      <button id="promoPrev"
        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white
             shadow rounded-full w-9 h-9 flex items-center justify-center text-xl">
        ‹
      </button>

      <!-- BOTÓN NEXT -->
      <button id="promoNext"
        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white
             shadow rounded-full w-9 h-9 flex items-center justify-center text-xl">
        ›
      </button>

      <!-- DOTS -->
      <div id="promoDots" class="flex justify-center gap-2 mt-3">
        <?php for ($i = 0; $i < count($banners); $i++) { ?>
          <button
            class="w-2.5 h-2.5 rounded-full <?= $i == 0 ? 'bg-teal-500' : 'bg-gray-300' ?>">
          </button>
        <?php } ?>
      </div>

    </div>
    <br>
    <div class="bg-white p-6 rounded-xl shadow mb-6">

      <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

        <!-- TÍTULO -->


        <!-- BUSCADOR + BOTONES -->
        <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
          <!-- INPUT -->
          <div class="md:w-64">
            <select name="idcategorias" id="idcategorias"
              class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900
                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 tipoCategoria_list">
              <option value="">Categoria</option>
            </select>
          </div>

          <!-- INPUT -->
          <div class="md:w-64">
            <input
              type="text"
              name="q"
              id="q"
              maxlength="50"
              placeholder="Buscar categoría..."
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
  </section>

</main>
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

<!-- ===== JS SLIDER ===== -->
<script>
  const track = document.getElementById('promoTrack');
  const dots = document.querySelectorAll('#promoDots button');
  const slides = track.children.length;

  let index = 0;
  let interval;
  const TIME = 4000;

  function update() {
    track.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach((d, i) => {
      d.classList.toggle('bg-teal-500', i === index);
      d.classList.toggle('bg-gray-300', i !== index);
    });
  }

  function next() {
    index = (index + 1) % slides;
    update();
  }

  function prev() {
    index = (index - 1 + slides) % slides;
    update();
  }

  function play() {
    interval = setInterval(next, TIME);
  }

  function stop() {
    clearInterval(interval);
  }

  document.getElementById('promoNext').onclick = () => {
    stop();
    next();
    play();
  }
  document.getElementById('promoPrev').onclick = () => {
    stop();
    prev();
    play();
  }

  dots.forEach((d, i) => d.onclick = () => {
    stop();
    index = i;
    update();
    play();
  });

  /* Swipe móvil */
  let startX = 0;
  track.addEventListener('touchstart', e => startX = e.touches[0].clientX);
  track.addEventListener('touchend', e => {
    let endX = e.changedTouches[0].clientX;
    if (startX - endX > 50) next();
    if (endX - startX > 50) prev();
  });

  track.parentElement.addEventListener('mouseenter', stop);
  track.parentElement.addEventListener('mouseleave', play);

  play();
</script>


<?php include_once("template/pie.php"); ?>
<script type="text/javascript" src="./js/presentacion.js"></script>