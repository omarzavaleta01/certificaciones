<?php
	$mysqli=new mysqli("localhost","root","#A49-2/TMZPA-6","met"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
?>