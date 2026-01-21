<?php
include "../admin/classes/Database.php";
$db = new Database();
$con = $db->connect();

$action = $_REQUEST['action'] ?? '';

if ($action == 'ajax') {

  $query = mysqli_real_escape_string($con, trim($_REQUEST['query'] ?? ''));

  $page = (int)($_REQUEST['page'] ?? 1);
  $per_page = (int)($_REQUEST['per_page'] ?? 8);
  $adjacents = 4;
  $offset = ($page - 1) * $per_page;

  $where = "nombre LIKE '%$query%'";

  include 'pagination.php';

  $count = mysqli_query($con, "SELECT COUNT(*) AS numrows FROM productos WHERE $where");
  $row = mysqli_fetch_assoc($count);
  $numrows = $row['numrows'];
  $total_pages = ceil($numrows / $per_page);

  $sql = mysqli_query($con,
    "SELECT * FROM productos
     WHERE $where
     ORDER BY idproductos DESC
     LIMIT $offset,$per_page"
  );
?>

<!-- CONTENEDOR CONTROLADO -->
<div class="max-w-7xl mx-auto px-4">

  <!-- GRID -->
  <div class="grid gap-6
              grid-cols-1
              sm:grid-cols-2
              md:grid-cols-3
              lg:grid-cols-4
              xl:grid-cols-5">

    <?php while ($p = mysqli_fetch_assoc($sql)) { ?>

    <!-- CARD -->
    <div class="bg-white rounded-xl shadow
                hover:shadow-lg transition
                max-w-[260px] mx-auto overflow-hidden">

      <!-- IMAGEN -->
      <div class="relative bg-gray-100 p-4">
        <img src="../img/<?= $p['imagen_principal'] ?>"
             class="mx-auto h-40 object-contain">

        <?php if ($p['descuento'] > 0) { ?>
        <span class="absolute top-3 right-3
                     bg-[#fde7b3]
                     text-xs font-extrabold
                     px-3 py-1 rounded-full shadow">
          -<?= $p['descuento'] ?>%
        </span>
        <?php } ?>
      </div>

      <!-- INFO -->
      <div class="p-4">

        <h3 class="text-sm font-semibold mb-2 line-clamp-2">
          <?= htmlspecialchars($p['nombre']) ?>
        </h3>

        <!-- PRECIOS -->
        <?php if ($p['precio_oferta'] > 0) { ?>
          <div class="text-lg font-bold text-emerald-600">
            S/ <?= number_format($p['precio_oferta'], 2) ?>
          </div>
          <div class="text-sm text-gray-400 line-through">
            S/ <?= number_format($p['precio'], 2) ?>
          </div>
        <?php } else { ?>
          <div class="text-lg font-bold">
            S/ <?= number_format($p['precio'], 2) ?>
          </div>
        <?php } ?>

        <!-- STOCK -->
        <div class="text-xs mt-2 mb-3">
          Stock:
          <span class="<?= $p['stock'] > 0 ? 'text-green-600' : 'text-red-500' ?>">
            <?= $p['stock'] ?>
          </span>
        </div>

        <!-- BOTÓN -->
        <button
          class="w-full bg-emerald-500 hover:bg-emerald-600
                 text-white py-2 rounded text-xs add-to-cart"
          data-id="<?= $p['idproductos'] ?>"
          data-name="<?= htmlspecialchars($p['nombre']) ?>"
          data-price="<?= $p['precio_oferta'] > 0 ? $p['precio_oferta'] : $p['precio'] ?>"
          data-image="<?= $p['imagen_principal'] ?>">
          🛒 Añadir al carrito
        </button>

      </div>
    </div>

    <?php } ?>

  </div>

  <!-- PAGINACIÓN -->
  <div class="mt-10 flex justify-center">
    <?= paginate($page, $total_pages, $adjacents); ?>
  </div>

</div>

<?php } ?>
