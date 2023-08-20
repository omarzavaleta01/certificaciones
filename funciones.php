<?php
	function verificarLogin($conn,$email,$clave){
		try {
			$sql = "SELECT * FROM usuarios WHERE email = ? AND clave = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($email,$clave,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCargos($conn){
		try {
			$sql = "SELECT * FROM catalogocargos WHERE status = 1";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute();
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	
	function obtenerCargoEspecifico($conn,$idCargo){
		try {
			$sql = "SELECT * FROM catalogocargos WHERE idCargo = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute(array($idCargo,1));
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerProfesiones($conn){
		try {
			$sql = "SELECT * FROM catalogoProfesiones WHERE status = 1";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute();
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}

	}
	function pre($array){
		echo '<pre>';
			print_r($array);
		echo '</pre>';
	}
	function verificarUniversidad($conn,$claveUniversidad){
		try {
			$sql = "SELECT idInstitucion FROM instituciones WHERE clave = ? AND idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($claveUniversidad,$_SESSION["idUser"],1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function verificarCarrera($conn,$idUniversidad,$claveCarrera,$rvoe){
		try {
			$sql = "SELECT idCarrera FROM carreras WHERE idInstitucion = ? AND (clave = ? OR rvoe = ?) AND idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUniversidad,$claveCarrera,$rvoe,$_SESSION["idUser"],1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function verificarCampus($conn, $idInstitucion){
		try {
			$sql = "SELECT idCampus FROM campus WHERE idInstitucion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idInstitucion,$_SESSION["idUser"],1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function verificarCampus1($conn, $numero){
		try {
			$sql = "SELECT idCampus FROM campus WHERE numero = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($numero,$_SESSION["idUser"],1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	


	function verificarCarrera1($conn,$idUniversidad,$claveCarrera){
		try {
			$sql = "SELECT idCarrera FROM carreras WHERE idInstitucion = ? AND clave = ? AND idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUniversidad,$claveCarrera,$_SESSION["idUser"],1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerInstituciones($conn,$idUser){
		try {
			$sql = "SELECT * FROM instituciones WHERE idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUser,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	
	function obtenerInstucion($conn,$idInstitucion){
		try {
			$sql = "SELECT * FROM instituciones WHERE idInstitucion = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idInstitucion);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerResponsables($conn,$idInstitucion){
		try {
			$sql = "SELECT * FROM responsables WHERE idInstitucion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idInstitucion,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerResponsable($conn,$idResponsable){
		try {
			$sql = "SELECT * FROM responsables WHERE idResponsable = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idResponsable);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoAutorizacion($conn){
		try {
			$sql = "SELECT * FROM catalogoautorizacion WHERE status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array(1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoAutorizacionEspecifico($conn,$idAutorizacion){
		try {
			$sql = "SELECT * FROM catalogoautorizacion WHERE idAutorizacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idAutorizacion,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCarreras($conn,$idUsuario){
		try {
			$sql = "SELECT * FROM carreras WHERE idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUsuario,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCarrera($conn,$idCarrera){
		try {
			$sql = "SELECT * FROM carreras WHERE idCarrera = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idCarrera,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCarrerasInstitucion($conn,$idInstitucion){
		try {
			$sql = "SELECT * FROM carreras WHERE idInstitucion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idInstitucion,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoAntecedente($conn){
		try {
			$sql = "SELECT * FROM catalogoantecedente WHERE status = 1";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute();
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoAntecedenteEspecifico($conn,$idAntecedente){
		try {
			$sql = "SELECT * FROM catalogoantecedente WHERE idEstudio = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute(array($idAntecedente,1));
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "1";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoEntidades($conn){
		try {
			$sql = "SELECT * FROM catalogoentidades WHERE status = 1";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute();
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "2";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoEntidadesEspecifico($conn,$idEntidad){
		try {
			$sql = "SELECT * FROM catalogoentidades WHERE idEntidad = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute(array($idEntidad,1));
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "3";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoServicio($conn){
		try {
			$sql = "SELECT * FROM catalogoservicio WHERE status = 1";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute();
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "4";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoServicioEspecifico($conn,$idServicio){
		try {
			$sql = "SELECT * FROM catalogoservicio WHERE idServicio = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute(array($idServicio,1));
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "5";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoTitulaciones($conn){
		try {
			$sql = "SELECT * FROM catalogotitulacion WHERE status = 1";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute();
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "6";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoTitulacionesEspecifico($conn,$id){
		try {
			$sql = "SELECT * FROM catalogotitulacion WHERE idModalidad = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute(array($id,1));
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "7";
			die(print_r($e->getMessage()));
		}
	}
	function verificarFolioControlMET($conn,$folioControl,$idUniversidad){
		try {
			$sql = "SELECT idMET FROM met WHERE idInstitucion = ? AND folioControl = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUniversidad,$folioControl,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			echo "8";
			die(print_r($e->getMessage()));
		}
	}
	function limpieza($cadena){
		$cadena = utf8_encode($cadena);
		return $cadena;
	}
	function generarFirmaMet($conn,$idMET){
		try {
			$sql = "SELECT * FROM met WHERE idMET = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idMET,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			foreach($registros as $row){
				$idInstitucion = $row["idInstitucion"];
				$idResponsable = $row["idResponsable"];
				$idCarrera = $row["idCarrera"];
				$nombre = limpieza($row["nombre"]);
				$apellidoPaterno = limpieza($row["apellidoPaterno"]);
				$apellidoMaterno = limpieza($row["apellidoMaterno"]);
				$curp = $row["curp"];
				$email = $row["email"];
				$folioControl = $row["folioControl"];
				$fechaInicioCarrera = $row["fechaInicioCarrera"];
				$fechaTerminacionCarrera = $row["fechaTerminacionCarrera"];
				$fechaExpedicion = $row["fechaExpedicion"];
				$idModalidadTitulacion = $row["idModalidadTitulacion"];
				$fechaExamenProfesional = $row["fechaExamenProfesional"];
				$fechaExcencionProfesional = $row["fechaExcencionProfesional"];
				$servicioSocial = limpieza($row["servicioSocial"]);
				$idServicio = $row["idServicio"];
				$idEntidadExpedicion = $row["idEntidadExpedicion"];
				$institucionProcedencia = limpieza($row["institucionProcedencia"]);
				$idTipoEstudio = $row["idTipoEstudio"];
				$idEntidadAntecedente = $row["idEntidadAntecedente"];
				$fechaInicioAntecdente = $row["fechaInicioAntecdente"];
				$fechaFinalAntecdente = $row["fechaFinalAntecdente"];

			}

			list($infoAntecedente,$contadorInfoAntecedente) = obtenerCatalogoAntecedenteEspecifico($conn,$idTipoEstudio);
			foreach($infoAntecedente as $infA){
				$tipoEstudio = limpieza($infA["estudio"]);
			}

			list($infoEntidad,$contadorInfoEntidad) = obtenerCatalogoEntidadesEspecifico($conn,$idEntidadExpedicion);
			foreach($infoEntidad as $ine){
				$entidadExpedicion = limpieza($ine["entidad"]);
			}

			list($infoEntidad,$contadorInfoEntidad) = obtenerCatalogoEntidadesEspecifico($conn,$idEntidadAntecedente);
			foreach($infoEntidad as $ine){
				$entidadAntecedente = limpieza($ine["entidad"]);
			}

			list($infoServicio,$contadorInfoServicio) = obtenerCatalogoServicioEspecifico($conn,$idServicio);
			foreach($infoServicio as $insS){
				$servicio = limpieza($insS["fundamento"]);
			}

			list($informacionTipoTitulacion,$contadorInformacionTitulacion) = obtenerCatalogoTitulacionesEspecifico($conn,$idModalidadTitulacion);
			foreach($informacionTipoTitulacion as $in){
				$modalidadTitulacion = limpieza($in["modalidad"]);
			} 

			list($infoInstitucion,$contadorInfoInstitucion) = obtenerInstucion($conn,$idInstitucion);
			foreach($infoInstitucion as $infI){
				$nombreInstitucion = limpieza($infI["nombre"]);
				$claveInstitucion = limpieza($infI["clave"]);
			}

			list($infoCarrera,$contadorInfoCarrera) = obtenerCarrera($conn,$idCarrera);
			foreach($infoCarrera as $infC){
				$nombreCarrera = $infC["nombre"];
				$claveCarrera = limpieza($infC["clave"]);
				$rvoeCarrera = limpieza($infC["rvoe"]);
				$idAutorizacionCarrera = $infC["idAutorizacion"];

				list($now,$contNow) = obtenerCatalogoAutorizacionEspecifico($conn,$idAutorizacionCarrera);
				foreach($now as $now){
					$autorizacionCarrera = limpieza($now["autorizacion"]);
				}
			}

			list($infoRespomsable,$contadorInfoResponsable) = obtenerResponsable($conn,$idResponsable);
			foreach($infoRespomsable as $infR){
				$idCargoResponsable = $infR["idCargo"];
				$nombreRespomsable = limpieza($infR["nombre"]);
				$apellidoPaternoResponsable = limpieza($infR["apellidoPaterno"]);
				$apellidoMaternoResponsable = limpieza($infR["apellidoMaterno"]);
				$curpResponsable = $infR["curp"];
				$cerFile = $infR["cerFile"];
				$keyFile = $infR["keyFile"];

				list($now2,$contNow2) = obtenerCargoEspecifico($conn,$idCargoResponsable);
				foreach($now2 as $nw){
					$cargoResponsable = limpieza($nw["cargo"]);
				}
			}
			$versionXMLFormat = "1.0";
			$abrTituloFormat = "";
			$noCedulaFormat = "";
			$cadena = '||'. $versionXMLFormat.'|'. $folioControl.'|'. $curpResponsable.'|'.$idCargoResponsable.'|'.$cargoResponsable.'|'.$abrTituloFormat.'|'.$claveInstitucion.'|'.$nombreInstitucion.'|'.$claveCarrera.'|'.$nombreCarrera.'|'.$fechaInicioCarrera.'|'.$fechaTerminacionCarrera.'|'.$idAutorizacionCarrera.'|'.$autorizacionCarrera.'|'.$rvoeCarrera.'|'.$curp.'|'.$nombre.'|'.$apellidoPaterno.'|'.$apellidoMaterno.'|'.$email.'|'.$fechaExpedicion.'|'.$idModalidadTitulacion.'|'.$modalidadTitulacion.'|'.$fechaExamenProfesional.'|'.$fechaExcencionProfesional.'|'.$servicioSocial.'|'.$idServicio.'|'.$servicio.'|'.$idEntidadExpedicion.'|'.$entidadExpedicion.'|'.$institucionProcedencia.'|'.$idTipoEstudio.'|'.$tipoEstudio.'|'.$idEntidadAntecedente.'|'.$entidadAntecedente.'|'.$fechaInicioAntecdente.'|'.$fechaFinalAntecdente.'|'.$noCedulaFormat.'||';

			$private_file="files/firmas/".$keyFile;      // Ruta al archivo key con contraseña
			$public_file="files/firmas/".$cerFile;
			$private_key = openssl_get_privatekey(file_get_contents($private_file));
			openssl_sign($cadena,$Firma,$private_key, OPENSSL_ALGO_SHA256);
			openssl_free_key($private_key);
			$sello = base64_encode($Firma);

			$sql = "UPDATE met SET firma = ? WHERE idMET = ?";
			$parametros = array($sello,$idMET);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametros);

			return $sello;

		}catch(Exception $e){
			echo "9";
			die(print_r($e->getMessage()));

		}
	}
	function obtenerValidacionCURPAlumno($conn,$curp){
		try {
			$sql = "SELECT curp FROM met WHERE curp = ? and status = 1";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($curp);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			echo "10";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerTitulaciones($conn,$idUsuario){
		try {
			$sql = "SELECT * FROM met WHERE idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUsuario,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "11";
			die(print_r($e->getMessage()));
		}
	}
	
	function obtenerTitulo($conn,$idMET){
		try {
			$sql = "SELECT * FROM met WHERE idMET = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idMET);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);
			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "11";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerTitulacionesEspecifico($conn,$idUsuario){
		try {
			$sql = "SELECT * FROM met WHERE idMET = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUsuario,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "12";
			die(print_r($e->getMessage()));
		}
	}

	function verificarMET ($conn,$curp){
		try {
			$sql = "SELECT idMET FROM met WHERE curp = ? AND idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($curp,$_SESSION["idUser"],1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			echo "13";
			die(print_r($e->getMessage()));
		}
	}

	function verificarMET1 ($conn,$folioControl){
		try {
			$sql = "SELECT idMET FROM met WHERE folioControl = ? AND idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($folioControl,$_SESSION["idUser"],1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			echo "14";
			die(print_r($e->getMessage()));
		}
	}

	function obtenerEstatusMET($conn,$idEstatus){
		try {
			$sql = "SELECT * FROM estatus WHERE idEstatus = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute(array($idEstatus,1));
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);
			
			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "15";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerValidacionfolioControl($conn,$folioControl){
		try {
			$sql = "SELECT folioControl FROM met WHERE folioControl = ? and status = 1";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($folioControl);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return $contadorRegistros;
		}catch(Exception $e){
			echo "16";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCampus($conn,$idUsuario){
		try {
			$sql = "SELECT * FROM campus WHERE idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUsuario,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCampus1($conn,$idCampus){
		try {
			$sql = "SELECT * FROM campus WHERE idCampus = ? AND status=?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idCampus,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerEntidad($conn,$idEntidad){
		try {
			$sql = "SELECT * FROM catalogoEntidades WHERE idEntidad = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idEntidad,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCampusEspecifico($conn,$idUsuario){
		try {
			$sql = "SELECT * FROM campus WHERE idCampus = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUsuario,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			echo "12";
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoPeriodos($conn){
		try {
			$sql = "SELECT * FROM catalogoperiodo WHERE status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array(1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoModalidades($conn){
		try {
			$sql = "SELECT * FROM catalogomodalidad WHERE status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array(1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoCarreras($conn){
		try {
			$sql = "SELECT * FROM catalogocarreras WHERE status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array(1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerModalidad($conn,$idModalidad){
		try {
			$sql = "SELECT * FROM catalogomodalidad WHERE idCatalogoModalidad = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idModalidad);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoCarrera($conn,$idCatalogoCarreras){
		try {
			$sql = "SELECT * FROM catalogocarreras WHERE idCatalogoCarrera = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idCatalogoCarreras);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCatalogoPeriodo($conn,$idCatalogoPeriodo){
		try {
			$sql = "SELECT * FROM catalogoperiodo WHERE idCatalogoPeriodo = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idCatalogoPeriodo);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}

	function obtenerTipoAsignatura($conn){
		try {
			$sql = "SELECT * FROM catalogotipoasignatura WHERE  status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array(1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
	function obtenerCarrerasEspecificas($conn,$idUser){
		try {
			$sql = "SELECT * FROM carreras WHERE idUsuarioCreacion = ? AND status = ?";
			$ejectSQL = $conn->prepare($sql);
			$parametros = array($idUser,1);
			$ejectSQL->execute($parametros);
			$registros = $ejectSQL->fetchAll();
			$contadorRegistros = count($registros);

			return array($registros,$contadorRegistros);
		}catch(Exception $e){
			die(print_r($e->getMessage()));
		}
	}
?>