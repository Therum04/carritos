<?php include_once("template/cabecera.php"); ?>
<?php include 'config_paypal.php'; ?>
<script src="https://www.paypal.com/sdk/js?client-id=<?= PAYPAL_CLIENT_ID ?>&currency=USD"></script>
<main class="flex-1 p-8 w-full">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-4 md:hidden">
        <button onclick="toggleMenu()" class="text-2xl">☰</button>
        <span class="font-semibold">Carrito</span>
    </div>


    <?php
    if (isset($_SESSION['idusuario'])) {
        $logueado = true;
        $nombre = $_SESSION['nombres'];
        $rol = $_SESSION['idrol'];
        $idusuario = $_SESSION['idusuario'];
    }
    $carrito  = $_SESSION['carrito'] ?? [];
    $subtotal = 0;
    $items    = 0;
    ?>

    <div class="max-w-full xl:max-w-6xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">

        <!-- HEADER -->
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h1 class="text-xl font-bold text-gray-800">Carrito</h1>

            <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 text-sm px-3 py-1 rounded-full">
                <strong id="cartCount" class="font-semibold">
                    <?= array_sum(array_column($carrito, 'cantidad')) ?>
                </strong>
                <span>items</span>
            </span>
        </div>

        <!-- BODY -->
        <div class="divide-y" id="cartBody">

            <?php if (empty($carrito)): ?>
                <div class="p-8 text-center text-gray-500">
                    🛒 Tu carrito está vacío
                </div>
            <?php endif; ?>

            <?php foreach ($carrito as $item):
                $sub = $item['precio'] * $item['cantidad'];
                $subtotal += $sub;
                $items += $item['cantidad'];
            ?>
                <div class="flex gap-4 p-6 cartItem"
                    data-id="<?= $item['id'] ?>"
                    data-price="<?= $item['precio'] ?>">

                    <!-- IMG -->
                    <div class="w-20 h-20 bg-gray-50 rounded-xl flex items-center justify-center overflow-hidden">
                        <img src="../img/<?= $item['imagen'] ?>" class="object-contain h-full">
                    </div>

                    <!-- INFO -->
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800">
                            <?= htmlspecialchars($item['nombre']) ?>
                        </h3>

                        <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                            <span>$ <?= number_format($item['precio'], 2) ?> c/u</span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                            <span>ID: <?= $item['id'] ?></span>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="flex flex-col items-end gap-3">
                        <div class="text-lg font-semibold itemSubtotal">
                            $ <?= number_format($sub, 2) ?>
                        </div>

                        <div class="flex items-center border rounded-lg overflow-hidden">
                            <button class="px-3 qty-dec">−</button>
                            <input type="number"
                                value="<?= $item['cantidad'] ?>"
                                min="1"
                                class="w-12 text-center qty-input">
                            <button class="px-3 qty-inc">+</button>
                        </div>
                        <button
                            class="text-sm text-red-500 remove-item"
                            data-id="<?= $item['id'] ?>">
                            Quitar
                        </button>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

        <!-- FOOTER RESUMEN -->
        <div class="border-t bg-gray-50 p-6">
            <div class="max-w-md ml-auto space-y-3">

                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span id="subtotal">$ <?= number_format($subtotal, 2) ?></span>
                </div>

                <div class="flex justify-between text-gray-600">
                    <span>Items</span>
                    <span id="items"><?= $items ?></span>
                </div>

                <div class="flex justify-between text-lg font-bold pt-2 border-t">
                    <span>Total</span>
                    <span id="total">$ <?= number_format($subtotal, 2) ?></span>
                </div>
                <?php if ($logueado): ?>
                    <div class="w-full mt-4">
                        <div id="paypal-button-container" style="position: relative;  z-index: 1;"
                            class="w-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold py-3 rounded-xl text-center">
                        </div>
                    </div>
                <?php else: ?>
                    <a href="../index.php"
                        class="w-full block text-center border border-emerald-300 text-emerald-600 p-3 rounded-lg hover:bg-emerald-50">
                        📝 Registrar cuenta
                    </a>
                <?php endif; ?>

            </div>
        </div>

    </div>






</main>

<?php include_once("template/pie.php"); ?>
<script type="text/javascript" src="./js/carrito.js"></script>
<script>
    paypal.Buttons({

        createOrder: function(data, actions) {

            // 👉 Tomar total ACTUAL del DOM
            let totalText = document.getElementById('total').innerText;
            let total = totalText.replace('S/.', '').trim();

            return fetch('paypal_create_order.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        total: total
                    })
                })
                .then(res => res.json())
                .then(data => data.id);
        },

        onApprove: function(data, actions) {
            return fetch('paypal_capture_order.php', {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    })
                })
                .then(res => res.json())
                .then(details => {
                    alert('✅ Pago completado por ' + details.payer.name.given_name);

                    // 👉 Aquí puedes guardar venta en DB si quieres
                    window.location.href = "gracias.php";
                });
        },

        onError: function(err) {
            console.error('PayPal error:', err);
           // alert('❌ Error con PayPal. Intenta nuevamente.');
        }

    }).render('#paypal-button-container');
</script>