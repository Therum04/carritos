<?php
include "../admin/classes/Database.php";
$db = new Database();
$con = $db->connect();

$id = intval($_POST['idproducto']);

// PRODUCTO
$sql = "SELECT idproductos,
    idcategorias,
    nombre,
    descripcion,
    precio,
    precio_oferta,
    descuento,
    stock,
    imagen_principal
FROM productos
where idproductos = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

// GALERÍA
$galeria = [];
$sqlImg = "SELECT imagen FROM producto_imagen WHERE idproductos = ?";
$stmtImg = $con->prepare($sqlImg);
$stmtImg->bind_param("i", $id);
$stmtImg->execute();
$resImg = $stmtImg->get_result();

while ($row = $resImg->fetch_assoc()) {
    $galeria[] = $row['imagen'];
}

// RESPUESTA
echo json_encode([
    'nombre' => $producto['nombre'],
    'precio' => $producto['precio'],
    'precio_oferta' => $producto['precio_oferta'],
    'descripcion' => $producto['descripcion'],
    'imagen_principal' => $producto['imagen_principal'],
    'galeria' => $galeria
]);
