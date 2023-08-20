<?php
function pre($array){
		echo '<pre>';
			print_r($array);
		echo '</pre>';
	}
header("Content-type: text/html; charset=ISO-8859-1");
echo 'Current PHP Version: ' . phpversion();

try {

$private_file="archivo.key.pem";      // Ruta al archivo key con contraseña
$public_file="archivo.cer.pem";

$cadena_original="||2.0|5|20585|150840|15|NAPH690907HDFVRC07|1|20140252|2014-08-29T00:00:00|5|91|2014|81|5|10|6.00|LC0132016M1A1A1|GAJA820623MVZRRL06|ALICIA|GARCIA|JUAREZ|250|1982-06-23T00:00:00|||79|2020-03-06T00:00:00|15|49|49|9.36|306.25|306.25|315|2015-2|9.00|263|6.25|316|2015-2|10|263|6.25|317|2015-2|10|263|6.25|318|2015-2|10|263|6.25|319|2015-2|9.00|263|6.25|320|2015-2|9.00|263|6.25|321|2016-1|9.00|263|6.25|322|2016-1|10|263|6.25|323|2016-1|10|263|6.25|324|2016-1|10|263|6.25|325|2016-1|10|263|6.25|326|2016-1|10|263|6.25|327|2016-2|8.00|263|6.25|328|2016-2|10|263|6.25|329|2016-2|9.00|263|6.25|330|2016-2|8.00|263|6.25|331|2016-2|9.00|263|6.25|332|2017-1|8.00|263|6.25|333|2017-1|9.00|263|6.25|334|2017-1|8.00|263|6.25|335|2017-1|9.00|263|6.25|336|2017-1|10|263|6.25|337|2017-1|9.00|263|6.25|338|2017-2|9.00|263|6.25|339|2017-2|8.00|263|6.25|340|2017-2|9.00|263|6.25|341|2017-2|9.00|263|6.25|342|2017-2|9.00|263|6.25|343|2017-2|10|263|6.25|344|2017-2|9.00|263|6.25|345|2018-1|10|263|6.25|346|2018-1|9.00|263|6.25|347|2018-1|9.00|263|6.25|348|2018-1|9.00|263|6.25|349|2018-1|10|263|6.25|350|2018-1|10|263|6.25|351|2018-2|8.00|263|6.25|352|2018-2|9.00|263|6.25|353|2018-2|10|263|6.25|354|2018-2|10|263|6.25|355|2018-2|10|263|6.25|356|2018-2|9.00|263|6.25|357|2019-1|10|263|6.25|358|2019-1|10|263|6.25|359|2019-1|10|263|6.25|360|2019-1|10|263|6.25|361|2019-1|10|263|6.25|362|2019-1|10|263|6.25|363|2019-1|10|263|6.25||";
//$cadena_original="||1.0|3|GAVA730717HDFRGR05|Director de Articulación de Procesos|SECRETARÍA DE EDUCACIÓN|Departamento de Control Escolar|23DPR0749T|005|23|SOSE810201HDFRND05|EDGAR|SORIANO|SANCHEZ|2|7.8|2017-01-01T12:05:00||";


// Se obtiene la clave privada con la que se va a firmar
$private_key = openssl_get_privatekey(file_get_contents($private_file)); // $clave es la contraseña del archivo .key
$exito = openssl_sign($cadena_original,$Firma,$private_key, OPENSSL_ALGO_SHA256);

openssl_free_key($private_key);

echo "<br><br> firma ".$Firma;
$sello = base64_encode($Firma);      // lo codifica en formato base64

echo "<br><br> Sello ".$sello;
$public_key = openssl_pkey_get_public(file_get_contents($public_file));

$PubData = openssl_pkey_get_details($public_key);

pre($PubData); exit;
echo "<br><br> CER: ".$PubData["key"];

$result = openssl_verify($cadena_original, $Firma, $public_key, "sha256WithRSAEncryption");
echo "<br><br> Resultado ".$result;

} catch (Exception $e) {
    echo var_dump($e->getMessage());
}

// *******************************************************************************
// Comandos para convertir los *.cer y *.key en formato pem en Linux,

// Convertir *.key a *.pem: openssl pkcs8 -inform DER -in llave.key -out llave.key.pem -passin pass:contrasenia
// Convertir *.cer a *.pem: openssl x509 -inform DER -outform PEM -in certificado.cer -pubkey > certificado.cer.pem

