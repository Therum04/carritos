<?php
session_start();

$id = (int)($_POST['id'] ?? 0);
$accion = $_POST['accion'] ?? '';

if ($accion === 'remove' && !empty($_SESSION['carrito'])) {

  // ✅ Caso 1: si usas ID como KEY
  if (isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
  } else {
    // ✅ Caso 2: si usas carrito indexado
    foreach ($_SESSION['carrito'] as $key => $item) {
      if (isset($item['id']) && $item['id'] == $id) {
        unset($_SESSION['carrito'][$key]);
        break;
      }
    }
  }

  // Reindexar por si acaso
  $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

/* 🔥 Recalcular totales */
$subtotal = 0;
$items = 0;

if (!empty($_SESSION['carrito'])) {
  foreach ($_SESSION['carrito'] as $p) {
    $subtotal += $p['precio'] * $p['cantidad'];
    $items += $p['cantidad'];
  }
}

echo json_encode([
  'ok' => true,
  'subtotal' => number_format($subtotal, 2),
  'items' => $items,
  'total' => number_format($subtotal, 2)
]);
