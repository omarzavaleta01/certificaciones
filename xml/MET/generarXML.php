<?php
	error_reporting(0);
	include("pdo.php");
	include("funciones.php");
	$idAlumno = $_REQUEST["idAlumno"];
	header('Content-Type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
";	
	list($registros,$contador) = obtenerInformacionAlumno($conn,$idAlumno);
?>
<?php foreach($registros as $row){
	$folioControl = $row["folioControl"];
	$versionXML = $row["versionXML"];
	$curpResponsable = $row["curpResponsable"];
	$idCargo = $row["idCargo"];
	$cargo = $row["cargo"];
	$abrTitulo = $row["abrTitulo"];
	$cveInstitucion = $row["cveInstitucion"];
	$nombreInstitucion = $row["nombreInstitucion"];
	$cveCarrera = $row["cveCarrera"];
	$nombreCarrera = $row["nombreCarrera"];
	$fechaInicio = $row["fechaInicio"];
	$fechaTerminacion = $row["fechaTerminacion"];
	$idAutorizacionReconocimiento = $row["idAutorizacionReconocimiento"];
	$autorizacionReconocimiento = $row["autorizacionReconocimiento"];
	$numeroRvoe = $row["numeroRvoe"];
	$curp = $row["curp"];
	$nombre = $row["nombre"];
	$primerApellido = $row["primerApellido"];
	$segundoApellido = $row["segundoApellido"];
	$correoElectronico = $row["correoElectronico"];
	$fechaExpedicion = $row["fechaExpedicion"];
	$idModalidadTitulacion = $row["idModalidadTitulacion"];
	$modalidadTitulacion = $row["modalidadTitulacion"];
	$fechaExamenProfesional = $row["fechaExamenProfesional"];
	$cumplioServicioSocial = $row["cumplioServicioSocial"];
	$idFundamentoLegalServicioSocial = $row["idFundamentoLegalServicioSocial"];
	$fundamentoLegalServicioSocial = $row["fundamentoLegalServicioSocial"];
	$idEntidadFederativaExped = $row["idEntidadFederativaExped"];
	$entidadFederativaExped = $row["entidadFederativaExped"];
	$institucionProcedencia = $row["institucionProcedencia"];
	$idTipoEstudioAntecedente = $row["idTipoEstudioAntecedente"];
	$tipoEstudioAntecedente = $row["tipoEstudioAntecedente"];
	$idEntidadFederativaAntece = $row["idEntidadFederativaAntece"];
	$entidadFederativaAntecede = $row["entidadFederativaAntecede"];
	$fechaInicioAntece = $row["fechaInicioAntece"];
	$fechaTerminacionAntece = $row["fechaTerminacionAntece"];
	$noCedula = $row["noCedula"];
	$firma = $row["firma"];
	$certificadoResponsable = $row["certificadoResponsable"];
	}
	?><TituloElectronico xmlns="https://www.siged.sep.gob.mx/titulos/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1.0" folioControl="<?=$folioControl?>" xsi:schemaLocation="https://www.siged.sep.gob.mx/titulos/ schema.xsd">
    <FirmaResponsables>
        <FirmaResponsable nombre="HECTOR LUIS" primerApellido="NAVARRO" segundoApellido="PEREZ" curp="NAPH690907HDFVRC07" idCargo="<?=$idCargo?>" cargo="<?=$cargo?>" abrTitulo="<?=$abrTitulo?>" sello="<?=$firma?>" certificadoResponsable="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" noCertificadoResponsable="00001000000412376899"/>
    </FirmaResponsables>
    <Institucion cveInstitucion="<?=$cveInstitucion?>" nombreInstitucion="<?=$nombreInstitucion?>"/>
    <Carrera cveCarrera="<?=$cveCarrera?>" nombreCarrera="<?=$nombreCarrera?>" fechaInicio="<?=$fechaInicio?>" fechaTerminacion="<?=$fechaTerminacion?>" idAutorizacionReconocimiento="<?=$idAutorizacionReconocimiento?>" autorizacionReconocimiento="<?=$autorizacionReconocimiento?>" numeroRvoe="<?=$numeroRvoe?>"/>
    <Profesionista curp="<?=$curp?>" nombre="<?=$nombre?>" primerApellido="<?=$primerApellido?>" segundoApellido="<?=$segundoApellido?>" correoElectronico="<?=$correoElectronico?>"/>
    <Expedicion fechaExpedicion="<?=$fechaExpedicion?>" idModalidadTitulacion="<?=$idModalidadTitulacion?>" modalidadTitulacion="<?=$modalidadTitulacion?>" fechaExamenProfesional="<?=$fechaExamenProfesional?>" cumplioServicioSocial="<?=$cumplioServicioSocial?>" idFundamentoLegalServicioSocial="<?=$idFundamentoLegalServicioSocial?>" fundamentoLegalServicioSocial="<?=$fundamentoLegalServicioSocial?>" idEntidadFederativa="<?=$idEntidadFederativaExped?>" entidadFederativa="<?=$entidadFederativaExped?>"/>
    <Antecedente institucionProcedencia="<?=$institucionProcedencia?>" idTipoEstudioAntecedente="<?=$idTipoEstudioAntecedente?>" tipoEstudioAntecedente="<?=$tipoEstudioAntecedente?>" idEntidadFederativa="<?=$idEntidadFederativaAntece?>" entidadFederativa="<?=$entidadFederativaAntecede?>" fechaInicio="<?=$fechaInicioAntece?>" fechaTerminacion="<?=$fechaTerminacionAntece?>"/>
</TituloElectronico>
