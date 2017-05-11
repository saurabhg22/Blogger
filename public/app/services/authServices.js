angular.module("authServices", [])



.factory('Auth', function($http, AuthToken){
    var authFactory = {};

    authFactory.doLogin = function(loginData){
        return $http.post("/api/login", loginData).then(function(data){
            AuthToken.setToken(data.data.token);
            return data;
        });
    }

    authFactory.isLoggedIn = function(){
        if (AuthToken.getToken()){
            return true;
        }
        return false;
    }

    authFactory.doLogout = function(){
        AuthToken.setToken();
    }

    authFactory.getUser = function(){
        if(authFactory.isLoggedIn()){
            return $http.post('/api/me');
        }
        else{
            $q.reject({msg: 'User has no token.'});
        }
    }

    
    authFactory.facebook = function(token){
        AuthToken.setToken(token);
    }

    return authFactory;
})

.factory("AuthToken", function($window){
    var authTokenFactory = {};

    authTokenFactory.setToken = function(token){
        if(token){
            $window.localStorage.setItem('token', token);
        }
        else{
            $window.localStorage.removeItem('token');
        }
    }
    authTokenFactory.getToken = function(token){
        return $window.localStorage.getItem('token');
    }




    return authTokenFactory;
})


.factory('AuthInterceptors', function(AuthToken){
    var authInterceptorsFactory = {};



    authInterceptorsFactory.request = function(config){
        var token = AuthToken.getToken();

        if(token){
            config.headers['x-access-token'] = token;
        }

        return config;
    }




    return authInterceptorsFactory;
});