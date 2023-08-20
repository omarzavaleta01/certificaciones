<?php
error_reporting(2);

	require 'Classes/PHPExcel/IOFactory.php'; //Agregamos la librería 
	require 'conexion.php'; //Agregamos la conexión
	require 'pdo.php';
	
	//Variable con el nombre del archivo
	$nombreArchivo = 'PlantillaTitulacionDerecho.xlsx';
	// Cargo la hoja de cálculo
	$objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
	
	//Asigno la hoja de calculo activa
	$objPHPExcel->setActiveSheetIndex(0);
	//Obtengo el numero de filas del archivo
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	echo '<STRONG>CADENA ORIGINAL</STRONG>';
	
	for ($i = 7; $i <= $numRows; $i++) {
		
		$alumno = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$alumnoFormat = trim($alumno);

		$versionXML = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$versionXMLFormat = trim($versionXML);

		$folioControl = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$folioControlFormat = trim($folioControl);

		$curpResponsable = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$curpResponsableFormat = trim($curpResponsable);

		$idCargo = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$idCargoFormat = trim($idCargo);

		$cargo = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$cargoFormat = trim($cargo);

		$abrTitulo = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$abrTituloFormat = trim($abrTitulo);

		$cveInstitucion = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$cveInstitucionFormat = trim($cveInstitucion);

		$nombreInstitucion = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
		$nombreInstitucionFormat = trim($nombreInstitucion);

		$cveCarrera = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
		$cveCarreraFormat = trim($cveCarrera);
		
		$nombreCarrera = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
		$nombreCarreraFormat = trim($nombreCarrera);

		$fechaInicio = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
		$fechaInicioFormat = trim($fechaInicio);
		$fechaInicioFormat = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaInicioFormat));

		$fechaTerminacion = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
		$fechaTerminacionFormat = trim($fechaTerminacion);
		$fechaTerminacionFormat = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaTerminacionFormat));

		$idAutorizacionReconocimiento = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
		$idAutorizacionReconocimientoFormat = trim($idAutorizacionReconocimiento);

		$autorizacionReconocimiento = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
		$autorizacionReconocimientoFormat = trim($autorizacionReconocimiento);

		$numeroRvoe = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
		$numeroRvoeFormat = trim($numeroRvoe);

		$curp = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
		$curpFormat = trim($curp);

		$nombre = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
		$nombreFormat = trim($nombre);

		$primerApellido = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
		$primerApellidoFormat = trim($primerApellido);

		$segundoApellido = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
		$segundoApellidoFormat = trim($segundoApellido);

		$correoElectronico = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
		$correoElectronicoFormat = ($correoElectronico);

		$fechaExpedicion = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
		$fechaExpedicionFormat = trim($fechaExpedicion);
		$fechaExpedicionFormat = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaExpedicionFormat));

		$idModalidadTitulacion = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
		$idModalidadTitulacionFormat = trim($idModalidadTitulacion);

		$modalidadTitulacion = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
		$modalidadTitulacionFormat = trim($modalidadTitulacion);

		$fechaExamenProfesional = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
		$fechaExamenProfesionalFormat = trim($fechaExamenProfesional);
		if ($fechaExamenProfesionalFormat == "") {
			$fechaExamenProfesionalFormat = "";
		}else{
		$fechaExamenProfesionalFormat = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaExamenProfesionalFormat));
		}

		$fechaExencionExamenProfesional = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
		$fechaExencionExamenProfesionalFormat = trim($fechaExencionExamenProfesional);
		if ($fechaExencionExamenProfesionalFormat == "") {
			$fechaExencionExamenProfesionalFormat = "";
		}else{
		$fechaExencionExamenProfesionalFormat = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaExencionExamenProfesionalFormat));
		}
	
		$cumplioServicioSocial = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
		$cumplioServicioSocialFormat = trim($cumplioServicioSocial);

		$idFundamentoLegalServicioSocial = $objPHPExcel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
		$idFundamentoLegalServicioSocialFormat = trim($idFundamentoLegalServicioSocial);

		$fundamentoLegalServicioSocial = $objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
		$fundamentoLegalServicioSocialFormat = trim($fundamentoLegalServicioSocial);

		$idEntidadFederativaExped = $objPHPExcel->getActiveSheet()->getCell('AD'.$i)->getCalculatedValue();
		$idEntidadFederativaExpedFormat = trim($idEntidadFederativaExped);

		$entidadFederativaExped = $objPHPExcel->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue();
		$entidadFederativaExpedFormat = trim($entidadFederativaExped);

		$institucionProcedencia = $objPHPExcel->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue();
		$institucionProcedenciaFormat = trim($institucionProcedencia);

		$idTipoEstudioAntecedente = $objPHPExcel->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue();
		$idTipoEstudioAntecedenteFormat = trim($idTipoEstudioAntecedente);

		$tipoEstudioAntecedente = $objPHPExcel->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue();
		$tipoEstudioAntecedenteFormat = trim($tipoEstudioAntecedente);

		$idEntidadFederativaAntece = $objPHPExcel->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue();
		$idEntidadFederativaAnteceFormat = trim($idEntidadFederativaAntece);

		$entidadFederativaAntece = $objPHPExcel->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue();
		$entidadFederativaAnteceFormat = trim($entidadFederativaAntece);

		$fechaInicioAntece = $objPHPExcel->getActiveSheet()->getCell('AK'.$i)->getCalculatedValue();
		$fechaInicioAnteceFormat = trim($fechaInicioAntece);
		$fechaInicioAnteceFormat = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaInicioAnteceFormat));

		$fechaTerminacionAntece = $objPHPExcel->getActiveSheet()->getCell('AL'.$i)->getCalculatedValue();
		$fechaTerminacionAnteceFormat = trim($fechaTerminacionAntece);
		$fechaTerminacionAnteceFormat = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($fechaTerminacionAnteceFormat));

		$noCedula = $objPHPExcel->getActiveSheet()->getCell('AM'.$i)->getCalculatedValue();
		$noCedulaFormat = trim($noCedula);

		if($alumnoFormat <> ''){
			//SE INSERTA EL REGISTRO POR QUE NO VIENE VACIO
			$sql = "INSERT INTO tituloelectronico (alumno, versionXML, folioControl, curpResponsable, idCargo, cargo, abrTitulo, cveInstitucion, nombreInstitucion, cveCarrera, nombreCarrera, fechaInicio, fechaTerminacion, idAutorizacionReconocimiento, autorizacionReconocimiento, numeroRvoe, curp, nombre, primerApellido, segundoApellido, correoElectronico, fechaExpedicion, idModalidadTitulacion, modalidadTitulacion, fechaExamenProfesional, fechaExencionExamenProfesional, cumplioServicioSocial, idFundamentoLegalServicioSocial, fundamentoLegalServicioSocial, idEntidadFederativaExped, entidadFederativaExped, institucionProcedencia, idTipoEstudioAntecedente, tipoEstudioAntecedente, idEntidadFederativaAntece, entidadFederativaAntecede, fechaInicioAntece, fechaTerminacionAntece, noCedula) VALUES ('$alumnoFormat', '$versionXMLFormat', '$folioControlFormat', '$curpResponsableFormat', '$idCargoFormat', '$cargoFormat', '$abrTituloFormat', '$cveInstitucionFormat', '$nombreInstitucionFormat', '$cveCarreraFormat', '$nombreCarreraFormat', '$fechaInicioFormat', '$fechaTerminacionFormat', '$idAutorizacionReconocimientoFormat', '$autorizacionReconocimientoFormat', '$numeroRvoeFormat', '$curpFormat', '$nombreFormat', '$primerApellidoFormat', '$segundoApellidoFormat', '$correoElectronicoFormat', '$fechaExpedicionFormat', '$idModalidadTitulacionFormat', '$modalidadTitulacionFormat', '$fechaExamenProfesionalFormat', '$fechaExencionExamenProfesionalFormat', '$cumplioServicioSocialFormat', '$idFundamentoLegalServicioSocialFormat', '$fundamentoLegalServicioSocialFormat', '$idEntidadFederativaExpedFormat', '$entidadFederativaExpedFormat', '$institucionProcedenciaFormat', '$idTipoEstudioAntecedenteFormat', '$tipoEstudioAntecedenteFormat', '$idEntidadFederativaAnteceFormat', '$entidadFederativaAnteceFormat', '$fechaInicioAnteceFormat', '$fechaTerminacionAnteceFormat', '$noCedulaFormat')";
		$result = $mysqli->query($sql);
		$idInsertado = $mysqli->insert_id;

		echo '<tr>';
		echo '<p>'.$alumnoFormat.'<br>||'. $versionXMLFormat.'|'. $folioControlFormat.'|'. $curpResponsableFormat.'|'.$idCargoFormat.'|'.$cargoFormat.'|'.$abrTituloFormat.'|'.$cveInstitucionFormat.'|'.$nombreInstitucionFormat.'|'.$cveCarreraFormat.'|'.$nombreCarreraFormat.'|'.$fechaInicioFormat.'|'.$fechaTerminacionFormat.'|'.$idAutorizacionReconocimientoFormat.'|'.$autorizacionReconocimientoFormat.'|'.$numeroRvoeFormat.'|'.$curpFormat.'|'.$nombreFormat.'|'.$primerApellidoFormat.'|'.$segundoApellidoFormat.'|'.$correoElectronicoFormat.'|'.$fechaExpedicionFormat.'|'.$idModalidadTitulacionFormat.'|'.$modalidadTitulacionFormat.'|'.$fechaExamenProfesionalFormat.'|'.$fechaExencionExamenProfesionalFormat.'|'.$cumplioServicioSocialFormat.'|'.$idFundamentoLegalServicioSocialFormat.'|'.$fundamentoLegalServicioSocialFormat.'|'.$idEntidadFederativaExpedFormat.'|'.$entidadFederativaExpedFormat.'|'.$institucionProcedenciaFormat.'|'.$idTipoEstudioAntecedenteFormat.'|'.$tipoEstudioAntecedenteFormat.'|'.$idEntidadFederativaAnteceFormat.'|'.$entidadFederativaAnteceFormat.'|'.$fechaInicioAnteceFormat.'|'.$fechaTerminacionAnteceFormat.'|'.$noCedulaFormat.'||</p>';
		echo '</tr>';

		$cadena = "";
		$cadena = '||'. $versionXMLFormat.'|'. $folioControlFormat.'|'. $curpResponsableFormat.'|'.$idCargoFormat.'|'.$cargoFormat.'|'.$abrTituloFormat.'|'.$cveInstitucionFormat.'|'.$nombreInstitucionFormat.'|'.$cveCarreraFormat.'|'.$nombreCarreraFormat.'|'.$fechaInicioFormat.'|'.$fechaTerminacionFormat.'|'.$idAutorizacionReconocimientoFormat.'|'.$autorizacionReconocimientoFormat.'|'.$numeroRvoeFormat.'|'.$curpFormat.'|'.$nombreFormat.'|'.$primerApellidoFormat.'|'.$segundoApellidoFormat.'|'.$correoElectronicoFormat.'|'.$fechaExpedicionFormat.'|'.$idModalidadTitulacionFormat.'|'.$modalidadTitulacionFormat.'|'.$fechaExamenProfesionalFormat.'|'.$fechaExencionExamenProfesionalFormat.'|'.$cumplioServicioSocialFormat.'|'.$idFundamentoLegalServicioSocialFormat.'|'.$fundamentoLegalServicioSocialFormat.'|'.$idEntidadFederativaExpedFormat.'|'.$entidadFederativaExpedFormat.'|'.$institucionProcedenciaFormat.'|'.$idTipoEstudioAntecedenteFormat.'|'.$tipoEstudioAntecedenteFormat.'|'.$idEntidadFederativaAnteceFormat.'|'.$entidadFederativaAnteceFormat.'|'.$fechaInicioAnteceFormat.'|'.$fechaTerminacionAnteceFormat.'|'.$noCedulaFormat.'||';


		$private_file="archivo.key.pem";      // Ruta al archivo key con contraseña
		$public_file="archivo.cer.pem";
		$private_key = openssl_get_privatekey(file_get_contents($private_file));
		openssl_sign($cadena,$Firma,$private_key, OPENSSL_ALGO_SHA256);
		openssl_free_key($private_key);
		$sello = base64_encode($Firma);

		//$sql = "UPDATE datosgenerales SET sello = '$sello', certificadoResponsable = '$cer' WHERE id = '$idInsertado'";

		//$result = $mysqli->query($sql);
		$sql = "UPDATE tituloelectronico SET firma = ? WHERE id = ?";
		$parametros = array($sello,$idInsertado);
		$eject = $conn->prepare($sql);
		$eject->execute($parametros);
			//TERMINA ENTRA AQUÍ SI HAY INFORMACIÓN
			//TERMINA SE INSERTA EL REGISTRO POR QUE NO VIENE VACIO
		}


		
		

	}
	
	
?>