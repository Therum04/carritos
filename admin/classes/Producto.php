<?php


class Producto
{

	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function guardarProducto(
		$nombre,
		$descripcion,
		$idcategorias,
		$precio,
		$stock,
		$precio_oferta,
		$descuento,
		$imgPrincipal,
		$galeria
	) {

		/* ==========================
           IMAGEN PRINCIPAL
        ========================== */
		$rutaPrincipal = null;



		$destino = $_SERVER['DOCUMENT_ROOT'] . "/carritos/img/";

		if (!file_exists($destino)) {
			mkdir($destino, 0777, true);
		}

		$permitidos = ['jpg', 'jpeg', 'png', 'webp'];

		if ($imgPrincipal && $imgPrincipal['error'] === 0) {

			$ext = strtolower(pathinfo($imgPrincipal['name'], PATHINFO_EXTENSION));

			if (!in_array($ext, $permitidos)) {
				echo json_encode([
					'status' => 303,
					'message' => 'Formato no permitido'
				]);
				exit;
			}

			$nombres = uniqid() . '.' . $ext;

			if (!move_uploaded_file($imgPrincipal['tmp_name'], $destino . $nombres)) {
				echo json_encode([
					'status' => 303,
					'message' => 'No se pudo subir la imagen'
				]);
				exit;
			}

			$rutaPrincipal =  $nombres; // guardar esto en BD
		}
		/* ==========================
           INSERT PRODUCTO
        ========================== */
		$sql = "INSERT INTO productos 
            (nombre, descripcion, idcategorias, precio, stock, precio_oferta, descuento, imagen_principal)
            VALUES (?,?,?,?,?,?,?,?)";

		$stmt = $this->con->prepare($sql);
		$stmt->bind_param(
			"ssiiddds",
			$nombre,
			$descripcion,
			$idcategorias,
			$precio,
			$stock,
			$precio_oferta,
			$descuento,
			$rutaPrincipal
		);

		if (!$stmt->execute()) {
			return ['status' => 500, 'msg' => 'Error al guardar producto'];
		}

		$idproducto = $stmt->insert_id;

		/* ==========================
           GALERÍA
        ========================== */
		if ($galeria && count($galeria['name']) > 0) {

			if (count($galeria['name']) > 6) {
				echo json_encode([
					'status' => 303,
					'message' => 'Máximo 6 imágenes permitidas'
				]);
				exit;
			}

			for ($i = 0; $i < count($galeria['name']); $i++) {

				if ($galeria['error'][$i] !== 0) continue;

				$ext = strtolower(pathinfo($galeria['name'][$i], PATHINFO_EXTENSION));

				if (!in_array($ext, $permitidos)) continue;

				$nombre = uniqid('gal_') . '.' . $ext;

				if (!move_uploaded_file(
					$galeria['tmp_name'][$i],
					$destino . $nombre
				)) {
					continue;
				}

				// 👉 Ruta RELATIVA para mostrar en frontend
				$ruta =  $nombre;

				$sqlImg = "INSERT INTO producto_imagen (idproductos, imagen)
                   VALUES (?,?)";

				$stmtImg = $this->con->prepare($sqlImg);
				$stmtImg->bind_param("is", $idproducto, $ruta);
				$stmtImg->execute();
			}
		}

		return ['status' => 202, 'message' => 'Producto registrado'];
	}


	public function deleteRegistro($cid = null)
	{
		if ($cid != null) {

			$q = $this->con->query("DELETE FROM categorias WHERE idcategorias = '$cid'")  or die($this->con->error);
			if ($q) {
				return ['status' => 202, 'message' => 'El registro se elimino correctamente'];
			} else {
				return ['status' => 202, 'message' => 'No se ha podido eliminar el registro'];
			}
		} else {
			return ['status' => 303, 'message' => 'ID de area inválido'];
		}
	}

	public function getCategorias()
	{
		$enumerado = [];
		$q = $this->con->query("SELECT categoria, idcategorias FROM categorias  order by categoria asc  ");
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_assoc()) {
				$enumerado[] = $row;
			}
			$_DATA['enumerado'] = $enumerado;
		}
		return ['status' => 202, 'message' => $_DATA];
	}
}




if (isset($_POST['guardarProducto'])) {
	$nombre        = $_POST['nombre'];
	$descripcion   = $_POST['descripcion'];
	$idcategorias  = $_POST['idcategorias'];
	$precio        = $_POST['precio'];
	$stock         = $_POST['stock'];
	$precio_oferta = $_POST['precio_oferta'] ?? 0;
	$descuento     = $_POST['descuento'] ?? 0;
	$imgPrincipal = $_FILES['imgPrincipal'] ?? null;
	$galeria      = $_FILES['galeria'] ?? null;

	$p = new Producto();
	echo json_encode(
		$p->guardarProducto(
			$nombre,
			$descripcion,
			$idcategorias,
			$precio,
			$stock,
			$precio_oferta,
			$descuento,
			$imgPrincipal,
			$galeria
		)
	);
}
