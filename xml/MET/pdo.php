<?php
		$serverName = "localhost";
		$database ="met";
		$userName="root";
		$userPass="#A49-2/TMZPA-6";
		$conn = new PDO("mysql:host=$serverName; dbname=$database", "$userName", "$userPass");  
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
?>