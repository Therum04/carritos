<?php
header('Content-Type: application/json');
session_start();
require 'config_paypal.php';

// 🔐 Recalcular total REAL desde sesión
$total = 0;

if (!empty($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
}

$total = number_format($total, 2, '.', '');

if ($total <= 0) {
    echo json_encode(['error' => 'Total inválido']);
    exit;
}

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => PAYPAL_API . "/v2/checkout/orders",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_USERPWD => PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRET,
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
    CURLOPT_POSTFIELDS => json_encode([
        "intent" => "CAPTURE",
        "purchase_units" => [[
            "amount" => [
                "currency_code" => "USD",
                "value" => $total
            ]
        ]]
    ])
]);

$result = curl_exec($ch);

if ($result === false) {
    echo json_encode(['error' => curl_error($ch)]);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($httpCode);
echo $result;
