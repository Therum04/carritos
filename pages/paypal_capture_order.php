<?php
header('Content-Type: application/json');
session_start();
require 'config_paypal.php';
require '../admin/classes/Database.php';
$db = new Database();
$con = $db->connect();

// Obtener datos de PayPal
$input = json_decode(file_get_contents("php://input"), true);
$orderID = $input['orderID'] ?? null;

if (!$orderID) {
    echo json_encode(['error' => 'OrderID inválido']);
    exit;
}

// Capturar el pago en PayPal
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => PAYPAL_API . "/v2/checkout/orders/$orderID/capture",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_USERPWD => PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRET,
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
]);

$result = curl_exec($ch);

if ($result === false) {
    echo json_encode(['error' => curl_error($ch)]);
    exit;
}
curl_close($ch);

// Decodificar respuesta
$data = json_decode($result, true);

if (!isset($data['id'])) {
    echo json_encode(['error' => 'Error al capturar el pago']);
    exit;
}

// Datos importantes
$orderIDPaypal = $data['id'];
$nombre       = $data['payer']['name']['given_name'] ?? '';
$email        = $data['payer']['email_address'] ?? '';
$total        = $data['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? 0;
$idusuario    = $_SESSION['idusuario'] ?? null;
$numeropedido = 'PED-' . time();

// 1️⃣ Insertar pedido principal
$sqlPedido = "INSERT INTO pedido 
    (numeropedido, fecha_registro, idusuario, estado, total, paypal_order_id, paypal_email) 
    VALUES 
    ('$numeropedido', NOW(), '$idusuario', 1, '$total', '$orderIDPaypal', '$email')";
mysqli_query($con, $sqlPedido);
$idpedido = mysqli_insert_id($con);

// 2️⃣ Insertar detalles del pedido
if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $idproducto = $item['id'];
        $cantidad   = $item['cantidad'];

        $sqlDet = "INSERT INTO pedido_detalle 
            (idpedido, cantidad, idproductos) 
            VALUES 
            ('$idpedido', '$cantidad', '$idproducto')";
        mysqli_query($con, $sqlDet);
    }
}

// 3️⃣ Guardar en sesión
$_SESSION['ultimo_pago'] = [
    'idpedido'     => $idpedido,
    'numeropedido' => $numeropedido,
    'order_id'     => $orderIDPaypal,
    'nombre'       => $nombre,
    'email'        => $email,
    'total'        => $total
];

// 4️⃣ Vaciar carrito
unset($_SESSION['carrito']);
unset($_SESSION['cart_count']);

// 5️⃣ Devolver respuesta a JS
echo json_encode($data);

