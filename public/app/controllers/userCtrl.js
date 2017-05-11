angular.module("userController", [])


.controller("regCtrl", function(Auth, $http, $timeout, $location){

    var app = this;
    this.regUser = function(){
        app.successMsg = app.errorMsg = false;
        app.checking = true;
        console.log(app.data);
        $http.post('/api/reg', app.data).then(function(data){
        console.log(data);
        if(data.data.success){
            Auth.doLogin(app.data).then(function(data){
                if(data.data.success){
                    app.successMsg = data.data.msg + " ...Redirecting";

                    $timeout(function() {
                        $location.path('/');
                        app.data = null;
                        app.successMsg = null;
                    }, 2000);
                }
                else{
                    app.errorMsg = data.data.msg;
                }
                app.checking = false;
            });
        }
        else{
            app.errorMsg = data.data.msg;
        }
        app.checking = false;
    });
    }
});

