app.factory('personServices', function($rootScope, $http, $httpParamSerializerJQLike) {

	var shinyNewServiceInstance = {
		"createPerson" : function(param) {
			return $http({
			  "method"	: "POST",
			  "url"		: "http://localhost/SOURCEFITEXAM/SAMPLEAPP/API/person/",
			  "headers" : {
			  	"Content-Type":"application/x-www-form-urlencoded",
			  },
			  "data" 	: $httpParamSerializerJQLike(param)
			})
		},
		"fetchPerson" : function(param) {
			return $http({
			  "method"	: "GET",
			  "url"		: "http://localhost/SOURCEFITEXAM/SAMPLEAPP/API/person/" + param.personID
			})
		},
		"fetchPersons" : function() {
			return $http({
			  "method"	: "GET",
			  "url"		: "http://localhost/SOURCEFITEXAM/SAMPLEAPP/API/person/all"
			})
		},
		"deletePerson" : function(param) {
			return $http({
			  "method"	: "DELETE",
			  "url"		: "http://localhost/SOURCEFITEXAM/SAMPLEAPP/API/person/" + param.personID
			})
		},

		"updatePerson" : function(param) {
			return $http({
			  "method"	: "PUT",
			  "url"		: "http://localhost/SOURCEFITEXAM/SAMPLEAPP/API/person/" + param.personID,
			  "headers" : {
			  	"Content-Type":"application/json",
			  },
			  "data" 	: JSON.stringify(param.playerDetails)
			})
		},


	};


	return shinyNewServiceInstance;
});