app.controller('homeController', function($scope, personServices) {

    var homeController = function() {
    	var _parent = this;

    	_parent.modalIDs = {
    		"specific" 	: "specificPersonModal",
    		"update" 	: "updatePersonModal"
    	};

    	_parent.specificPlayerID = "";
    	_parent.persons = [];

    	_parent.currentEditedPersonCopy = null;
    	_parent.currentEditedPerson = null;

    	/*-----------------------------------------------------------------------*/
    	_parent.showSpecificModal = function() {
    		$("#"+_parent.modalIDs.specific).modal("show");
    	};

    	_parent.hideSpecificModal = function() {
    		$("#"+_parent.modalIDs.specific).modal("hide");
    	};

    	_parent.showUpdateModal = function(personID) {


    		for(var x in _parent.persons) {
    			var curPerson = _parent.persons[x];

    			if(curPerson.id === personID) {
    				_parent.currentEditedPersonCopy = angular.copy(_parent.persons[x]);
    				_parent.currentEditedPerson = _parent.persons[x];
    			}
    		}


    		$("#"+_parent.modalIDs.update).modal("show");

    	};
    	
    	_parent.revertActivePerson = function() {
    		// _parent.currentEditedPerson = angular.copy(_parent.currentEditedPersonCopy);
    		for(var x in _parent.persons) {
    			var curPerson = _parent.persons[x];

    			if(curPerson.id === _parent.currentEditedPerson.id) {
    				_parent.persons[x] = angular.copy(_parent.currentEditedPersonCopy);
    			}
    		}
    	};

    	_parent.updateActivePerson = function() {
    		personServices.updatePerson({
    			"personID" : _parent.currentEditedPerson.id,
    			"playerDetails" : {
    				"firstName" 	: _parent.currentEditedPerson.first_name,
    				"lastName" 		: _parent.currentEditedPerson.last_name,
    				"contactNumber" : _parent.currentEditedPerson.contact_number,
    			}
    		}).then(function(response) {
    			if(response.data.success) {
    				_parent.fetchPersons();
    			} else {
    				alert("Problem deleting person");
    			}
    		});
    	};

    	_parent.deletePerson = function(personID) {
    		personServices.deletePerson({
    			"personID" : personID
    		}).then(function(response) {
    			if(response.data.success) {
    				_parent.fetchPersons();
    			} else {
    				alert("Problem deleting person");
    			}
    		});
    	};

    	_parent.fetchPerson = function() {
    		if(_parent.specificPlayerID.trim() === "") {
    			alert("Please provide a player ID");return;
    		}

    		personServices.fetchPerson({
    			"personID" : _parent.specificPlayerID
    		}).then(function(response) {
    			_parent.hideSpecificModal();

    			if(response.data.success) {
    				_parent.persons = response.data.data;
    			} else {
    				alert("Problem fetching persons");
    			}
    		});
    	};

    	_parent.fetchPersons = function() {
    		personServices.fetchPersons({


    		}).then(function(response) {
    			if(response.data.success) {
    				_parent.persons = response.data.data;
    			} else {
    				alert("Problem fetching persons");
    			}
    		});
    	};


    	_parent.initialize = function() {
    		console.log("Initializing homeController");

    		// Fetch persons
    		_parent.fetchPersons();
    	};

    };


    $scope.homeController = new homeController();
    $scope.homeController.initialize();


});