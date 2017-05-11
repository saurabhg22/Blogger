angular.module("mainController", ["authServices"])


.controller("mainCtrl", function(Auth, $timeout, $location, $rootScope, $window, $http){

    var app = this;
    
    app.loading = true;



    $rootScope.$on('$routeChangeStart', function(){

        $http.post("/api/blogs").then(function(data){
            
            app.blogs = data.data;
            i = 0;
            while(i<app.blogs.length){
                app.blogs[i].created_at = new Date(app.blogs[i].created_at).toISOString();
                app.blogs[i].updated_at = new Date(app.blogs[i].updated_at).toISOString();
                i++;
            }
        });


        app.username = null;
        app.email = null;
        if(Auth.isLoggedIn()){
            Auth.getUser().then(function(data){
                app.username = data.data.data.username;
                app.email = data.data.data.email;
                app.name = data.data.data.name;
                app.permission = data.data.data.permission;
                app.myblogs = data.data.blogs;
                i = 0;
                while(i<app.myblogs.length){
                    app.myblogs[i].created_at = new Date(app.myblogs[i].created_at).toISOString();
                    app.myblogs[i].updated_at = new Date(app.myblogs[i].updated_at).toISOString();
                    i++;
                }
                if(app.permission == 0){
                    app.category = "Reader";
                }
                else if(app.permission == 1){
                    app.category = "Blogger";
                }
                else if(app.permission == 2){
                    app.category = "Admin";
                }
                app.ispermit = app.permission == 1;
                app.isLoggedIn = true;
                app.loading = false;
            });
        }
        else{
            app.isLoggedIn = false;
            app.ispermit = false;
            app.loading = false;
        }

        if($location.hash() == '_=_') $location.hash(null);

    
    });


    app.login = function(){
        app.successMsg = app.errorMsg = false;
        app.checking = true;

        Auth.doLogin(app.loginData).then(function(data){
            if(data.data.success){
                app.successMsg = data.data.msg + " ...Redirecting";

                $timeout(function() {
                    $location.path('/');
                    app.loginData = null;
                    app.successMsg = null;
                }, 2000);
            }
            else{
                app.errorMsg = data.data.msg;
            }
            app.checking = false;
        });
    }

    app.logout = function(){
        Auth.doLogout();
        $location.path('/logout');
        $timeout(function() {
            $location.path('/');
        }, 2000);

    }
    app.facebook = function(){
        Auth.fbChecking = true;
        app.fbChecking = true;
        $window.location = $window.location.protocol + '//' + $window.location.host + '/auth/facebook'
    }
})


.controller('facebookCtrl', function($routeParams, Auth, $location, $window){
    var app = this;
    Auth.fbChecking = true;
    if($window.location.pathname == '/facebookerr'){
        Auth.fbChecking = false;
        app.errorMsg = "Your facebook email is not registered here.";
    }
    else{
        Auth.facebook($routeParams.token);
        Auth.fbChecking = false;
        $location.path('/');
    }


});

