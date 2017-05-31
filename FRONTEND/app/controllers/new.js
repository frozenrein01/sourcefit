app.controller('newController', function($scope, personServices) {
    
    var newController = function() {
    	var _parent = this;

    	_parent.firstName 		= "";
    	_parent.lastName 		= "";
    	_parent.contactNumber 	= "";

    	_parent.createPerson = function() {
    		personServices.createPerson({
    			"firstName" 	: _parent.firstName,
    			"lastName" 		: _parent.lastName,
    			"contactNumber" : _parent.contactNumber,
    		}).then(function(response) {
    			if(response.data.success) {
    			 	_parent.firstName 		= "";
			    	_parent.lastName 		= "";
			    	_parent.contactNumber 	= "";

			    	alert("Successfully created the person");
    			} else {
    				alert("Problem creating person");
    			}
    		});
    	};

  

    	_parent.initialize = function() {
    		console.log("Initializing newController");
    	};

    };


    $scope.newController = new newController();
    $scope.newController.initialize();

});