<?php



class Person {

	private $dbConnection 	= null;
	private $tableName 		= "person";
	private $urlParams 		= null;
	private $activePersonID = null;

	public function __construct($dbConnection, $urlParams) {

		// Set DB connection
		$this->dbConnection = $dbConnection;

		// Set URL Params
		array_shift($urlParams);	
		$this->urlParams = $urlParams;

		// Set active person ID
		if(count($this->urlParams) > 0 && trim($this->urlParams[0]) !== "") {
			$this->activePersonID = $this->urlParams[0];
		}

	}


	public function manageRequest() {
		switch($_SERVER['REQUEST_METHOD']) {
			case "POST":
				return $this->create();
			break;
			case "GET":
				if($this->activePersonID === null) {
					throw new Exception("Please specify a person ID");
				}
				return $this->get();
			break;
			case "PUT":
				return $this->update();
			break;
			case "DELETE":
				if($this->activePersonID === null) {
					throw new Exception("Please specify a person ID");
				}
				return $this->delete();
			break;
		}

	}

	public function create() {
		$processResult = array(
			"success" 		=> false,
			"data" 			=> array(),
			"errorMessages" => array()
		);

		$firstName 		= $_POST["firstName"];
		$lastName 		= $_POST["lastName"];
		$contactNumber 	= $_POST["contactNumber"];

		$stmt = $this->dbConnection->prepare("INSERT INTO 
								$this->tableName(first_name,last_name,contact_number) 
								VALUES(:firstName, :lastName, :contactNumber)");
		$stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
		$stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
		$stmt->bindValue(':contactNumber', $contactNumber, PDO::PARAM_STR);
		$stmt->execute();


		if($stmt->rowCount() >= 1) {
			$processResult["success"] = true;
		} else {
			$processResult["success"] = false;
			$processResult["errorMessages"] = "Problem creating the person.";
		}

		return $processResult;
	}

	public function get() {
		$processResult = array(
			"success" 		=> false,
			"data" 			=> array(),
			"errorMessages" => array()
		);

		$bindableValues = array();
		$sql = "SELECT * FROM $this->tableName";

		if($this->activePersonID !== "all") {
			$sql .= " WHERE id = :personID ";
			$bindableValues["personID"] = $this->activePersonID;
		}



		$stmt = $this->dbConnection->prepare($sql);
		foreach($bindableValues as $paramName => $paramValue) {
			$stmt->bindValue($paramName, $paramValue);
		}unset($paramValue);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if($row !== false && is_array($row)) {
			$processResult["success"] = true;
			$processResult["data"] = $row;
		} else {
			$processResult["success"] = false;
			$processResult["errorMessages"][] = "Unknown person ID";
		}

		return $processResult;
	}


	public function update() {
		$processResult = array(
			"success" 		=> false,
			"data" 			=> array(),
			"errorMessages" => array()
		);

		$putData = json_decode(file_get_contents("php://input"));

		if($putData === null) {
			throw new Exception("PUT data is malformed, it should be a valid JSON format");
		}

		$firstName 		= $putData->firstName;
		$lastName 		= $putData->lastName;
		$contactNumber 	= $putData->contactNumber;

		$stmt = $this->dbConnection->prepare("UPDATE $this->tableName SET first_name = :firstName, last_name = :lastName, contact_number = :contactNumber WHERE id = :personID");
		$stmt->bindValue(':personID', $this->activePersonID, PDO::PARAM_STR);
		$stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
		$stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
		$stmt->bindValue(':contactNumber', $contactNumber, PDO::PARAM_STR);
		$stmt->execute();

		if($stmt->rowCount() >= 1) {
			$processResult["success"] = true;
		} else {
			$processResult["success"] = false;
			$processResult["errorMessages"] = "Problem updating the person.";
		}

		return $processResult;
	}

	
	public function delete() {
		$processResult = array(
			"success" 		=> false,
			"data" 			=> array(),
			"errorMessages" => array()
		);

		$stmt = $this->dbConnection->prepare("DELETE FROM $this->tableName WHERE id = :personID");
		$stmt->bindValue(':personID', $this->activePersonID, PDO::PARAM_INT);
		$stmt->execute();

		if($stmt->rowCount() >= 1) {
			$processResult["success"] = true;
		} else {
			$processResult["success"] = false;
			$processResult["errorMessages"] = "Problem deleting the person.";
		}

		return $processResult;
	}



}
