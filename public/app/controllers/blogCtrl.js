angular.module("blogController", [])



.controller("blogCtrl", function($location, $http, $routeParams, $timeout){

    var app = this;
    app.editable = false;
    app.errorMsg = null;
    app.successMsg = null;
    app.loading = true;

    $http.post("/api/singleblog", $routeParams).then(function(data){
        if(data.data.success){
        	app.blog = data.data.blog;
            app.blog.created_at = new Date(app.blog.created_at).toISOString();
            app.blog.updated_at = new Date(app.blog.updated_at).toISOString();
        	app.blog.editheading = app.blog.heading;
        	app.blog.editdata = app.blog.data;
    		$http.post("/api/editable", $routeParams).then(function(data){
	        	app.editable = data.data.success;
	    	});
    		app.loading = false;
        }
        else{
        	$location.path('/');
        }
    });


    app.edit = function(){
    	app.checking = true;
    	data = {};
    	data.id = $routeParams.id;
    	data.heading = app.blog.editheading;
    	data.data = app.blog.editdata;
    	$http.post("/api/editblog", data).then(function(data){
    		if(data.data.success){
	        	app.blog.heading = app.blog.editheading;
	        	app.blog.data = app.blog.editdata;
    			app.successMsg = "Successfuly updated.";
    		}
    		else{
    			app.errorMsg = data.data.msg;
    		}
    		app.checking = false;
    	});

        $timeout(function() {
            app.successMsg = null;
    		app.errorMsg = null;
        }, 2000);
    }

    app.delete = function(){
    	app.delchecking = true;
    	$http.post("/api/deleteblog", $routeParams).then(function(data){
    		if(data.data.success){
    			app.delsuccessMsg = "Successfuly deleted.";
    			 $timeout(function() {
                    $location.path('/');
            		app.delsuccessMsg = null;
                }, 2000);
    		}
    		else{
    			app.delerrorMsg = data.data.msg;
    		}
    		app.delchecking = false;
    	});
        $timeout(function() {
            app.delsuccessMsg = null;
    		app.delerrorMsg = null;
        }, 2000);
    }


});