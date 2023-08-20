<?php
	session_start();
	if($_SESSION["idUser"] <> ''){
		header("Location: index.php");
	}
	include("conexion.php");
	include("funciones.php");

	$opcion = $_REQUEST["action"];

	if($opcion == "login"){
		$email = $_REQUEST["email"];
		$clave = md5(sha1($_REQUEST["clave"]));

		list($registros,$contadorRegistros) = verificarLogin($conn,$email,$clave);

		if($contadorRegistros >= 1){
			foreach($registros as $row){
				$_SESSION["idUser"] = $row["id"];
				$_SESSION["nombre"] = $row["nombre"];
				$_SESSION["token"] = md5(uniqid(mt_rand(), true));

				header("Location: index.php");
			}
		}else{
			header("Location: index.php?error=login");
		}
	}
	if($opcion == "logout"){
		session_start();
		//destruye la sesion de todos los usuarios
		unset($_SESSION['idUser']);
		header("location:index.php");
	}
?>