<?php


class Baner
{

	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function addRegistro($imagen)
	{

		$rutaPrincipal = null;
		$destino = $_SERVER['DOCUMENT_ROOT'] . "/carritos/img/";
		if (!file_exists($destino)) {
			mkdir($destino, 0777, true);
		}
		$permitidos = ['jpg', 'jpeg', 'png', 'webp'];
		if ($imagen && $imagen['error'] === 0) {

			$ext = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

			if (!in_array($ext, $permitidos)) {
				echo json_encode([
					'status' => 303,
					'message' => 'Formato no permitido'
				]);
				exit;
			}

			$nombres = uniqid() . '.' . $ext;

			if (!move_uploaded_file($imagen['tmp_name'], $destino . $nombres)) {
				echo json_encode([
					'status' => 303,
					'message' => 'No se pudo subir la imagen'
				]);
				exit;
			}

			$rutaPrincipal =  $nombres; // guardar esto en BD

			$sql = "INSERT INTO banners (imagen, estado) VALUES (?, ?)";
			$stmt = $this->con->prepare($sql);
			$estado = 1;
			$stmt->bind_param("si", $rutaPrincipal, $estado);

			if ($stmt->execute()) {
				return ['status' => 202, 'message' => 'El registro se elimino correctamente'];
			} else {
				return ['status' => 303, 'message' => 'ID de area inválido'];
			}
		}
	}


	public function deleteRegistro($cid = null)
	{
		if ($cid != null) {

			$q = $this->con->query("SELECT * FROM productos WHERE idcategorias = '$cid' LIMIT 1");
			if ($q->num_rows > 0) {
				return ['status' => 303, 'message' => 'No se puede eliminar el registro existe una relación con productos'];
			}
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
}

if (isset($_POST['add_baner'])) {
	$imagen = $_FILES['imagen'] ?? null;
	$p = new Baner();
	echo json_encode($p->addRegistro($imagen));
}



if (isset($_POST['eliminar_registro'])) {
	if (!empty($_POST['cid'])) {
		$p = new Baner();
		echo json_encode($p->deleteRegistro($_POST['cid']));
		exit();
	} else {
		echo json_encode(['status' => 303, 'message' => 'ID de categoria inválido']);
		exit();
	}
}
