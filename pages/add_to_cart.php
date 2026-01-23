<?php
session_start();
$id = (int)($_POST['id'] ?? 0);
$name = $_POST['name'] ?? '';
$price = (float)($_POST['price'] ?? 0);
$image = $_POST['image'] ?? '';

if ($id <= 0) {
  echo json_encode(['ok' => false]);
  exit;
}

if (!isset($_SESSION['carrito'][$id])) {
  $_SESSION['carrito'][$id] = [
    'id' => $id,
    'nombre' => $name,
    'precio' => $price,
    'imagen' => $image,
    'cantidad' => 1
  ];
} else {
  $_SESSION['carrito'][$id]['cantidad']++;
}

/* 🔥 calcular total de items */
$total = 0;
foreach ($_SESSION['carrito'] as $item) {
  $total += $item['cantidad'];
}

echo json_encode([
  'ok' => true,
  'total' => $total
]);
