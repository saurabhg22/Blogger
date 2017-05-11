var app = angular.module("appRoutes", ["ngRoute"])

.config(function($routeProvider, $locationProvider){
    $locationProvider.hashPrefix('');


    $routeProvider
    
    .when('/', {
        templateUrl: "app/views/pages/home.html",
        authenticated: true
    })

    .when('/blogdetails/:id', {
        templateUrl: "app/views/pages/blog.html",
        controller: 'blogCtrl',
        controllerAs: 'blog'
    })

    .when('/login', {
        templateUrl: "app/views/pages/user/login.html",
        authenticated: false
    })

    .when('/newblog', {
        templateUrl: "app/views/pages/newblog.html",
        authenticated: true,
        controller: 'newBlogCtrl',
        controllerAs: 'newblog'
    })


    .when('/logout', {
        templateUrl: "app/views/pages/user/logout.html",
        authenticated: true
    })

    .when('/profile', {
        templateUrl: "app/views/pages/user/profile.html",
        authenticated: true
    })

    .when('/facebook/:token', {
        templateUrl: "app/views/pages/user/social/social.html",
        controller: 'facebookCtrl',
        controllerAs: 'facebook'
    })

    .when('/facebookerr', {
        templateUrl: "app/views/pages/user/login.html",
        controller: 'facebookCtrl',
        controllerAs: 'facebook'
    })

    .when('/register', {
        templateUrl: "app/views/pages/user/reg.html",
        controller:  "regCtrl",
        controllerAs: "register",
        authenticated: false
    })

    .otherwise({ redirectTo: '/' });
    
    
    $locationProvider.html5Mode({ enabled: true, requireBase: false });
});



// Run a check on each route to see if user is logged in or not (depending on if it is specified in the individual route)
app.run(['$rootScope', 'Auth', '$location', function($rootScope, Auth, $location) {

    // Check each time route changes    
    $rootScope.$on('$routeChangeStart', function(event, next, current) {

        // Only perform if user visited a route listed above
        if (next.$$route !== undefined) {
            // Check if authentication is required on route

            if (next.$$route.authenticated === true) {
                // Check if authentication is required, then if permission is required
                if (!Auth.isLoggedIn()) {
                    event.preventDefault(); // If not logged in, prevent accessing route
                    $location.path('/login'); // Redirect to home instead
                } 
            } else if (next.$$route.authenticated === false) {
                // If authentication is not required, make sure is not logged in
                if (Auth.isLoggedIn()) {
                    event.preventDefault(); // If user is logged in, prevent accessing route
                    $location.path('/profile'); // Redirect to profile instead
                }
            }
        }
    });
}]);