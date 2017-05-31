<?php

	require '/core/config.php';
	require '/core/dbconnection.php';
	require '/core/responder.php';
	require '/person.php';
	

	#remove the directory path we don't want
	$request  = str_replace("/SOURCEFITEXAM/SAMPLEAPP/API/", "", $_SERVER['REQUEST_URI']);

	#split the path by '/'
	$params   = split("/", $request);

	// Set responder
	$responder = new Responder();
	$responseData = array(
		"success" 		=> false,
		"data" 			=> array(),
		"errorMessages" => array()
	);


	try {
		
		if(count($params) > 0 && $params[0] === "person") {

			// Initialize person
			$person = new Person($DBCONNECTION, $params);
			$classResult = $person->manageRequest();

			$responseData["success"] 		= $classResult["success"];
			$responseData["data"] 	 		= $classResult["data"];
			$responseData["errorMessages"] 	= $classResult["errorMessages"];

		} else {
			throw new Exception("Unknown resource to access.");
		}

	} catch(Exception $e) {
		echo "Error : " . $e->getMessage();
		die;
	}

	// Responde to the request
	$responder->respond($responseData)

?>