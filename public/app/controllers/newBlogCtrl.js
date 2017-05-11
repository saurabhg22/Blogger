angular.module("newBlogController", [])



.controller("newBlogCtrl", function($location, $http, $routeParams, $timeout){

    var app = this;
    app.errorMsg = null;
    app.successMsg = null;


    redirect = function(id){
        $location.path('/blogdetails/' + id);
        //$location.path('/');
        app.successMsg = null;
    }

    app.submit = function(){
    	app.checking = true;
        app.successMsg = null;
        app.errorMsg = null;
        data = {};
        data.heading = app.heading;
        data.data = app.data;
        console.log(data);
    	$http.post("/api/newblog", data).then(function(data){
            console.log(data);
    		if(data.data.success){
    			app.successMsg = "Successfuly created a new blog.";
    			 $timeout(redirect(data.data.id), 2000);
    		}
    		else{
    			app.errorMsg = data.data.msg;
    		}
    		app.checking = false;
    	});
    }


});