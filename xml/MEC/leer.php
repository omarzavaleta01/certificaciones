<?php
error_reporting(1);

	function pre($array){
		echo '<pre>';
			print_r($array);
		echo '</pre>';
	}

	require 'Classes/PHPExcel/IOFactory.php'; //Agregamos la librería 
	require 'conexion.php'; //Agregamos la conexión
	require 'pdo.php';
	
	 // $clave es la contraseña del archivo .key
	
	$cer = "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";
	
	//Variable con el nombre del archivo
	$nombreArchivo = 'plantillaCertificacion.xlsx';
	// Cargo la hoja de cálculo
	$objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
	
	//Asigno la hoja de calculo activa
	$objPHPExcel->setActiveSheetIndex(0);
	//Obtengo el numero de filas del archivo
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	//Obtengo el numero de columnas del archivo
	$numColumns = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn(); 
	
	echo '<STRONG>CADENA ORIGINAL</STRONG>';
	
	$valor = array();
	
	for ($i = 7; $i <= $numRows; $i++) {
		
		$alumno = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$alumnoFormat = trim($alumno);

		$versionXML = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$versionXMLFormat = trim($versionXML);

		$tipoCertificado = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$tipoCertificadoFormat = trim($tipoCertificado);

		$idNombreInstitucion = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$idNombreInstitucionFormat = trim($idNombreInstitucion);

		$idCampus = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$idCampusFormat = trim($idCampus);

		$idEntidadFederativa = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$idEntidadFederativaFormat = trim($idEntidadFederativa);

		$curpResponsable = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		$curpResponsableFormat = trim($curpResponsable);

		$responsableIDCargo = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
		$responsableIDCargoFormat = trim($responsableIDCargo);

		$numeroRvoe = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
		$numeroRvoeFormat = trim($numeroRvoe);

		$fechaExpedicionRVOE = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
		$fechaExpedicionRVOEFormat = trim($fechaExpedicionRVOE);
		
		$idCarrera = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
		$idCarreraFormat = trim($idCarrera);

		$idTipoPeriodo = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
		$idTipoPeriodoFormat = trim($idTipoPeriodo);

		$carreraClavePlan = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
		$carreraClavePlanFormat = trim($carreraClavePlan);

		$idNivelDeEstudios = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
		$idNivelDeEstudiosFormat = trim($idNivelDeEstudios);

		$califMinima = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
		$califMinimaFormat = trim($califMinima);

		$califMaxima = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
		$califMaximaFormat = trim($califMaxima);

		$CalifMinimaAprobatoria = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
		$CalifMinimaAprobatoriaFormat = trim($CalifMinimaAprobatoria);

		$numeroControlAlumno = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
		$numeroControlAlumnoFormat = trim($numeroControlAlumno);

		$curpAlumno = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
		$curpAlumnoFormat = trim($curpAlumno);

		$nombresAlumno = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
		$nombresAlumnoFormat = trim($nombresAlumno);

		$apellidoPaterno = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
		$apellidoPaternoFormat = ($apellidoPaterno);

		$apellidoMaterno = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
		$apellidoMaternoFormat = trim($apellidoMaterno);

		$idGenero = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
		$idGeneroFormat = trim($idGenero);

		$fechaNacimientoAlumno = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
		$fechaNacimientoAlumnoFormat = trim($fechaNacimientoAlumno);

		$foto = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
		$fotoFormat = trim($foto);

		$firmaAutografa = $objPHPExcel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
		$firmaAutografaFormat = trim($firmaAutografa);

		$idTipoCertificado = $objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
		$idTipoCertificadoFormat = trim($idTipoCertificado);

		$fechaExpedicion = $objPHPExcel->getActiveSheet()->getCell('AD'.$i)->getCalculatedValue();
		$fechaExpedicionFormat = trim($fechaExpedicion);

		$idLugarExpedicion = $objPHPExcel->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue();
		$idLugarExpedicionFormat = trim($idLugarExpedicion);

		$totalAsignaturas = $objPHPExcel->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue();
		$totalAsignaturasFormat = trim($totalAsignaturas);

		$asignaturasAsignadas = $objPHPExcel->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue();
		$asignaturasAsignadasFormat = trim($asignaturasAsignadas);

		$promedio = $objPHPExcel->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue();
		$promedioFormat = trim($promedio);

		$totalCreditos = $objPHPExcel->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue();
		$totalCreditosFormat = trim($totalCreditos);

		$creditosObtenidos = $objPHPExcel->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue();
		$creditosObtenidosFormat = trim($creditosObtenidos);
		
		$valor[$i]["informacion"] = array("alumno" => $alumnoFormat, "versionXML" => $versionXMLFormat, "tipoCertificado" => $tipoCertificadoFormat, "idNombreInstitucion" => $idNombreInstitucionFormat, "idCampus" => $idCampusFormat, "idEntidadFederativa" => $idEntidadFederativa, "curpResponsable" => $curpResponsableFormat, "responsableIDCargo" => $responsableIDCargoFormat, "numeroRvoe" => $numeroRvoeFormat, "fechaExpedicionRVOE" => $fechaExpedicionRVOEFormat, "idCarrera" => $idCarreraFormat, "idTipoPeriodo" => $idTipoPeriodoFormat, "carreraClavePlan" => $carreraClavePlanFormat, "idNivelDeEstudios" => $idNivelDeEstudiosFormat, "califMinima" => $califMinima, "califMaxima" => $califMaximaFormat, "CalifMinimaAprobatoria" => $CalifMinimaAprobatoriaFormat, "numeroControlAlumno" => $numeroControlAlumnoFormat, "curpAlumno" => $curpAlumnoFormat, "nombresAlumno" => $nombresAlumnoFormat, "apellidoPaterno" => $apellidoPaternoFormat, "apellidoMaterno" => $apellidoMaternoFormat, "idGenero" => $idGeneroFormat, "fechaNacimientoAlumno" => $fechaNacimientoAlumnoFormat, "foto" => $fotoFormat, "firmaAutografa" => $firmaAutografaFormat, "idTipoCertificado" => $idTipoCertificadoFormat, "fechaExpedicion" => $fechaExpedicionFormat, "idLugarExpedicion" => $idLugarExpedicionFormat, "totalAsignaturas" => $totalAsignaturasFormat, "asignaturasAsignadas" => $asignaturasAsignadasFormat, "promedio" => $promedioFormat, "totalCreditos" => $totalCreditosFormat, "creditosObtenidos" => $creditosObtenidosFormat);

		$contador = 0; 
		$contador2 = 0;
		for ($x='AK'; $x <= $numColumns; $x++) { 	
			
			if($contador == 5){
				$contador2++;
				$contador = 0;
			}
			$valorObtenido = $objPHPExcel->getActiveSheet()->getCell($x.$i)->getCalculatedValue();
			$valorObtenidoFormat = trim($valorObtenido);

			$valor[$i]["materias"][$contador2][] = $valorObtenidoFormat;
			
			$contador++;
		}
	

}
$cadena = "";
foreach ($valor as $key => $val) {
$cadena = "";


	$sql = "INSERT INTO datosgenerales (alumno,versionXML,tipoCertificado,idNombreInstitucion,idCampus,idEntidadFederativa,curpResponsable,responsableIDCargo,numeroRvoe,fechaExpedicionRVOE,idCarrera,idTipoPeriodo,carreraClavePlan,idNivelDeEstudios,califMinima,califMaxima,CalifMinimaAprobatoria,numeroControlAlumno,curpAlumno,nombresAlumno,apellidoPaterno,apellidoMaterno,idGenero,fechaNacimientoAlumno,foto,firmaAutografa,idTipoCertificado,fechaExpedicion,idLugarExpedicion,totalAsignaturas,asignaturasAsignadas,promedio,totalCreditos,creditosObtenidos) 
	VALUES ('{$val["informacion"]["alumno"]}','{$val["informacion"]["versionXML"]}','{$val["informacion"]["tipoCertificado"]}','{$val["informacion"]["idNombreInstitucion"]}','{$val["informacion"]["idCampus"]}','{$val["informacion"]["idEntidadFederativa"]}','{$val["informacion"]["curpResponsable"]}','{$val["informacion"]["responsableIDCargo"]}','{$val["informacion"]["numeroRvoe"]}','{$val["informacion"]["fechaExpedicionRVOE"]}','{$val["informacion"]["idCarrera"]}','{$val["informacion"]["idTipoPeriodo"]}','{$val["informacion"]["carreraClavePlan"]}','{$val["informacion"]["idNivelDeEstudios"]}','{$val["informacion"]["califMinima"]}','{$val["informacion"]["califMaxima"]}','{$val["informacion"]["CalifMinimaAprobatoria"]}','{$val["informacion"]["numeroControlAlumno"]}','{$val["informacion"]["curpAlumno"]}','{$val["informacion"]["nombresAlumno"]}','{$val["informacion"]["apellidoPaterno"]}','{$val["informacion"]["apellidoMaterno"]}','{$val["informacion"]["idGenero"]}','{$val["informacion"]["fechaNacimientoAlumno"]}','{$val["informacion"]["foto"]}','{$val["informacion"]["firmaAutografa"]}','{$val["informacion"]["idTipoCertificado"]}','{$val["informacion"]["fechaExpedicion"]}','{$val["informacion"]["idLugarExpedicion"]}','{$val["informacion"]["totalAsignaturas"]}','{$val["informacion"]["asignaturasAsignadas"]}','{$val["informacion"]["promedio"]}','{$val["informacion"]["totalCreditos"]}','{$val["informacion"]["creditosObtenidos"]}')";

	if($val["informacion"]["alumno"] <> ''){
		//ENTRA AQUÍ SI HAY INFORMACION
		$eject = $mysqli->query($sql);
		$idInsertado = $mysqli->insert_id;
		echo '<p>'.$val["informacion"]["alumno"].'</p><p>||'.$val["informacion"]["versionXML"].'|'.$val["informacion"]["tipoCertificado"].'|'.$val["informacion"]["idNombreInstitucion"].'|'.$val["informacion"]["idCampus"].'|'.$val["informacion"]["idEntidadFederativa"].'|'.$val["informacion"]["curpResponsable"].'|'.$val["informacion"]["responsableIDCargo"].'|'.$val["informacion"]["numeroRvoe"].'|'.$val["informacion"]["fechaExpedicionRVOE"].'|'.$val["informacion"]["idCarrera"].'|'.$val["informacion"]["idTipoPeriodo"].'|'.$val["informacion"]["carreraClavePlan"].'|'.$val["informacion"]["idNivelDeEstudios"].'|'.$val["informacion"]["califMinima"].'|'.$val["informacion"]["califMaxima"].'|'.$val["informacion"]["CalifMinimaAprobatoria"].'|'.$val["informacion"]["numeroControlAlumno"].'|'.$val["informacion"]["curpAlumno"].'|'.$val["informacion"]["nombresAlumno"].'|'.$val["informacion"]["apellidoPaterno"].'|'.$val["informacion"]["apellidoMaterno"].'|'.$val["informacion"]["idGenero"].'|'.$val["informacion"]["fechaNacimientoAlumno"].'|'.$val["informacion"]["foto"].'|'.$val["informacion"]["firmaAutografa"].'|'.$val["informacion"]["idTipoCertificado"].'|'.$val["informacion"]["fechaExpedicion"].'|'.$val["informacion"]["idLugarExpedicion"].'|'.$val["informacion"]["totalAsignaturas"].'|'.$val["informacion"]["asignaturasAsignadas"].'|'.$val["informacion"]["promedio"].'|'.$val["informacion"]["totalCreditos"].'|'.$val["informacion"]["creditosObtenidos"];
	
	$cadena = '||'.$val["informacion"]["versionXML"].'|'.$val["informacion"]["tipoCertificado"].'|'.$val["informacion"]["idNombreInstitucion"].'|'.$val["informacion"]["idCampus"].'|'.$val["informacion"]["idEntidadFederativa"].'|'.$val["informacion"]["curpResponsable"].'|'.$val["informacion"]["responsableIDCargo"].'|'.$val["informacion"]["numeroRvoe"].'|'.$val["informacion"]["fechaExpedicionRVOE"].'|'.$val["informacion"]["idCarrera"].'|'.$val["informacion"]["idTipoPeriodo"].'|'.$val["informacion"]["carreraClavePlan"].'|'.$val["informacion"]["idNivelDeEstudios"].'|'.$val["informacion"]["califMinima"].'|'.$val["informacion"]["califMaxima"].'|'.$val["informacion"]["CalifMinimaAprobatoria"].'|'.$val["informacion"]["numeroControlAlumno"].'|'.$val["informacion"]["curpAlumno"].'|'.$val["informacion"]["nombresAlumno"].'|'.$val["informacion"]["apellidoPaterno"].'|'.$val["informacion"]["apellidoMaterno"].'|'.$val["informacion"]["idGenero"].'|'.$val["informacion"]["fechaNacimientoAlumno"].'|'.$val["informacion"]["foto"].'|'.$val["informacion"]["firmaAutografa"].'|'.$val["informacion"]["idTipoCertificado"].'|'.$val["informacion"]["fechaExpedicion"].'|'.$val["informacion"]["idLugarExpedicion"].'|'.$val["informacion"]["totalAsignaturas"].'|'.$val["informacion"]["asignaturasAsignadas"].'|'.$val["informacion"]["promedio"].'|'.$val["informacion"]["totalCreditos"].'|'.$val["informacion"]["creditosObtenidos"];

	

	
	

	for($i=0;$i<count($val["materias"]); $i++){

		$sql = "INSERT INTO asignaturas (idDatosGenerales, idAsignatura, ciclo, calificacion, idTipoAsignatura, creditos) VALUES ('$idInsertado','".$val["materias"][$i][0]."','".$val["materias"][$i][1]."','".$val["materias"][$i][2]."','".$val["materias"][$i][3]."','".$val["materias"][$i][4]."')";

		

		
		if($val["materias"][$i][0] == "" || $val["materias"][$i][0] == null && $val["materias"][$i][1] == "" || $val["materias"][$i][1] == null && $val["materias"][$i][2] == "" || $val["materias"][$i][2] == null && $val["materias"][$i][3] == "" || $val["materias"][$i][3] == null && $val["materias"][$i][4] == "" || $val["materias"][$i][0] == null){
			//No se inserta nada a la base
		}else{
			echo '|'.$val["materias"][$i][0].'|'.$val["materias"][$i][1].'|'.$val["materias"][$i][2].'|'.$val["materias"][$i][3].'|'.$val["materias"][$i][4];
			$cadena.='|'.$val["materias"][$i][0].'|'.$val["materias"][$i][1].'|'.$val["materias"][$i][2].'|'.$val["materias"][$i][3].'|'.$val["materias"][$i][4];
			$result = $mysqli->query($sql);
		}
		
		
	}
	echo '||</p>';
	$cadena.='||';

	$private_file="archivo.key.pem";      // Ruta al archivo key con contraseña
	$public_file="archivo.cer.pem";
	$private_key = openssl_get_privatekey(file_get_contents($private_file));
	openssl_sign($cadena,$Firma,$private_key, OPENSSL_ALGO_SHA256);
	openssl_free_key($private_key);
	$sello = base64_encode($Firma);

	//$sql = "UPDATE datosgenerales SET sello = '$sello', certificadoResponsable = '$cer' WHERE id = '$idInsertado'";

	//$result = $mysqli->query($sql);
	$sql = "UPDATE datosgenerales SET sello = ? WHERE id = ?";
	$parametros = array($sello,$idInsertado);
	$eject = $conn->prepare($sql);
	$eject->execute($parametros);
		//TERMINA ENTRA AQUÍ SI HAY INFORMACIÓN
	}

	
}

			
?>