<?php include_once("template/cabecera.php"); ?>


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
</section>


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