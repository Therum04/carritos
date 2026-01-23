<?php
session_start();

$id = (int)($_POST['id'] ?? 0);
$accion = $_POST['accion'] ?? '';

if ($accion === 'remove' && !empty($_SESSION['carrito'])) {
  foreach ($_SESSION['carrito'] as $key => $item) {
    if ($item['id'] == $id) {
      unset($_SESSION['carrito'][$key]);
      break;
    }
  }

  // Reindexar array
  $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

/* Recalcular totales */
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
  'total' => number_format($subtotal, 2)
]);
