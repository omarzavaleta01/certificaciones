<?php 
	function obtenerInformacionAlumno($conn,$idAlumno){
		try {
			$sql = "SELECT * FROM datosgenerales WHERE id = ?";
			$parametro = array($idAlumno);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametro);
			$registros = $ejectSQL->fetchAll();
			$contador = count($registros);

			return array($registros,$contador);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerAsignaturasAlumno($conn,$idGeneral){
		try {
			$sql = "SELECT * FROM asignaturas WHERE idDatosGenerales = ?";
			$parametro = array($idGeneral);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametro);
			$registros = $ejectSQL->fetchAll();
			$contador = count($registros);

			return array($registros,$contador);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
?>