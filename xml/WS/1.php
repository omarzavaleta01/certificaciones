<?php
	ini_set('display_errors',1);
	/*try {

		$client = new SoapClient(
		    null,
		    array(
		        'location' => 'https://metqa.siged.sep.gob.mx:443/met-ws/services/',
		        'uri' => 'https://metqa.siged.sep.gob.mx:443/met-ws/services/',
		        'trace' => 1,
		        'use' => SOAP_LITERAL,
		    )
		);
		$params = new \SoapVar("<cargaTituloElectronicoRequest xmlns='http://ws.web.mec.sep.mx/schemas'>
            <nombreArchivo>[string]</nombreArchivo>
            <archivoBase64>[base64Binary]</archivoBase64>
            <autenticacion>
                <usuario>[string]</usuario>
                <password>[string]</password>
            </autenticacion>
        </cargaTituloElectronicoRequest>", XSD_ANYXML);
		$result = $client->Echo($params);

		
	}catch(Exception $e){
		die(print_r($e->getMessage()));
	}*/
	function pre($array){
		echo '<pre>';
			print_r($array);
		echo '</pre>';
	}
	$file = "GABRIELA FIGUEROA AVILES.xml";
	$data = file_get_contents($file);
	$base64File = base64_encode($data);

//SE CARGA EL TITULO

	$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <cargaTituloElectronicoRequest xmlns="http://ws.web.mec.sep.mx/schemas">
            <nombreArchivo>'.$file.'</nombreArchivo>
            <archivoBase64>'.$base64File.'</archivoBase64>
            <autenticacion>
                <usuario>usuariomet.qa1210</usuario>
                <password>J3P9dBxuuu</password>
            </autenticacion>
        </cargaTituloElectronicoRequest>
    </Body>
</Envelope>';
 
 

$url = 'https://metqa.siged.sep.gob.mx:443/met-ws/services/';
$curl = curl_init($url);
curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
	if(curl_errno($curl)){
	    throw new Exception(curl_error($curl));
	}
curl_close($curl);

$xmlPost = str_replace("env:", "", $result);

/*$oXML = new SimpleXMLElement( $xmlPost );
header( 'Content-type: text/xml' );
echo $oXML->asXML();*/
$xmlNow = simplexml_load_string($xmlPost);
$json = json_encode($xmlNow);
$array = json_decode($json,TRUE);


$loteRecibido = $array["Body"]["cargaTituloElectronicoResponse"]["numeroLote"];

echo "Se cargo el XML del alumno y se recibio el lote: ".$loteRecibido."<br>";

//SE TERMINA DE CARGAR EL TITULO

//SE CONSULTA EL ESTATUS DEL TITULO
$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <consultaProcesoTituloElectronicoRequest xmlns="http://ws.web.mec.sep.mx/schemas">
            <numeroLote>'.$loteRecibido.'</numeroLote>
            <autenticacion>
                <usuario>usuariomet.qa1210</usuario>
                <password>J3P9dBxuuu</password>
            </autenticacion>
        </consultaProcesoTituloElectronicoRequest>
    </Body>
</Envelope>';


$curl = curl_init($url);
curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
	if(curl_errno($curl)){
	    throw new Exception(curl_error($curl));
	}
curl_close($curl);

$xmlPost = str_replace("env:", "", $result);
$xmlNow = simplexml_load_string($xmlPost);
$json = json_encode($xmlNow);
$array = json_decode($json,TRUE);

$mensajeObtenido = $array["Body"]["consultaProcesoTituloElectronicoResponse"]["mensaje"];
$estatusObtenido = $array["Body"]["consultaProcesoTituloElectronicoResponse"]["estatusLote"];

echo "Se consultó el proceso por lote y el estatus es:".$estatusObtenido.". <br>Con el mensaje: ".$mensajeObtenido."<br>";


//SE TERMINA DE CONSULTAR EL ESTATUS DEL TITULO

//INICIA EL PROCESO DE DESCARGAR EL RESULTADO DEL TITULO
	$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <descargaTituloElectronicoRequest xmlns="http://ws.web.mec.sep.mx/schemas">
            <numeroLote>'.$loteRecibido.'</numeroLote>
            <autenticacion>
               <usuario>usuariomet.qa1210</usuario>
                <password>J3P9dBxuuu</password>
            </autenticacion>
        </descargaTituloElectronicoRequest>
    </Body>
</Envelope>';


$curl = curl_init($url);
curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
	if(curl_errno($curl)){
	    throw new Exception(curl_error($curl));
	}
curl_close($curl);

$xmlPost = str_replace("env:", "", $result);
$xmlNow = simplexml_load_string($xmlPost);
$json = json_encode($xmlNow);
$array = json_decode($json,TRUE);

$mensajeObtenido = $array["Body"]["descargaTituloElectronicoResponse"]["mensaje"];
$archivoRecibidoBase64 = $array["Body"]["descargaTituloElectronicoResponse"]["titulosBase64"];

echo "El mensaje al descargar el titulo es: ".$mensajeObtenido."<br>";

$zipStr = $archivoRecibidoBase64;

// Prepare Tmp File for Zip archive
//$file = tempnam("tmp", "zip");
$zip = new ZipArchive();
$zip->open("prueba.zip", ZipArchive::CREATE);

// Add contents
$zip->addFromString('resultado.zip', base64_decode($zipStr));

// Close and send to users
$zip->close();

echo "<a href='prueba.zip'>Descargar</a>"
//TERMINA EL PROCESO DE DESCARGAR EL RESULTADO DEL TITULO




?>