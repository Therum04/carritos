<?php include_once("template/cabecera.php"); ?>
<?php
// Obtener datos del pago
$pago = $_SESSION['ultimo_pago'];
// Limpiar carrito
unset($_SESSION['carrito']);
unset($_SESSION['cart_count']);
?>
<div class="min-h-screen flex items-center justify-center p-6">
    <div class="bg-white max-w-lg w-full rounded-2xl shadow-lg p-8 text-center">
        <!-- ICONO -->
        <div class="text-6xl mb-4">🎉</div>
        <!-- TITULO -->
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            ¡Gracias por tu compra!
        </h1>
        <!-- MENSAJE -->
        <p class="text-gray-600 mb-6">
            Tu pago fue procesado correctamente.
        </p>
        <!-- RESUMEN -->
        <div class="bg-gray-50 rounded-xl p-4 text-left text-sm mb-6 space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-500">Orden PayPal:</span>
                <span class="font-mono"><?= htmlspecialchars($pago['order_id']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Cliente:</span>
                <span><?= htmlspecialchars($pago['nombre']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Email:</span>
                <span><?= htmlspecialchars($pago['email']) ?></span>
            </div>
            <div class="flex justify-between font-semibold border-t pt-2">
                <span>Total pagado:</span>
                <span>S/. <?= number_format($pago['total'], 2) ?></span>
            </div>
        </div>
        <!-- BOTONES -->
        <div class="space-y-3">
            <a href="presentacion.php"
                class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-xl font-semibold">
                🛍️ Seguir comprando
            </a>
            <a href="#"
                class="block w-full border border-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-50">
                📦 Ver mis pedidos
            </a>
        </div>
    </div>
</div>
<?php include_once("template/pie.php"); ?>