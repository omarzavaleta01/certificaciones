<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
//error_reporting(0);
date_default_timezone_set("America/Mexico_City");
include("conexion.php");
include("funciones.php");
include("herramientas/PHPExcel/PHPExcel/IOFactory.php");
if ($_SESSION["idUser"] == "") {
	header("Location: index.php?error=expired");
}
$opcion = $_REQUEST["action"];

if ($opcion == "altaUniversidad") {

	//Comienza el alta de la institución
	if ($_SESSION["token"] == $_REQUEST["csrf"]) {
		if (verificarUniversidad($conn, $_REQUEST["claveInstitucion"]) == 0) {
			$sql = "INSERT INTO instituciones (nombre,clave,usuarioQA,claveQA,usuarioProduccion,claveProduccion,idUsuarioCreacion,fechaCreacion,status) VALUES (?,?,?,?,?,?,?,?,?)";
			$parametros = array($_REQUEST["nombreInstitucion"], $_REQUEST["claveInstitucion"], $_REQUEST["usuarioQA"], $_REQUEST["claveQA"], $_REQUEST["usuarioProduccion"], $_REQUEST["claveProduccion"], $_SESSION["idUser"], date("Y-m-d H:i:s"), 1);
			$ejectSQL = $conn->prepare($sql);
			try {
				$ejectSQL->execute($parametros);
				$idInstitucion = $conn->lastInsertId();

				for ($i = 0; $i < count($_REQUEST["cargoResponsable"]); $i++) {
					$prefijo = substr(md5(uniqid(rand())), 0, 40);
					$ruta = "files/firmas";
					$archivo = $_FILES['fileCerResponsable']['tmp_name'][$i];
					$nombreArchivo = $_FILES['fileCerResponsable']['name'][$i];
					$filesize = $_FILES['fileCerResponsable']['size'][$i];
					$info = pathinfo($nombreArchivo);
					$mover = move_uploaded_file($archivo, $ruta . "/" . $prefijo . "_CER." . $info['extension']);
					$finalCER = $prefijo . "_CER." . $info['extension'];


					$archivo1 = $_FILES['fileKeyResponsable']['tmp_name'][$i];
					$nombreArchivo1 = $_FILES['fileKeyResponsable']['name'][$i];
					$filesize1 = $_FILES['fileKeyResponsable']['size'][$i];
					$info1 = pathinfo($nombreArchivo1);
					$mover1 = move_uploaded_file($archivo1, $ruta . "/" . $prefijo . "_KEY." . $info1['extension']);
					$finalKEY = $prefijo . "_KEY." . $info1['extension'];
					$claveNow = $_REQUEST["clavePrivadaResponsable"][$i];

					$ubicacionCER = $_SERVER["DOCUMENT_ROOT"] . "/certificacion/" . $ruta . "/" . $finalCER;
					$ubicacionKEY = $_SERVER["DOCUMENT_ROOT"] . "/certificacion/" . $ruta . "/" . $finalKEY;

					$finalUbicacionCER = $ubicacionCER . ".pem";
					$finalUbicacionKEY = $ubicacionKEY . ".pem";


					$keyPem = shell_exec('openssl pkcs8 -inform DER -in ' . $ubicacionKEY . ' -out ' . $finalUbicacionKEY . ' -passin pass:' . $claveNow);
					$cerPem = shell_exec('openssl x509 -inform DER -outform PEM -in ' . $ubicacionCER . ' -pubkey > ' . $finalUbicacionCER . '');

					unlink($ubicacionCER);
					unlink($ubicacionKEY);



					$sql = "INSERT INTO responsables (idInstitucion,idCargo,nombre,apellidoPaterno,apellidoMaterno,curp,cerFile,keyFile,idUsuarioCreacion,fechaCreacion,status,idProfesion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
					$parametros = array($idInstitucion, $_REQUEST["cargoResponsable"][$i], $_REQUEST["profesion"][$i], $_REQUEST["nombreResponsable"][$i], $_REQUEST["apellidoPaternoResponsable"][$i], $_REQUEST["apellidoMaternoResponsable"][$i], $_REQUEST["profesionResponsable"][$i], $_REQUEST["curpResponsable"][$i], $finalCER . ".pem", $finalKEY . ".pem", $_SESSION["idUser"], date("Y-m-d H:i:s"), 1);
					$ejectSQL = $conn->prepare($sql);
					$ejectSQL->execute($parametros);
				}

				header("Location: nuevaUniversidad.php?salida=success");
			} catch (Exception $e) {
				header("Location: nuevaUniversidad.php?salida=error");
				//die(print_r($e->getMessage()));
			}
		} else {
			header("Location: nuevaUniversidad.php?salida=repetido");
		}
	} else {
		header("Location: nuevaUniversidad.php?salida=missingdata");
	}
	//Termina el alta de la institución
} else if ($opcion == "eliminarInstitucion") {
	$idInstitucion = $_REQUEST["token"];
	$seguro = $_REQUEST["seguro"];

	if ($seguro == $_SESSION["token"]) {
		$sql = "UPDATE instituciones SET status = ?, idUsuarioEliminacion = ?, fechaEliminacion = ? WHERE idInstitucion = ?";
		$parametros = array(0, $_SESSION["idUser"], date("Y-m-d H:i:s"), $idInstitucion);
		$ejectSQL = $conn->prepare($sql);
		try {
			$ejectSQL->execute($parametros);
			$sql = "UPDATE responsables SET status = ? WHERE idInstitucion = ?";
			$parametros = array(0, $idInstitucion);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametros);
			header("Location: listadoInstituciones.php?salida=success");
		} catch (Exception $e) {
			header("Location: listadoInstituciones.php?salida=error");
		}
	} else {
		header("Location: listadoInstituciones.php?salida=missingdata");
	}
} else if ($opcion == "editarInstitucion") {
	$idInstitucion = $_REQUEST["idInstitucion"];
	list($institucion, $contadorInstitucion) = obtenerInstucion($conn, $idInstitucion);
	foreach ($institucion as $institucion) {
		$claveInstitucion = $institucion["clave"];
	}
	if ($_SESSION["token"] == $_REQUEST["csrf"]) {
		if ($claveInstitucion == $_REQUEST["claveInstitucion"]) {
			$sql = "UPDATE instituciones SET nombre = ?, clave = ?, usuarioQA = ?, claveQA = ?, usuarioProduccion = ?, claveProduccion = ?, idUsuarioModificacion = ?, fechaModificacion = ? WHERE idInstitucion = ?";
			$parametros = array($_REQUEST["nombreInstitucion"], $_REQUEST["claveInstitucion"], $_REQUEST["usuarioQA"], $_REQUEST["claveQA"], $_REQUEST["usuarioProduccion"], $_REQUEST["claveProduccion"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idInstitucion);
			$ejectSQL = $conn->prepare($sql);
			try {
				$ejectSQL->execute($parametros);
				header("Location: edicionInstitucion.php?token=$idInstitucion&salida=success");
			} catch (Exception $e) {
				//die(print_r($e->getMessage()));
				header("Location: edicionInstitucion.php?token=$idInstitucion&salida=error");
			}
		} else {
			if (verificarUniversidad($conn, $_REQUEST["claveInstitucion"]) == 0) {
				$sql = "UPDATE instituciones SET nombre = ?, clave = ?, usuarioQA = ?, claveQA = ?, usuarioProduccion = ?, claveProduccion = ?, idUsuarioModificacion = ?, fechaModificacion = ? WHERE idInstitucion = ?";
				$parametros = array($_REQUEST["nombreInstitucion"], $_REQUEST["claveInstitucion"], $_REQUEST["usuarioQA"], $_REQUEST["claveQA"], $_REQUEST["usuarioProduccion"], $_REQUEST["claveProduccion"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idInstitucion);
				$ejectSQL = $conn->prepare($sql);
				try {
					$ejectSQL->execute($parametros);
					header("Location: edicionInstitucion.php?token=$idInstitucion&salida=success");
				} catch (Exception $e) {
					//die(print_r($e->getMessage()));
					header("Location: edicionInstitucion.php?token=$idInstitucion&salida=error");
				}
			} else {
				header("Location: edicionInstitucion.php?token=$idInstitucion&salida=repetido");
			}
		}
	} else {
		header("Location: edicionInstitucion.php?token=" . $idInstitucion . "&salida=missingdata");
	}
} else if ($opcion == "editarResponsable") {
	$idInstitucion = $_REQUEST["idInstitucion"];
	$idResponsable = $_REQUEST["idResponsable"];

	if ($_SESSION["token"] == $_REQUEST["csrf"]) {

		$prefijo = substr(md5(uniqid(rand())), 0, 40);
		$ruta = "files/firmas";

		if ($_FILES["fileCerResponsable"]["name"] <> '') {

			$archivo = $_FILES['fileCerResponsable']['tmp_name'];
			$nombreArchivo = $_FILES['fileCerResponsable']['name'];
			$filesize = $_FILES['fileCerResponsable']['size'];
			$info = pathinfo($nombreArchivo);
			$mover = move_uploaded_file($archivo, $ruta . "/" . $prefijo . "_CER." . $info['extension']);
			$finalCER = $prefijo . "_CER." . $info['extension'];
			$ubicacionCER = $_SERVER["DOCUMENT_ROOT"] . "/certificacion/" . $ruta . "/" . $finalCER;
			$finalUbicacionCER = $ubicacionCER . ".pem";
			$cerPem = shell_exec('openssl x509 -inform DER -outform PEM -in ' . $ubicacionCER . ' -pubkey > ' . $finalUbicacionCER . '');
			unlink($ubicacionCER);

			list($infoResponsable, $contadorInfoResponsable) = obtenerResponsable($conn, $idResponsable);
			foreach ($infoResponsable as $res) {
				$cerFileAnterior = $res["cerFile"];
			}

			unlink($ruta . "/" . $cerFileAnterior);

			$sql = "UPDATE responsables SET cerFile = ? WHERE idInstitucion = ?";
			$parametros = array($finalCER . ".pem", $idInstitucion);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametros);
		}

		if ($_FILES["fileKeyResponsable"]["name"] <> '') {

			$archivo1 = $_FILES['fileKeyResponsable']['tmp_name'];
			$nombreArchivo1 = $_FILES['fileKeyResponsable']['name'];
			$filesize1 = $_FILES['fileKeyResponsable']['size'];
			$info1 = pathinfo($nombreArchivo1);
			$mover1 = move_uploaded_file($archivo1, $ruta . "/" . $prefijo . "_KEY." . $info1['extension']);
			$finalKEY = $prefijo . "_KEY." . $info1['extension'];

			$claveNow = $_REQUEST["clavePrivadaResponsable"];
			$ubicacionKEY = $_SERVER["DOCUMENT_ROOT"] . "/certificacion/" . $ruta . "/" . $finalKEY;
			$finalUbicacionKEY = $ubicacionKEY . ".pem";
			$keyPem = shell_exec('openssl pkcs8 -inform DER -in ' . $ubicacionKEY . ' -out ' . $finalUbicacionKEY . ' -passin pass:' . $claveNow);

			unlink($ubicacionKEY);

			list($infoResponsable, $contadorInfoResponsable) = obtenerResponsable($conn, $idResponsable);
			foreach ($infoResponsable as $res) {
				$keyFileAnterior = $res["keyFile"];
			}

			unlink($ruta . "/" . $keyFileAnterior);

			$sql = "UPDATE responsables SET keyFile = ? WHERE idInstitucion = ?";
			$parametros = array($finalKEY . ".pem", $idInstitucion);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametros);
		}

		$sql = "UPDATE responsables SET idCargo = ?, nombre = ?, apellidoPaterno = ?, apellidoMaterno = ?,curp = ?, idUsuarioModificacion = ?, fechaModificacion = ? WHERE idInstitucion = ?";
		$parametros = array($_REQUEST["cargoResponsable"], $_REQUEST["nombreResponsable"], $_REQUEST["apellidoPaternoResponsable"], $_REQUEST["apellidoMaternoResponsable"], $_REQUEST["curpResponsable"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idInstitucion);
		$ejectSQL = $conn->prepare($sql);
		try {
			$ejectSQL->execute($parametros);
			header("Location: editarResponsable.php?idResponsable=" . $idResponsable . "&token=" . $idInstitucion . "&salida=success");
		} catch (Exception $e) {
			header("Location: editarResponsable.php?idResponsable=" . $idResponsable . "&token=" . $idInstitucion . "&salida=error");
		}
	} else {
		header("Location: editarResponsable.php?idResponsable=" . $idResponsable . "&token=" . $idInstitucion . "&salida=missingdata");
	}
} else if ($opcion == "altaCarrera") {
	//Comienza el alta de la institución
	$idCarrera = $_REQUEST["idCarrera"];
	if ($_SESSION["token"] == $_REQUEST["csrf"]) {
		if (verificarCarrera($conn, $_REQUEST["institucion"], $_REQUEST["claveCarrera"], $_REQUEST["rvoe"]) == 0) {
			$sql = "INSERT INTO carreras (idInstitucion,idCatalogoCarrera,nombre,idCatalogoPeriodo,idCatalogoModalidad,clave,idAutorizacion,rvoe,fechaExpedicionRevoe,idUsuarioCreacion,fechaCreacion,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

			$parametros = array($_REQUEST["institucion"], $_REQUEST["tipoCarrera"], $_REQUEST["nombreCarrera"], $_REQUEST["periodoCarrera"], $_REQUEST["modalidadCarrera"], $_REQUEST["claveCarrera"], $_REQUEST["autorizacion"], $_REQUEST["rvoe"], $_REQUEST["fechaExpedicionRvoe"], $_SESSION["idUser"], date("Y-m-d H:i:s"), 1);

			$ejectSQL = $conn->prepare($sql);
			try {
				$ejectSQL->execute($parametros);
				header("Location: nuevaCarrera.php?salida=success");
				//header("Location: nuevaCarrera.php?token=$idCarrera&salida=success");
			} catch (Exception $e) {
				header("Location: nuevaCarrera.php?salida=error");
				//die(print_r($e->getMessage()));
			}
		} else {
			header("Location: nuevaCarrera.php?salida=repetido");
		}
	} else {
		header("Location: nuevaCarrera.php?salida=missingdata");
	}
} else if ($opcion == "editarCarrera") {
	$idCarrera = $_REQUEST["idCarrera"];
	list($carrera, $contadorCarrera) = obtenerCarrera($conn, $idCarrera);
	foreach ($carrera as $carrera) {
		$claveCarrera = $carrera["clave"];
		$rvoeCarrera = $carrera["rvoe"];
	}

	if ($_SESSION["token"] == $_REQUEST["csrf"]) {
		if ($claveCarrera == $_REQUEST["claveCarrera"]) {
			$sql = "UPDATE carreras SET idInstitucion = ?,idCatalogoCarrera =?,nombre = ?, idCatalogoPeriodo =?, idCatalogoModalidad = ?, clave=?, idAutorizacion = ?, rvoe = ?, fechaExpedicionRevoe =?, idUsuarioModificacion = ?, fechaModificacion = ? WHERE idCarrera = ?";
			$parametros = array($_REQUEST["institucion"], $_REQUEST["tipoCarrera"], $_REQUEST["nombreCarrera"], $_REQUEST["periodoCarrera"], $_REQUEST["modalidadCarrera"], $_REQUEST["claveCarrera"], $_REQUEST["autorizacion"], $_REQUEST["rvoe"], $_REQUEST["fechaExpedicionRvoe"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idCarrera);
			$ejectSQL = $conn->prepare($sql);
			try {
				$ejectSQL->execute($parametros);
				header("Location: edicionCarrera.php?token=$idCarrera&salida=success");
			} catch (Exception $e) {
				//die(print_r($e->getMessage()));
				header("Location: edicionCarrera.php?token=$idCarrera&salida=error");
			}
		} else {
			if (verificarCarrera1($conn, $_REQUEST["institucion"], $_REQUEST["claveCarrera"]) == 0) {
				$sql = "UPDATE carreras SET idInstitucion = ?,idCatalogoCarrera =?,nombre = ?, idCatalogoPeriodo =?, idCatalogoModalidad = ?, clave=?, idAutorizacion = ?, rvoe = ?, fechaExpedicionRevoe =?, idUsuarioModificacion = ?, fechaModificacion = ? WHERE idCarrera = ?";
				$parametros = array($_REQUEST["institucion"], $_REQUEST["tipoCarrera"], $_REQUEST["nombreCarrera"], $_REQUEST["periodoCarrera"], $_REQUEST["modalidadCarrera"], $_REQUEST["claveCarrera"], $_REQUEST["autorizacion"], $_REQUEST["rvoe"], $_REQUEST["fechaExpedicionRvoe"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idCarrera);


				$ejectSQL = $conn->prepare($sql);
				try {
					$ejectSQL->execute($parametros);
					header("Location: edicionCarrera.php?token=$idCarrera&salida=success");
				} catch (Exception $e) {
					//die(print_r($e->getMessage()));
					header("Location: edicionCarrera.php?token=$idCarrera&salida=error");
				}
			} else {
				header("Location: edicionCarrera.php?salida=repetido&token=$idCarrera");
			}
		}
	} else {
		header("Location: edicionCarrera.php?token=" . $idCarrera . "&salida=missingdata");
	}
} else if ($opcion == "altaMET") {

	if ($_REQUEST["csrf"] == $_SESSION["token"]) {

		$idInstitucion = $_REQUEST["institucion"];
		$idResponsable = $_REQUEST["responsable"];
		$idCarrera = $_REQUEST["carrera"];
		$salidaErrores = "";
		$contadorErrores = 0;

		$nombreArchivo = $_FILES["archivo"]["tmp_name"];
		//$nombreArchivo = "files/plantilla.xlsx";
		// Cargo la hoja de cálculo
		$objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);

		//Asigno la hoja de calculo activa
		$objPHPExcel->setActiveSheetIndex(0);
		//Obtengo el numero de filas del archivo
		$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

		echo '<link href="css/bootstrap.min.css" rel="stylesheet">';


		echo '<div class="col-lg-12"><hr><a href="index.php"><i class="fas fa-house-user"></i> Inicio</a> > <a href="AltaMET.php" >MET</a> > Alta de titulación<hr></div>';

		echo '<blockquote class="blockquote text-center"><h3 class="mb-0">Lista de alumnos subidos al sistema verificar cuales son correctos e incorrectos.</h3></blockquote>';

		echo '<div class="col-lg-2"><a href="AltaMET.php" class="btn btn-success btn-sm" title="Registrar una nueva titulacion"><i class="fas fa-plus"></i>Alta MET</a><a href="ListadoMET.php" class="btn btn-success btn-sm" title="Listado de titulaciones"><i class="fas fa-plus"></i>Listado MET</a></div> <br>';

		echo '<div class="container">';

		//aqui es donde empieza a leer el excel
		for ($i = 7; $i <= $numRows; $i++) {

			$folioControlR = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
			$folioControlR = trim($folioControlR);

			if ($folioControlR == "") {
				break;
			} else {

				$nombreR = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
				$nombreR = trim($nombreR);

				$apellidoPaternoR = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
				$apellidoPaternoR = trim($apellidoPaternoR);

				$apellidoMaternoR = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
				$apellidoMaternoR = trim($apellidoMaternoR);

				$curpR = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
				$curpR = trim($curpR);

				$idAutorizacion = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
				$idAutorizacion = trim($idAutorizacion);


				$emailR = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
				$emailR = ($emailR);

				//fecha de inicio de la carrera
				$fechaInicioCarreraR = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
				$fechaInicioCarreraR = trim($fechaInicioCarreraR);
				$fechaInicioCarreraR = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaInicioCarreraR));
				$fechaInicioCarreraR = date("Y-m-d", strtotime($fechaInicioCarreraR . '+1 day'));
				///echo $fechaInicioCarreraR; exit; // arreglarlo en todas las fechas

				//fecha de fin de la carrera
				$fechaFinCarreraR = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
				$fechaFinCarreraR = trim($fechaFinCarreraR);
				$fechaFinCarreraR = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaFinCarreraR));
				$fechaFinCarreraR = date("Y-m-d", strtotime($fechaFinCarreraR . '+1 day'));

				//fecha de expedicion proporcionado por la administracion
				$fechaExpedicionR = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getCalculatedValue();
				$fechaExpedicionR = trim($fechaExpedicionR);
				$fechaExpedicionR = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaExpedicionR));
				$fechaExpedicionR  = date("Y-m-d", strtotime($fechaExpedicionR . '+1 day'));

				$modalidadTitulacionR = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getCalculatedValue();
				$modalidadTitulacionR = trim($modalidadTitulacionR);

				$fechaExamenProfesionalR = $objPHPExcel->getActiveSheet()->getCell('O' . $i)->getCalculatedValue();
				$fechaExamenProfesionalR = trim($fechaExamenProfesionalR);
				if ($fechaExamenProfesionalR == "") {
					$fechaExamenProfesionalR = "";
				} else {
					$fechaExamenProfesionalR = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaExamenProfesionalR));
					$fechaExamenProfesionalR = date("Y-m-d", strtotime($fechaExamenProfesionalR . '+1 day'));
				}

				$fechaExcencionExamenProfesionalR = $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getCalculatedValue();
				$fechaExcencionExamenProfesionalR = trim($fechaExcencionExamenProfesionalR);
				if ($fechaExcencionExamenProfesionalR == "") {
					$fechaExcencionExamenProfesionalR = null;
				} else {
					$fechaExcencionExamenProfesionalR = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaExcencionExamenProfesionalR));
					$fechaExcencionExamenProfesionalR = date("Y-m-d", strtotime($fechaExcencionExamenProfesionalR . '+1 day'));
				}

				$servicioSocialR = $objPHPExcel->getActiveSheet()->getCell('Q' . $i)->getCalculatedValue();
				$servicioSocialR = trim($servicioSocialR);

				$fundamentoServicioSocialR = $objPHPExcel->getActiveSheet()->getCell('R' . $i)->getCalculatedValue();
				$fundamentoServicioSocialR = trim($fundamentoServicioSocialR);

				$entidadExpedicionR = $objPHPExcel->getActiveSheet()->getCell('S' . $i)->getCalculatedValue();
				$entidadExpedicionR = trim($entidadExpedicionR);

				$institucionAntedenteR = $objPHPExcel->getActiveSheet()->getCell('T' . $i)->getCalculatedValue();
				$institucionAntedenteR = trim($institucionAntedenteR);

				$tipoEstudioAntecedenteR = $objPHPExcel->getActiveSheet()->getCell('U' . $i)->getCalculatedValue();
				$tipoEstudioAntecedenteR = trim($tipoEstudioAntecedenteR);

				$entidadAntecedenteR = $objPHPExcel->getActiveSheet()->getCell('V' . $i)->getCalculatedValue();
				$entidadAntecedenteR = trim($entidadAntecedenteR);

				//fecha de inicio de la institucion de procedencia
				$fechaInicioAntecedenteR = $objPHPExcel->getActiveSheet()->getCell('W' . $i)->getCalculatedValue();
				$fechaInicioAntecedenteR = trim($fechaInicioAntecedenteR);
				$fechaInicioAntecedenteR = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaInicioAntecedenteR));
				$fechaInicioAntecedenteR = date("Y-m-d", strtotime($fechaInicioAntecedenteR . '+1 day'));
				//fecha de fin de la institucion de procedencia
				$fechaFinalAntecedenteR = $objPHPExcel->getActiveSheet()->getCell('X' . $i)->getCalculatedValue();
				$fechaFinalAntecedenteR = trim($fechaFinalAntecedenteR);
				$fechaFinalAntecedenteR = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaFinalAntecedenteR));
				$fechaFinalAntecedenteR = date("Y-m-d", strtotime($fechaFinalAntecedenteR . '+1 day'));


				$usuario = $_SESSION["idUser"];
				$fecha = date("Y-m-d H:i:s");

				$idAutorizacion = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
				$idAutorizacion = trim($idAutorizacion);

				$noCedula = $objPHPExcel->getActiveSheet()->getCell('Y' . $i)->getCalculatedValue();
				$noCedula = trim($noCedula);
				if ($noCedula == "") {
					$noCedula = null;
				}

				$idEstatus = 1;

				/*	
					for($i=0;$i<count($_REQUEST["alumno"]);$i++){
					$verificacion = verificarFolioControlMET($conn,$_REQUEST["folioControl"],$idInstitucion);
					if($verificacion == 0){
					$nombreR = $_REQUEST["alumno"][$i];
					$apellidoPaternoR = $_REQUEST["apellidoPaterno"][$i];
					$apellidoMaternoR = $_REQUEST["apellidoMaterno"][$i];
					$curpR = $_REQUEST["curp"][$i];
					$emailR = $_REQUEST["email"][$i];
					$folioControlR = $_REQUEST["folioControl"][$i];
					$fechaInicioCarreraR = $_REQUEST["fechaInicioCarrera"][$i];
					$fechaFinCarreraR = $_REQUEST["fechaFinCarrera"][$i];
					$fechaExpedicionR = $_REQUEST["fechaExpedicion"][$i];
					$modalidadTitulacionR = $_REQUEST["modalidadTitulacion"][$i];
					$fechaExamenProfesionalR = $_REQUEST["fechaExamenProfesional"][$i];
					$fechaExcencionExamenProfesionalR = $_REQUEST["fechaExcencionExamenProfesional"][$i];
					$servicioSocialR = $_REQUEST["servicioSocial"][$i];
					$fundamentoServicioSocialR = $_REQUEST["fundamentoServicioSocial"][$i];
					$entidadExpedicionR = $_REQUEST["entidadExpedicion"][$i];

					$institucionAntedenteR = $_REQUEST["institucionAntecedente"][$i];
					$tipoEstudioAntecedenteR = $_REQUEST["tipoEstudioAntecedente"][$i];
					$entidadAntecedenteR = $_REQUEST["entidadAntecedente"][$i];
					$fechaInicioAntecedenteR = $_REQUEST["fechaInicioAntecedente"][$i];
					$fechaFinalAntecedenteR = $_REQUEST["fechaFinAntecedente"][$i];
					usuario = $_SESSION["idUser"];
					fecha = date("Y-m-d H:i:s");**/

				$sql = "INSERT INTO met (idInstitucion,idResponsable,idCarrera,nombre,apellidoPaterno,apellidoMaterno,curp,email,folioControl,fechaInicioCarrera,fechaTerminacionCarrera,fechaExpedicion,idModalidadTitulacion,fechaExamenProfesional,fechaExcencionProfesional,servicioSocial,idServicio,idEntidadExpedicion,institucionProcedencia,idTipoEstudio,idEntidadAntecedente,fechaInicioAntecdente,fechaFinalAntecdente,idUsuarioCreacion,fechaCreacion,status,idAutorizacion,noCedula, idEstatus) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

				$parametros = array($idInstitucion, $idResponsable, $idCarrera, $nombreR, $apellidoPaternoR, $apellidoMaternoR, $curpR, $emailR, $folioControlR, $fechaInicioCarreraR, $fechaFinCarreraR, $fechaExpedicionR, $modalidadTitulacionR, $fechaExamenProfesionalR, $fechaExcencionExamenProfesionalR, $servicioSocialR, $fundamentoServicioSocialR, $entidadExpedicionR, $institucionAntedenteR, $tipoEstudioAntecedenteR, $entidadAntecedenteR, $fechaInicioAntecedenteR, $fechaFinalAntecedenteR, $usuario, $fecha, 1, $idAutorizacion, $noCedula, $idEstatus);
				$ejectSQL = $conn->prepare($sql);

				try {

					$curpR = ($curpR);
					$curpNo = strlen($curpR);
					if (($curpNo < 17) or ($curpNo > 18)) {
						echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que el CURP no contiene el numero de caracteres apropiados.</div>';
					} else {
						$verificacionCURP = obtenerValidacionCURPAlumno($conn, $curpR); 
						if ($verificacionCURP >= 1) {
							echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que ya se encuentra registrado un alumno con el mismo CURP.</div>';
						} else {
							$contadorFolio = obtenerValidacionfolioControl($conn, $folioControlR);
							if ($contadorFolio >= 1) {
								echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . 'debido a que ya se encuentra registrado anteriormente con el mismo folio.</div>';
							} else {
								if ($fechaInicioCarreraR >= $fechaFinCarreraR) {
									echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que la fecha de inicio de carrera no puede ser menor a la fecha de termino.</div>';
								} else {
									if (($idAutorizacion < 1) or ($idAutorizacion > 9)) {
										echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que el idCargo no se ingreso correctamente, verificar en "Cargo firmantes autorizados" el id correcto.</div>';
									} else {
										if (($modalidadTitulacionR < 1) or ($modalidadTitulacionR > 6)) {
											echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que el idModalidadTitulación no se ingreso correctamente, verificar en "Modalidad titulación" el id correcto.</div>';
										} else {
											if (($servicioSocialR < 0) or ($servicioSocialR > 1)) {
												echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que cumplioServicioSocial no se ingreso correctamente, verificar que el valor sea 1 o 0.</div>';
											} else {
												if (($fundamentoServicioSocialR < 1) or ($fundamentoServicioSocialR > 5)) {
													echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que el idFundamentoLegalServicioSocial no se ingreso correctamente, verificar en "Fundamento Legal Serv. Social" el id correcto.</div>';
												} else {
													if (($entidadExpedicionR < 1) or ($entidadExpedicionR > 33)) {
														echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que el idEntidadFederativa no se ingreso correctamente, verificar en "Entidades Federativas" el id correcto</div>';
													} else {
														if (($tipoEstudioAntecedenteR < 1) or ($tipoEstudioAntecedenteR > 6)) {
															echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que el idTipoAntecedente no se ingreso correctamente, verificar en "Estudio Antecedente" el id correcto</div>';
														} else {
															if ($fechaInicioAntecedenteR >= $fechaFinalAntecedenteR) {
																echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que la fecha de termino no puede ser menor a la fecha de inicio de la institucion de procedencia.</div>';
															} else {
																if (($entidadAntecedenteR < 1) or ($entidadAntecedenteR > 33)) {
																	echo '<div class="alert alert-danger" role="alert">Error al registrar al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . ' debido a que el idEntidadFederativa no se ingreso correctamente, verificar en "Entidades federativas" el id correcto</div>';
																} else {
																	$ejectSQL->execute($parametros);
																	$idInsertado = $conn->lastInsertId();
																	generarFirmaMet($conn, $idInsertado);
																	echo '<div class="alert alert-success" role="alert">Se registró correctamente al alumn@: ' . $nombreR . ' ' . $apellidoPaternoR . ' ' . $apellidoMaternoR . '.</div>';
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				} catch (Exception $e) {
					die(print_r($e->getMessage()));
				}
		echo '</div>';
			}
		}
	}
} else if ($opcion == "eliminarMET") {
	$idMET = $_REQUEST["token"];
	$seguro = $_REQUEST["seguro"];

	if ($seguro == $_SESSION["token"]) {

		$sql = "UPDATE met SET status = ?, idUsuarioEliminacion = ?, fechaEliminacion = ? WHERE idMET = ?";

		$parametros = array(0, $_SESSION["idUser"], date("Y-m-d H:i:s"), $idMET);
		$ejectSQL = $conn->prepare($sql);

		try {
			$ejectSQL->execute($parametros);
			$sql = "UPDATE met SET status = ? WHERE idMET = ?";
			$parametros = array(0, $idMET);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametros);
			header("Location: listadoMET.php?salida=success");
		} catch (Exception $e) {
			header("Location: listadoMET.php?salida=error");
		}
	} else {
		header("Location: listadoMET.php?salida=missingdata");
	}
} else if ($opcion == "editarMET") {
	$idMET = $_REQUEST["idMET"];

	list($titulaciones, $contadorTitulaciones) = obtenerTitulo($conn, $idMET);
	foreach ($titulaciones as $titulaciones) {
		$curp = $titulaciones["curp"];
		$folioControl = $titulaciones["folioControl"];
	}

	if ($_SESSION["token"] == $_REQUEST["csrf"]) {

		if ($curp == $_REQUEST["curp"]) {

			$sql = "UPDATE met SET nombre = ?, apellidoPaterno = ?, apellidoMaterno = ?, curp = ?, email = ?, folioControl = ?, fechaInicioCarrera = ?, fechaTerminacionCarrera = ?, fechaExpedicion = ?, idModalidadTitulacion = ?, fechaExamenProfesional = ?, fechaExcencionProfesional = ?, servicioSocial = ?, idServicio = ?, idEntidadExpedicion = ?, institucionProcedencia = ?, idTipoEstudio = ?, idEntidadAntecedente = ?, fechaInicioAntecdente = ?, fechaFinalAntecdente = ?, idUsuarioModificacion = ?, fechaModificacion = ? WHERE idMET = ?";

			$parametros = array($_REQUEST["alumno"], $_REQUEST["apellidoPaterno"], $_REQUEST["apellidoMaterno"], $_REQUEST["curp"], $_REQUEST["email"], $_REQUEST["folioControl"], $_REQUEST["fechaInicioCarrera"], $_REQUEST["fechaFinCarrera"], $_REQUEST["fechaExpedicion"], $_REQUEST["modalidadTitulacion"], $_REQUEST["fechaExamenProfesional"], $_REQUEST["fechaExcencionExamenProfesional"], $_REQUEST["servicioSocial"], $_REQUEST["fundamentoServicioSocial"], $_REQUEST["entidadExpedicion"], $_REQUEST["institucionAntecedente"], $_REQUEST["tipoEstudioAntecedente"], $_REQUEST["entidadAntecedente"], $_REQUEST["fechaInicioAntecedente"], $_REQUEST["fechaFinAntecedente"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idMET);


			$ejectSQL = $conn->prepare($sql);

			try {
				$curp = $_REQUEST["curp"];
				$curpNo = strlen($_REQUEST["curp"]);
				if (($curpNo <= 17) or ($curpNo > 18)) {
					header("Location: editarMET.php?salida=errorC&token=$idMET");
					//echo '<div class="alert alert-danger" role="alert">Error al modificar al alumn@: debido a que el CURP no se ingreso correctamente, verificar que el CURP tenga el numero de caracteres apropiado</div>';
				}
				// else {
				// 		if ($_REQUEST["fechaInicioCarrera"] >= $_REQUEST["fechaFinCarrera"]) {
				// 			header("Location: editarMET.php?salida=errorF&token=$idMET");
				// 			//echo '<div class="alert alert-danger" role="alert">Error al modificar al alumn@: debido a que la fecha de fin de la carrea no puede ser mayor a la fecha de inicio, verificar las fechas ingresadas</div>';
				// 		} else {
				// 			if ($REQUEST_["fechaInicioAntecedente"] >= $REQUEST_["fechaFinAntecedente"]) {
				// 				header("Location: editarMET.php?salida=errorF&token=$idMET");
				// 				//echo '<div class="alert alert-danger" role="alert">Error al modificar al alumn@: debido a que la fecha de fin de la carrea no puede ser mayor a la fecha de inicio, verificar las fechas ingresadas</div>';
				// 			} else 
				{
					$ejectSQL->execute($parametros);
					header("Location: editarMET.php?token=$idMET&salida=success");
				}
				// 	}
				// }

			} catch (Exception $e) {
				die(print_r($e->getMessage()));
				header("Location: editarMET.php?token=$idMET&salida=error");
			}
		} else {
			if (verificarMET($conn, $_REQUEST["curp"]) == 0) {
				$sql = "UPDATE met SET nombre = ?, apellidoPaterno =?, apellidoMaterno = ?, curp = ?, email = ?, folioControl = ?, fechaInicioCarrera = ?, fechaTerminacionCarrera = ?, fechaExpedicion = ?, idModalidadTitulacion = ?, fechaExamenProfesional = ?, fechaExcencionProfesional = ?, servicioSocial = ?, idServicio = ?, idEntidadExpedicion = ?, institucionProcedencia = ?, idTipoEstudio = ?, idEntidadAntecedente = ?, fechaInicioAntecdente = ?, fechaFinalAntecdente = ?, idUsuarioModificacion = ?, fechaModificacion = ? WHERE idMET = ?";

				$parametros = array($_REQUEST["alumno"], $_REQUEST["apellidoPaterno"], $_REQUEST["apellidoMaterno"], $_REQUEST["curp"], $_REQUEST["email"], $_REQUEST["folioControl"], $_REQUEST["fechaInicioCarrera"], $_REQUEST["fechaFinCarrera"], $_REQUEST["fechaExpedicion"], $_REQUEST["modalidadTitulacion"], $_REQUEST["fechaExamenProfesional"], $_REQUEST["fechaExcencionExamenProfesional"], $_REQUEST["servicioSocial"], $_REQUEST["fundamentoServicioSocial"], $_REQUEST["entidadExpedicion"], $_REQUEST["institucionAntecedente"], $_REQUEST["tipoEstudioAntecedente"], $_REQUEST["entidadAntecedente"], $_REQUEST["fechaInicioAntecedente"], $_REQUEST["fechaFinAntecedente"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idMET);

				$ejectSQL = $conn->prepare($sql);
				try {
					$ejectSQL->execute($parametros);
					header("Location: editarMET.php?token=$idMET&salida=success");
				} catch (Exception $e) {
					//die(print_r($e->getMessage()));
					header("Location: editarMET.php?token=$idMET&salida=error");
				}
			} else {
				header("Location: editarMET.php?salida=errorC&token=$idMET");
			}
		}
	}
} else if ($opcion == "altaCampus") {

	//Comienza el alta de la institución
	if ($_SESSION["token"] == $_REQUEST["csrf"]) {

		$sql = "INSERT INTO campus (idInstitucion,numeroCampus,nombre,idEntidad,idUsuarioCreacion,status,fechaCreacion) VALUES (?,?,?,?,?,?,?)";
		$parametros = array($_REQUEST["institucion"], $_REQUEST["noCampus"], $_REQUEST["nombreCampus"], $_REQUEST["entidadExpedicion"], $_SESSION["idUser"], 1, date("Y-m-d H:i:s"));
		$ejectSQL = $conn->prepare($sql);
		try {
			$ejectSQL->execute($parametros);
			header("Location: listadoCampus.php?salida=success");
		} catch (Exception $e) {
			header("Location: nuevoCampus.php?salida=error");
			//die(print_r($e->getMessage()));
		}
	} else {
		header("Location: nuevoCampus.php?salida=missingdata");
	}
} else if ($opcion == "eliminarCampus") {
	$idCampus = $_REQUEST["token"];
	$seguro = $_REQUEST["seguro"];

	if ($seguro == $_SESSION["token"]) {

		$sql = "UPDATE campus SET status = ?, idUsuarioEliminacion = ?, fechaEliminacion = ? WHERE idCampus = ?";

		$parametros = array(0, $_SESSION["idUser"], date("Y-m-d H:i:s"), $idCampus);
		$ejectSQL = $conn->prepare($sql);

		try {
			$ejectSQL->execute($parametros);
			$sql = "UPDATE campus SET status = ? WHERE idCampus = ?";
			$parametros = array(0, $idCampus);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametros);
			header("Location: listadoCampus.php?salida=success");
		} catch (Exception $e) {
			header("Location: listadoCampus.php?salida=error");
		}
	} else {
		header("Location: listadoCampus.php?salida=missingdata");
	}
} else if ($opcion == "editarCampus") {
	$idCampus = $_REQUEST["idCampus"];

	list($campus, $contadorCampus) = obtenerCampus1($conn, $idCampus);
	foreach ($campus as $campus) {
		$nombreCampus = $campus["nombre"];
		$numeroCampus = $campus["numeroCampus"];
		$idInstitucion = $campus["idInstitucion"];
	}

	if ($_SESSION["token"] == $_REQUEST["csrf"]) {
		//if ($nombreCampus == $_REQUEST["nombreCampus"]) {
			$sql = "UPDATE campus SET nombre =?, idInstitucion =?, numeroCampus =?, idEntidad =?, idUsuarioModificacion =?, fechaModificacion = ? WHERE idCampus = ?";
			$parametros = array($_REQUEST["nombreCampus"], $_REQUEST["institucion"], $_REQUEST["noCampus"], $_REQUEST["idEntidad"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idCampus);
			$ejectSQL = $conn->prepare($sql);
			try {
				$ejectSQL->execute($parametros);
				header("Location: listadoCampus.php?token=$idCampus&salida=success");
			} catch (Exception $e) {
				//die(print_r($e->getMessage()));
				header("Location: editarCampus.php?token=$idCampus&salida=error");
			}
		//} else {
			if (verificarCampus1($conn, $_REQUEST["noCampus"]) == 0) {
				$sql = "UPDATE campus SET nombre =?, idInstitucion =?, numeroCampus =?, idEntidad =?, idUsuarioModificacion =?, fechaModificacion = ? WHERE idCampus = ?";
				$parametros = array($_REQUEST["nombreCampus"], $_REQUEST["institucion"], $_REQUEST["noCampus"], $_REQUEST["idEntidad"], $_SESSION["idUser"], date("Y-m-d H:i:s"), $idCampus);

				$ejectSQL = $conn->prepare($sql);
				try {
					$ejectSQL->execute($parametros);
					header("Location: listadoCampus.php?token=$idCampus&salida=success");
				} catch (Exception $e) {
					//die(print_r($e->getMessage()));
					header("Location: editarCampus.php?token=$idCampus&salida=error");
				}
			} else {
				header("Location: editarCampus.php?salida=repetido&token=$idCampus");
			}
		//}
	} else {
		header("Location: editarCampus.php?token=" . $idCampus . "&salida=missingdata");
	}
} else if ($opcion == "eliminarCarrera") {
	$idCarrera = $_REQUEST["token"];
	$seguro = $_REQUEST["seguro"];

	if ($seguro == $_SESSION["token"]) {

		$sql = "UPDATE carreras SET status = ?, idUsuarioEliminacion = ?, fechaEliminacion = ? WHERE idCarrera = ?";

		$parametros = array(0, $_SESSION["idUser"], date("Y-m-d H:i:s"), $idCarrera);
		$ejectSQL = $conn->prepare($sql);

		try {
			$ejectSQL->execute($parametros);
			$sql = "UPDATE carreras SET status = ? WHERE idCarrera = ?";
			$parametros = array(0, $idCarrera);
			$ejectSQL = $conn->prepare($sql);
			$ejectSQL->execute($parametros);
			header("Location: listadoCarreras.php?salida=success");
		} catch (Exception $e) {
			header("Location: listadoCarreras.php?salida=error");
		}
	} else {
		header("Location: listadoCarreras.php?salida=missingdata");
	}
} else if ($opcion === "altaAsignatura"){
	//Comienza el alta de la institución
	$idCarrera = $_REQUEST["idCarrera"];
	if ($_SESSION["token"] == $_REQUEST["csrf"]) {
		$sql = "INSERT INTO mapaCurricular (idCarrera, nombreAsignatura,claveAsignatura,idTipoAsignatura, status) VALUES (?,?,?,?,?)";
		$parametros = array($_REQUEST["idCarrera"],$_REQUEST["nombreAsignatura"], $_REQUEST["claveAsignatura"], $_REQUEST["tipoCarrera"], 1);
		$ejectSQL = $conn->prepare($sql);
		try {
			$ejectSQL->execute($parametros);
			header("Location: nuevoPlanEstudios.php?salida=success");
		} catch (Exception $e) {
			//header("Location: nuevoPlanEstudios.php?salida=error");
			//die(print_r($e->getMessage()));
		}
	} else {
		header("Location: nuevoPlanEstudios.php?salida=missingdata");
	}

}else if ($opcion == "altaAsignatura1"){
	for($i=0;$i<count($_REQUEST["nombreAsignatura"]);$i++){

		$idCarrera = $_REQUEST["idCarrera"][$i];
		$nombreAsignatura = $_REQUEST["nombreAsignatura"][$i];
		$claveAsignatura = $_REQUEST["claveAsignatura"][$i];
		$idTipoAsignatura = $_REQUEST["tipoCarrera"][$i];

		$sql = "INSERT INTO mapaCurricular (idCarrera, nombreAsignatura,claveAsignatura,idTipoAsignatura, status) VALUES (?,?,?,?,?)";
		//$parametros = array($_REQUEST["idCarrera"],$_REQUEST["nombreAsignatura"], $_REQUEST["claveAsignatura"], $_REQUEST["tipoCarrera"], 1);
		//$parametros = array($_REQUEST["idCarrera"][$i],$_REQUEST["nombreAsignatura"][$i], $_REQUEST["claveAsignatura"][$i], $_REQUEST["tipoCarrera"][$i], 1);
		$parametros = array($idCarrera, $nombreAsignatura, $claveAsignatura, $idTipoAsignatura,1);
		$ejectSQL = $conn->prepare($sql);
		try {
			$ejectSQL->execute($parametros);
			header("Location: nuevoPlanEstudios.php?salida=success");
		} catch (Exception $e) {
			//header("Location: nuevoPlanEstudios.php?salida=error");
			//die(print_r($e->getMessage()));
		}
	}	
}

else {
	//header("Location: editarMET.php?token=" . $idMET . "S&salida=missingdata");
}
