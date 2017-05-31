<?php


class Responder {

	public function __construct() {

		$this->setHeaders();

	}

	public function setHeaders() {
		header("Content-type:application/json");
	}

	public function respond($response) {
		echo json_encode($response);
	}

}