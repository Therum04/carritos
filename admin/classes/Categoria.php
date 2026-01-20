<?php


class Categoria
{

	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function addRegistro($idcategorias, $categoria)
	{

		if ($idcategorias == 0) {
			$q = $this->con->query("SELECT * FROM categorias WHERE categoria = '$categoria' LIMIT 1");
			if ($q->num_rows > 0) {
				return ['status' => 303, 'message' => 'ya existe un registro'];
			}
			$q = $this->con->query("INSERT INTO categorias (categoria) 
			VALUES ( '$categoria')");
			if ($q) {
				return ['status' => 202, 'message' => 'El registro se guardó correctamente'];
			} else {
				return ['status' => 303, 'message' => 'No se guardó correctamente'];
			}
		} else {
			$q = $this->con->query("UPDATE categorias
			 SET categoria= '$categoria'
			 WHERE idcategorias = '$idcategorias'");
			if ($q) {
				return ['status' => 202, 'message' => 'Registro modificado correctamente'];
			} else {
				return ['status' => 303, 'message' => 'No se podido modificar el registro'];
			}
		}
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


	
}

if (isset($_POST['add_update'])) {
	$idcategorias = $_POST['idcategorias'];
	$categoria = $_POST['categoria'];
	$p = new Categoria();
	echo json_encode($p->addRegistro($idcategorias, $categoria));
}



if (isset($_POST['eliminar_registro'])) {
	if (!empty($_POST['cid'])) {
		$p = new Categoria();
		echo json_encode($p->deleteRegistro($_POST['cid']));
		exit();
	} else {
		echo json_encode(['status' => 303, 'message' => 'ID de categoria inválido']);
		exit();
	}
}



