<?php
session_start();

$id = (int)$_POST['id'];
$nombre = $_POST['nombre'];
$precio = (float)$_POST['precio'];
$imagen = $_POST['imagen'];

if (!isset($_SESSION['carrito'])) {
  $_SESSION['carrito'] = [];
}

if (isset($_SESSION['carrito'][$id])) {
  $_SESSION['carrito'][$id]['cantidad']++;
} else {
  $_SESSION['carrito'][$id] = [
    'id' => $id,
    'nombre' => $nombre,
    'precio' => $precio,
    'cantidad' => 1,
    'imagen' => $imagen
  ];
}

echo json_encode([
  'items' => array_sum(array_column($_SESSION['carrito'], 'cantidad'))
]);
