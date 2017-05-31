<?php

	$DBCONNECTION = new PDO("mysql:host=".$CONFIG["dbConnection"]["host"].";dbname=".$CONFIG["dbConnection"]["dbname"].";charset=utf8mb4", $CONFIG["dbConnection"]["username"], $CONFIG["dbConnection"]["password"]);