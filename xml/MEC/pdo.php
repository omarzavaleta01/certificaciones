<?php
		$serverName = "localhost";
		$database ="mec";
		$userName="root";
		$userPass="love.777";
		$conn = new PDO("mysql:host=$serverName; dbname=$database", "$userName", "$userPass");  
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
?>