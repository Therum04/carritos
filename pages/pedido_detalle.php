<?php
include "../admin/classes/Database.php";
$db = new Database();
$con = $db->connect();

$idpedido = intval($_POST['idpedido']);

$sql = "SELECT 
    d.idpedido_detalle,
    d.cantidad,
    p.nombre,
    p.precio,
    p.precio_oferta,
    CASE 
        WHEN p.precio_oferta = 0 THEN p.precio
        ELSE p.precio_oferta
    END AS precio_final
FROM pedido_detalle d
LEFT JOIN productos p ON p.idproductos = d.idproductos
WHERE d.idpedido = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idpedido);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>
 <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-[rgb(20,184,166)] text-white text-sm">
            <tr>
                <th class="px-4 py-2 text-left">Producto</th>
                <th class="px-4 py-2 text-center">Cantidad</th>
                <th class="px-4 py-2 text-right">Precio</th>
                <th class="px-4 py-2 text-right">Subtotal</th>
            </tr>
        </thead>

        <tbody class="bg-white divide-y">
            <?php while ($row = $result->fetch_assoc()) {
                $subtotal = $row['precio_final'] * $row['cantidad'];
                $total += $subtotal;
            ?>
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2"><?php echo $row['nombre']; ?></td>
                    <td class="px-4 py-2 text-center"><?php echo $row['cantidad']; ?></td>
                    <td class="px-4 py-2 text-right">
                        $<?php echo number_format($row['precio_final'], 2); ?>
                    </td>
                    <td class="px-4 py-2 text-right font-semibold">
                        $<?php echo number_format($subtotal, 2); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

        <tfoot class="bg-gray-100">
            <tr>
                <td colspan="3" class="px-4 py-3 text-right font-bold text-lg">
                    TOTAL
                </td>
                <td class="px-4 py-3 text-right font-bold text-lg text-green-600">
                    $<?php echo number_format($total, 2); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>