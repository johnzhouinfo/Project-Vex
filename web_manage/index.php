<?php
session_start();
if ((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) &&
    (isset($_SESSION["admin"]) && $_SESSION["admin"] === true)) {

} else {
    header("location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="../lib/css/sweetalert.css">
</head>

<body id="page-top"
      style="font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;">
<div id="wrapper" style="opacity: 1;">
    <nav class="navbar navbar-light align-items-start sidebar sidebar-dark accordion"
         style="background-color: rgb(255,255,255);/*font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;*/padding: 8px 0px;font-size: 14px;">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
               href="../index.php" style="color: rgb(0,0,0,0.9);opacity: 1;padding: 24px 0px;margin: 0px;">
                <h1 class="display-4 text-capitalize" style="font-size: 20px;"><img
                            style="width: 23px;height: 23px;padding: 0px;" src="assets/img/Vex_Three.gif">&nbsp;Vex-Admin
                </h1>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item" role="presentation"><a class="nav-link active" href="index.php"
                                                            style="color: rgb(0,0,0,0.9);font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;font-size: 14px;"><i
                                class="fas fa-tachometer-alt" style="color: rgb(0,0,0,0.9);"></i><span
                                style="font-size: 14px;color: rgba(31,31,31,0.9);">Dashboard</span></a></li>
                <li
                        class="nav-item" role="presentation"><a class="nav-link" href="admin-project-mngt.php"
                                                                style="color: rgb(0,0,0,0.9);font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;font-size: 14px;"><i
                                class="fas fa-pager" style="color: rgb(0,0,0,0.9);"></i><span
                                style="font-size: 14px;color: rgba(31,31,31,0.9);">Pages</span></a></li>
                <li
                        class="nav-item" role="presentation"><a class="nav-link" href="admin-user-mngt.php"
                                                                style="color: rgba(31,31,31,0.9);font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;"><i
                                class="fas fa-users" style="color: rgb(0,0,0,0.9);"></i><span style="font-size: 14px;">User management</span></a>
                </li>
                <li
                        class="nav-item" role="presentation"><a class="nav-link" href="admin-component-mngt.php"
                                                                style="color: rgba(31,31,31,0.9);font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;font-size: 14px;"><i
                                class="fas fa-cube" style="color: rgb(0,0,0,0.9);"></i><span style="font-size: 14px;">Components</span></a>
                </li>
                <li
                        class="nav-item" role="presentation"></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="admin-ticket-mngt.php"
                                                            style="color: rgba(31,31,31,0.9);"><i
                                class="fas fa-question-circle" style="color: rgb(0,0,0,0.9);"></i><span
                                style="font-size: 14px;">Tickets</span></a></li>
                <li class="nav-item"
                    role="presentation"></li>
            </ul>
        </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top"
                 style="font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i
                                class="fas fa-bars"></i></button>
                    <ul class="nav navbar-nav flex-nowrap ml-auto">
                        <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link"
                                                                            data-toggle="dropdown" aria-expanded="false"
                                                                            href="#"><i class="fas fa-search"></i></a>
                            <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" role="menu"
                                 aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto navbar-search w-100">
                                    <div class="input-group"><input class="bg-light form-control border-0 small"
                                                                    type="text" placeholder="Search for ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary py-0" type="button"><i
                                                        class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow" role="presentation">
                            <div class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false"
                                   data-bs-hover-animate="pulse" href="#" style="font-size: 14px;">
                                        <span class="d-none d-lg-inline mr-2 text-gray-600 small" id="nav-name"
                                              style="font-size: 14px;">
                                             Hi, <?php
                                            if (isset($_SESSION["name"]))
                                                echo $_SESSION["name"];
                                            else
                                                echo "USER";
                                            ?>
                                        </span>
                                    <img class="border rounded-circle img-profile" id="nav-avatar" src="<?php
                                    if (isset($_SESSION["loggedin"])) {
                                        echo($_SESSION["icon"] == null ? "../img/empty-avatar.png" : $_SESSION["icon"]);
                                    }
                                    ?>" alt="">
                                </a>
                                <div class="dropdown-menu border rounded-0 shadow-sm dropdown-menu-right animated--grow-in"
                                     role="menu" style="color: rgb(62,63,69);">
                                    <a class="dropdown-item" role="presentation" href="../user/user_profile.php"
                                       style="font-size: 14px;color: rgb(133,135,150);">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"
                                           style="color: rgb(44,44,47);"></i>
                                        &nbsp;Profile</a>
                                    <a class="dropdown-item" role="presentation" href="../user/user_project.php"
                                       style="font-size: 14px;color: rgb(133,135,150);">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        &nbsp;Project
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="presentation" href="../logout.php"
                                       style="color: rgb(135,135,135);font-size: 14px;">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        &nbsp;Logout
                                    </a></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-4 text-dark mb-0" style="font-size: 28px;">Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border rounded-0 shadow border-left-primary py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Users</span>
                                        </div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><a id="user-size"
                                                                                           href="admin-user-mngt.php">N/A</a>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border rounded-0 shadow border-left-success py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Projects</span>
                                        </div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><a id="page-size"
                                                                                           href="admin-project-mngt.php">N/A</a>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border rounded-0 shadow border-left-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span
                                                    style="color: rgb(228,13,65);">Pages on live</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><a id="live-size"
                                                                                           href="admin-project-mngt.php">N/A</a>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="far fa-newspaper fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border rounded-0 shadow border-left-dark py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"
                                             style="color: rgb(78,115,223);"><span style="color: rgb(78,115,223);">Tickets</span>
                                        </div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><a id="ticket-size"
                                                                                           href="admin-ticket-mngt.php">N/A</a>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-ticket-alt fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white sticky-footer" title="search">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Vex 2020</span></div>
            </div>
        </footer>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="assets/js/script.min.js"></script>
<script src="../lib/js/sweetalert.min.js"></script>
<script>

    $(this).on("load", function () {
        loadPageUser();
        loadPagePage();
        loadPageLive();
        loadPageTicket();
    });

    // Retrieve the number of user
    function loadPageUser() {
        $.ajax({
            url: "../lib/manage.php/",
            type: "GET",
            cache: false,
            data: {
                type: "numUsers",
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                console.log(dataResult);
                if (dataResult.status) {
                    $("#user-size").text(dataResult.result.trim());
                } else
                    swal("Failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        })
    }

    // Retrieve the number of pages
    function loadPagePage() {
        $.ajax({
            url: "../lib/manage.php/",
            type: "GET",
            cache: false,
            data: {
                type: "numPages",
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                console.log(dataResult);
                if (dataResult.status) {
                    $("#page-size").text(dataResult.result.trim());
                } else
                    swal("Failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        })
    }

    // Retrieve the number of lived page
    function loadPageLive() {
        $.ajax({
            url: "../lib/manage.php/",
            type: "GET",
            cache: false,
            data: {
                type: "numLives",
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                console.log(dataResult);
                if (dataResult.status) {
                    $("#live-size").text(dataResult.result.trim());
                } else
                    swal("Failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        })
    }

    // Retrieve the number of ticket
    function loadPageTicket() {
        $.ajax({
            url: "../lib/manage.php/",
            type: "GET",
            cache: false,
            data: {
                type: "numTickets",
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                console.log(dataResult);
                if (dataResult.status) {
                    $("#ticket-size").text(dataResult.result.trim());
                } else
                    swal("Failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        })
    }
</script>
</body>

</html>