<?php
session_start();

$id = (int)$_POST['id'];
$accion = $_POST['accion'];

if (!isset($_SESSION['carrito'][$id])) {
  echo json_encode(['ok' => false]);
  exit;
}

if ($accion === 'inc') {
  $_SESSION['carrito'][$id]['cantidad']++;
}

if ($accion === 'dec') {
  $_SESSION['carrito'][$id]['cantidad']--;
  if ($_SESSION['carrito'][$id]['cantidad'] <= 0) {
    unset($_SESSION['carrito'][$id]);
  }
}

/* Recalcular */
$subtotal = 0;
$items = 0;

foreach ($_SESSION['carrito'] as $p) {
  $subtotal += $p['precio'] * $p['cantidad'];
  $items += $p['cantidad'];
}

echo json_encode([
  'ok' => true,
  'subtotal' => number_format($subtotal, 2),
  'items' => $items,
  'total' => number_format($subtotal, 2),
  'cantidad' => $_SESSION['carrito'][$id]['cantidad'] ?? 0
]);
