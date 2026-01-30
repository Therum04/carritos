<?php
session_start();
include "../admin/classes/Database.php";
$db = new Database();
$con = $db->connect();
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {

  $idusuario = intval($_SESSION['idusuario']);
  $idrol = intval($_SESSION['idrol']);
  $query = mysqli_real_escape_string($con, trim((strip_tags($_REQUEST['query'], ENT_QUOTES))));
  $tables = " pedido p";
  $campos = " p.idpedido, p.numeropedido,p.fecha_registro, p.idusuario, p.estado, p.total, p.fecha_modificacion, p.paypal_order_id, p.paypal_email";
  if ($idrol == 1 || $idrol == 2) {
    $sWhere = "  (p.numeropedido LIKE '%" . $query . "%' or p.paypal_email LIKE '%" . $query . "%' )";
  } else {
    $sWhere = " p.idusuario = '$idusuario' and (p.numeropedido LIKE '%" . $query . "%' or p.paypal_email LIKE '%" . $query . "%' ) ";
  }
  $sWhere .= " ORDER BY p.fecha_registro desc";
  include 'pagination.php';
  $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
  $per_page = intval($_REQUEST['per_page']);
  $adjacents  = 4;
  $offset = ($page - 1) * $per_page;
  $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $tables where $sWhere");

  if ($row = mysqli_fetch_array($count_query)) {
    $numrows = $row['numrows'];
  } else {
    echo mysqli_error($con);
  }
  $total_pages = ceil($numrows / $per_page);
  $query = mysqli_query($con, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");

  if ($numrows > 0) {
?>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[rgb(20,184,166)] text-white text-sm">
          <tr>
            <th class="px-4 py-2 text-left font-semibold uppercase">N°</th>
            <th class="px-4 py-2 text-left font-semibold uppercase">Numero de pedido</th>
            <th class="px-4 py-2 text-left font-semibold uppercase">Fecha de pedido</th>
            <th class="px-4 py-2 text-left font-semibold uppercase">Total</th>
            <th class="px-4 py-2 text-left font-semibold uppercase">Paypal Id</th>
            <th class="px-4 py-2 text-left font-semibold uppercase">Paypal Email</th>
            <th class="px-4 py-2 text-center font-semibold uppercase">Acción</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
          <?php
          $finales = 0;
          while ($row = mysqli_fetch_array($query)) {
            $id = $row['idpedido'];
            $numeropedido = $row['numeropedido'];
            $fecha_registro = $row['fecha_registro'];
            $idusuario = $row['idusuario'];
            $estado = $row['estado'];
            $total = $row['total'];
            $paypal_order_id = $row['paypal_order_id'];
            $paypal_email = $row['paypal_email'];
            $finales++;
          ?>
            <tr>
              <td class="px-4 py-2"><?php echo $finales; ?></td>
              <td class="px-4 py-2"><?php echo $numeropedido; ?></td>
              <td class="px-4 py-2"><?php echo $fecha_registro; ?></td>
              <td class="px-4 py-2"><?php echo $total; ?></td>
              <td class="px-4 py-2"><?php echo $paypal_order_id; ?></td>
              <td class="px-4 py-2"><?php echo $paypal_email; ?></td>
              <td class="px-4 py-2 text-center flex justify-center gap-2">

                <a href="#"
                  class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs ver-detalle"
                  title="Ver"
                  data-cid="<?php echo $id; ?>">
                  👁
                </a>
              </td>
            </tr>
          <?php } ?>
          <tr class="bg-gray-50 text-sm text-gray-600">
            <td colspan="7" class="px-4 py-3">
              <?php
              $inicios = $offset + 1;
              $finales += $inicios - 1;
              echo "Mostrando $inicios al $finales de $numrows registros";
              echo paginate($page, $total_pages, $adjacents);
              ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

<?php
  }
}
?>