<?php
		try {
			$serverName = "localhost";
			$database ="certificaciondb";
			$userName="root";
			$userPass="";
			$conn = new PDO("mysql:host=$serverName; dbname=$database", "$userName", "$userPass");  
			$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
		}catch(Exception $e){


			die(print_r($e->getMessage()));
		}
?>