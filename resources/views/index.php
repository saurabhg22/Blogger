<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="/">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="description" content="Blogger is an online platform for sharing knowledge, ideas and creativity.">
        <meta name="author" content="Saurabh Gupta">

        <!-- Cascade Style Sheets -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
        <link href="assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/lightbox.css" rel="stylesheet"> 
        <link href="assets/css/main.css" rel="stylesheet">
        <link href="assets/css/responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" type="text/scss" href="assets/css/style.css">



        <link rel="shortcut icon" href="assets/images/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/images/ico/apple-touch-icon-57-precomposed.png">

         <!-- Main Angular Files -->
        <script type="text/javascript" src="assets/js/angular.min.js"></script>
        <script type="text/javascript" src="assets/js/angular-route.min.js"></script>
        <script type="text/javascript" src="assets/js/angular-animate.min.js"></script>
        <script type="text/javascript" src="app/app.js"></script>
        <script type="text/javascript" src="app/routes.js"></script>
        <script type="text/javascript" src="https://connect.facebook.net/en_US/sdk.js"></script>
        <script type="text/javascript" src="app/services/authServices.js"></script>
        <script type="text/javascript" src="app/controllers/userCtrl.js"></script>
        <script type="text/javascript" src="app/controllers/mainCtrl.js"></script>
        <script type="text/javascript" src="app/controllers/blogCtrl.js"></script>
        <script type="text/javascript" src="app/controllers/newBlogCtrl.js"></script>

        <title>Etale</title>
    </head>

    <body ng-app="userApp" ng-controller="mainCtrl as main" ng-show="!main.loading" ng-cloak>
        <header id="header">      
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 overflow">
                    <div class="social-icons pull-right">
                            <ul class="nav nav-pills">
                                <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                                <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                                <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="navbar navbar-inverse" role="banner">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="navbar-brand" href="">
                            <h1>
                                <img class="logo" src="assets/images/logo.png" alt="logo">
                                Dentalkart Blogger
                            </h1>
                        </a>
                        
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/">Home</a></li>
                            <li ng-show="main.ispermit"><a href="/newblog">Create Blog</a></li>
                            <li ng-show="!main.isLoggedIn"><a href="/register">Sign Up</a></li>
                            <li ng-show="!main.isLoggedIn"><a href="/login">Login&nbsp;&nbsp;</a></li>
                            <li ng-show="main.isLoggedIn"><a href="/profile">Hello,&nbsp;&nbsp;&nbsp;{{main.name}}</a></li>
                            <li ng-show="main.isLoggedIn"><a href="#" ng-click="main.logout();">Logout</a></li>
                                              
                        </ul>
                    </div>
                    <div class="search">
                        <form role="form">
                            <i class="fa fa-search"></i>
                            <div class="field-toggle">
                                <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>



        <div class="view" ng-view></div>









        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/lightbox.min.js"></script>
        <script type="text/javascript" src="assets/js/wow.min.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>   
    </body>
</html>