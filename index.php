<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Homepage</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="lib/css/Features-Clean.css">
    <link rel="stylesheet" href="lib/css/Footer-Basic.css">
    <link rel="stylesheet" href="lib/css/Highlight-Clean.css">
    <link rel="stylesheet" href="lib/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="lib/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="lib/css/styles.css">
    <link rel="stylesheet" href="lib/css/sweetalert.css">
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
<div class="container">
    <nav class="navbar navbar-light navbar-expand fixed-top text-center"
         style="background-color: #ffffff;padding: 2% 5%;height: 80px;">
        <div class="container-fluid"><img id="home_emblem" style="width: 24px;height: 24px;" src="img/Vex_Three.gif"><a
                    class="navbar-brand" id="home_brand" href="#">&nbsp;Vex</a>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav"></ul>
            </div>

            <div id="login-btn-group" style="display:
            <?php if (isset($_SESSION["id"])) {
                echo "none;";
            } else {
                echo "flex";
            }
            ?>">
                <button class="btn btn-primary" id="home_login" type="button" data-toggle="modal"
                        data-target="#login_modal">Login
                </button>
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation"><a class="nav-link text-primary" id="home_register"
                                                                href="register.php">Register</a></li>
                </ul>
            </div>
            <div id="user-btn-group" style=" display:
            <?php if (!isset($_SESSION["id"])) {
                echo "none;";
            } else {
                echo "";
            }
            ?>
                    ">
                <a data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle nav-link">
                    Hi! <span id="username-text" class="UserInfo-avatar">
                        <?php
                        if (isset($_SESSION["name"]))
                            echo $_SESSION["name"];
                        else
                            echo "USER";
                        ?>
                    </span>
                    <img style="border-radius: 50%;" class="avatar-img" id="user-avatar" width="40" height="40"
                         src="<?php
                         if (isset($_SESSION["loggedin"])) {
                             echo($_SESSION["icon"] == null ? "img/empty-avatar.png" : $_SESSION["icon"]);
                         }
                         ?>" alt="">
                </a>
                <div role="menu" class="dropdown-menu shadow dropdown-menu-right animated--grow-in">
                    <a role="presentation" class="dropdown-item" href="#">
                        <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                         Profile
                    </a>
                    <a role="presentation" class="dropdown-item" href="#">
                        <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                         Settings
                    </a>
                    <a role="presentation" class="dropdown-item" href="#">
                        <i class="fa fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                         Project
                    </a>
                    <div class="dropdown-divider"></div>
                    <a id="logout-btn" role="presentation" class="dropdown-item" href="#">
                        <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
                         Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>
<div class="text-center d-flex highlight-clean" style="height: 100vh;padding: 143px;">
    <div class="container-fluid text-center d-inline-flex" style="height: 123;padding: 0px 100px;width: 100%;">
        <div class="text-center d-inline-block intro" style="padding: 107px;">
            <h1 class="display-4 text-center d-inline-flex">Vex&nbsp;</h1>
            <h3 class="text-left d-inline-flex" style="width: 416px;"><em>A Free Website Builder</em></h3>
            <h3 class="text-center"><br></h3>
            <button class="btn btn-outline-secondary d-inline-flex" id="home_build_you_website" type="button">Build Your
                Website
            </button>
        </div>
    </div>
</div>
<div class="features-clean">
    <div class="container-fluid" style="background-color: rgba(228,216,244,0.6);">
        <div class="intro">
            <h2 class="text-center">Features</h2>
            <p class="text-center">These texts are from the template I chose, do remember to replace them when
                editing!!!</p>
        </div>
        <div class="row justify-content-center align-items-center features">
            <div class="col-auto col-sm-6 col-lg-4 item"><i class="fa fa-map-marker icon"></i>
                <h3 class="name">Works everywhere</h3>
                <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent
                    aliquam in tellus eu gravida. Aliquam varius finibus est.</p>
            </div>
            <div class="col-auto col-sm-6 col-lg-4 item"><i class="fa fa-clock-o icon"></i>
                <h3 class="name">Always available</h3>
                <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent
                    aliquam in tellus eu gravida. Aliquam varius finibus est.</p>
            </div>
            <div class="col-auto col-sm-6 col-lg-4 item"><i class="fa fa-list-alt icon"></i>
                <h3 class="name">Customizable</h3>
                <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent
                    aliquam in tellus eu gravida. Aliquam varius finibus est.</p>
            </div>
            <div class="col-auto col-sm-6 col-lg-4 item"><i class="fa fa-plane icon"></i>
                <h3 class="name">Fast</h3>
                <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent
                    aliquam in tellus eu gravida. Aliquam varius finibus est.</p>
            </div>
        </div>
    </div>
</div>
<div class="footer-basic">
    <footer>
        <p class="copyright">COSC4F00 VEX Group © 2020 March</p>
    </footer>
    <div class="modal fade border rounded" role="dialog" tabindex="-1" id="login_modal"
         style="padding: 100px;margin: 0px;width: 100%;height: 100%;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="width: 498px;height: 75px;">
                    <h1 class="display-4 modal-title" style="font-size: 33px;">Login</h1>
                    <button type="button" class="close" id="close-login-form" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="popup_momorizeCheck"
                     style="height: 210px;width: 498px;background-color: #f6f5fb;">
                    <label style="color: rgb(114,120,126);font-size: 14px;">Username</label> <span class="help-block"
                                                                                                   id="username-error"
                                                                                                   style="float: right"></span>
                    <form>
                        <div class="form-group" style="padding-bottom: 16px; margin-bottom: 0">
                            <input class="border rounded border-light form-control" type="text" id="popup_username"
                                   style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);" required=""
                                   name="usrnm" placeholder="Username">
                        </div>

                        <label style="color: rgb(114,120,126);font-size: 14px;">Password</label> <span
                                class="help-block" id="password-error" style="float: right"></span>
                        <div class="form-group">
                            <input class="border rounded border-light form-control" type="password" id="popup_password"
                                   style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);" required=""
                                   name="PW" placeholder="Password">
                        </div>


                    </form>

                </div>
                <div class="modal-footer" style="width: 498px;">
                    <button class="btn btn-primary btn-block border rounded" id="popup_loginBTN" type="submit"
                            style="height: 45px;">Sign in
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="lib/js/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script src="lib/js/sweetalert.min.js"></script>
<script src="js/common.js"></script>
<script src="js/index.js"></script>
</body>

</html>