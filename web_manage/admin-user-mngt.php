<?php
session_start();
if ((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) &&
    (isset($_SESSION["admin"]) && $_SESSION["admin"] === true)) {
    $id = $_SESSION['id'];
    echo "<script> var id = $id </script>";
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
    <title>Blank Page - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="../lib/css/Toggle-Switch.css">
    <link rel="stylesheet" href="../lib/css/sweetalert.css">
</head>

<body id="page-top"
      style="font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;font-weight: 400;font-style: normal;">
<div id="wrapper">
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
                <li class="nav-item" role="presentation"><a class="nav-link" href="index.php"
                                                            style="color: rgb(0,0,0,0.9);font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;font-size: 14px;"><i
                                class="fas fa-tachometer-alt" style="color: rgb(0,0,0,0.9);"></i><span
                                style="font-size: 14px;color: rgba(31,31,31,0.9);">Dashboard</span></a></li>
                <li
                        class="nav-item" role="presentation"><a class="nav-link" href="admin-project-mngt.php"
                                                                style="color: rgb(0,0,0,0.9);font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;font-size: 14px;"><i
                                class="fas fa-pager" style="color: rgb(0,0,0,0.9);"></i><span
                                style="font-size: 14px;color: rgba(31,31,31,0.9);">Pages</span></a></li>
                <li
                        class="nav-item" role="presentation"><a class="nav-link active" href="admin-user-mngt.php"
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
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
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
                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow" role="presentation">
                            <div class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false"
                                   data-bs-hover-animate="pulse" href="#" style="font-size: 14px;">
                                        <span class="d-none d-lg-inline mr-2 text-gray-600 small"
                                              style="font-size: 14px;">
                                             Hi, <?php
                                            if (isset($_SESSION["name"]))
                                                echo $_SESSION["name"];
                                            else
                                                echo "USER";
                                            ?>
                                        </span>
                                    <img class="border rounded-circle img-profile" src="<?php
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
                <h1 class="display-4 text-dark mb-4" style="font-size: 28px;">User Management</h1>
                <div class="card border rounded-0 shadow">
                    <div class="card-header py-3" style="background-color: rgb(246,248,254);">
                        <p class="m-0 font-weight-bold">
                            <button class="btn btn-outline-dark invisible" id="addNew-1" type="button"
                                    title="add new component" style="font-size: 12px;"><i class="fas fa-plus"
                                                                                          style="font-size: 12px;"></i>
                            </button>
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-nowrap">
                                <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                    <label style="font-size: 14px;">Sorted by&nbsp;
                                        <select class="border rounded-0 form-control form-control-sm custom-select custom-select-sm"
                                                id="sort" style="background-color: rgb(246,248,254);">
                                            <option value="user_id">ID</option>
                                            <option value="username">Username</option>
                                            <option value="email">Email</option>
                                            <option value="type">Type</option>
                                        </select>&nbsp;
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right d-flex float-right dataTables_filter" id="dataTable_filter">
                                    <input class="border rounded-0" type="search" id="search-field"
                                           style="font-size: 14px;background-color: rgb(246,248,254);padding: 4px 8px;"
                                           placeholder="Search Users">
                                    <button class="btn btn-outline-dark border rounded-0"
                                            id="search" type="button" style="font-size: 12px;"><i
                                                class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTable" role="grid"
                             aria-describedby="dataTable_info">
                            <table class="table dataTable my-0" id="dataTable">
                                <thead>
                                <tr style="font-size: 15px;" class="text-center">
                                    <th style="width: 16.66%">ID</th>
                                    <th style="width: 16.66%">Username</th>
                                    <th style="width: 16.66%">Email</th>
                                    <th style="width: 16.66%">User Type</th>
                                    <th style="width: 16.66%">Status</th>
                                    <th style="width: 16.66%">Options</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="project-list" class="text-center">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
                                    <td><strong></strong></td>
                                    <td><strong></strong></td>
                                    <td><strong></strong></td>
                                    <td><strong></strong></td>
                                    <td><strong></strong></td>
                                    <td><strong></strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6 align-self-center"></div>
                            <div class="col-md-6">
                                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination">
                                    </ul>
                                </nav>
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
        <input class="btn btn-primary" id="modify-user" type="hidden" data-toggle="modal"
               data-target="#user_modal">
        <div class="modal fade border rounded" role="dialog" tabindex="-1" id="user_modal"
             style="padding: 100px;margin: 0px;width: 100%;height: 100%;">
            <div class="modal-dialog" role="document" style=" max-width: 650px">
                <div class="modal-content">
                    <div class="modal-header" style="width: 648px;height: 75px;">
                        <h1 class="display-4 modal-title" style="font-size: 33px;">User</h1>
                        <button type="button" class="close" id="close-user-form" data-dismiss="modal"
                                aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" id="popup_momorizeCheck" style="width: 648px;background-color: #f6f5fb;">

                        <form>
                            <div class="form-group row">
                                <label for="staticID" class="col-sm-2 col-form-label">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticID"
                                           value="USER_ID">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticUsername" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticUsername"
                                           value="USERNAME">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name"
                                           value="USER_NAME"
                                           style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);">
                                    <span class="help-block" id="user-error" style="color: red"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="Email"
                                           value="USER@BROCKU.CA"
                                           style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);">
                                    <span class="help-block" id="email-error" style="color: red"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputPassword"
                                           placeholder="Password"
                                           style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row" style="padding-left: 12px">
                                        <label>Enable</label>
                                        <div class="col-sm-10">
                                            <label class="switch" style="margin-top: 2px;margin-left: 10px">
                                                <input id="user-enable" type='checkbox'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row">
                                        <label>Admin</label>
                                        <div class="col-sm-10">
                                            <label class="switch" style="margin-top: 2px; margin-left: 10px">
                                                <input id="user-admin" type='checkbox'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer" style="width: 648px;">
                        <button class="btn btn-primary btn-block border rounded" id="popup_save_btn" type="submit"
                                style="height: 45px;">Save
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="assets/js/script.min.js"></script>
<script src="../lib/js/sweetalert.min.js"></script>
<script>
    var user_list_page = 1;
    var total_page = 1;
    var sort = "user_id";
    var keyword = "";
    $(this).on("load", function () {
        loadList();
    });

    function getPage(event) {
        $(".pagination li").removeClass("active");
        $(event.target.parentElement).addClass("active");
        user_list_page = parseInt($(event.target).attr("page"));
        loadList();
    }

    function prePage(event) {
        if (user_list_page > 1) {
            var current = $(".pagination .active");
            $(current.get(0).previousElementSibling).addClass("active");
            current.removeClass("active");
            user_list_page--;
            loadList();
        }
    }

    function nextPage(event) {
        if (user_list_page < total_page) {
            var current = $(".pagination .active");
            $(current.get(0).nextElementSibling).addClass("active");
            current.removeClass("active");
            user_list_page++;
            loadList();
        }
    }

    function loadList() {
        $.ajax({
            url: "../lib/account.php/",
            type: "GET",
            cache: false,
            data: {
                type: "admin",
                page: user_list_page,
                sort: sort,
                search: keyword,
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                if (dataResult.status) {
                    $("#project-list").empty();
                    $("#project-list").append(html);
                    total_page = dataResult.page;
                    //make sure the page are in the range
                    if (user_list_page > total_page)
                        user_list_page = total_page;
                    if (user_list_page <= 0)
                        user_list_page = 1;
                    for (var i = 0; i < dataResult.project.length; i++) {
                        var user_status = dataResult.project[i].is_enable == "t" ? "Enable" : "Disable";
                        var user_type = dataResult.project[i].type == "0" ? "ADMIN" : "USER";
                        var is_self = id == dataResult.project[i].user_id ? "disabled" : "";
                        var html = "<tr>" +
                            "<td style=\"padding: 17px;\">" + dataResult.project[i].user_id + "</td>" +
                            "<td style=\"padding: 17px;\">" + dataResult.project[i].username + "</td>" +
                            "<td style=\"padding: 17px;\">" + dataResult.project[i].email + "</td>" +
                            "<td style=\"padding: 17px;\">" + user_type + "</td>" +
                            "<td style=\"padding: 17px;\">" + user_status + "</td>" +
                            "<td style=\"padding: 17px;\">" +
                            "<div class=\"btn-group\" role=\"group\" style=\"font-size: 12px;\"><button class=\"btn\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" data-bs-hover-animate=\"pulse\" id=\"properties_usr_btn_admin_pg\" type=\"button\" style=\"font-size: 12px;\" title=\"Change settings\" onclick='changeAccount(" + dataResult.project[i].user_id + ")' " + is_self + "><i class=\"fas fa-cogs\"></i></button></div>" +
                            "</td><td></td>" +
                            "</tr>";
                        $("#project-list").append(html);
                    }
                    pagination(total_page);
                } else
                    swal("Failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        })
    }

    function pagination(pages) {
        $(".pagination").empty();
        var html = "<li class=\"page-item pre-btn\" onclick=\"prePage(event)\"><a class=\"page-link\" href=\"#\" aria-label=\"Previous\" style='height:38px'><i class=\"fa fa-caret-left\" style='padding-top:2px'></i></a></li>" +
            "<li class=\"page-item\" onclick=\"getPage(event)\"><a class=\"page-link\" href=\"#\" page=\"1\">1</a></li>";
        for (var i = 2; i <= pages; i++) {
            html += "<li class=\"page-item\" onclick=\"getPage(event)\"><a class=\"page-link\" href=\"#\" page=\"" + i + "\">" + i + "</a></li>";
        }
        html += "<li class=\"page-item next-btn\" onclick=\"nextPage(event)\"><a class=\"page-link\" href=\"#\" aria-label=\"Next\" style='height:38px'><i class=\"fa fa-caret-right\" style='padding-top:2px'></i></a></li>";
        $(".pagination").append(html);
        $(".pagination :nth-child(" + (user_list_page + 1) + ")").addClass("active");
    }

    $("#sort").on("change", function (event) {
        user_list_page = 1;
        sort = $("#sort").val();
        loadList();
    });

    $("#search").on("click", function () {
        user_list_page = 1;
        keyword = $("#search-field").val();
        loadList();
    });

    function changeAccount(id) {
        $("#staticID").val("");
        $("#staticUsername").val("");
        $("#inputEmail").val("");
        $("#inputName").val("");
        $("#inputPassword").val("");
        $("#user-enable").prop("checked", false);
        $("#user-admin").prop("checked", false);

        $.ajax({
            url: "../lib/account.php/",
            type: "GET",
            cache: false,
            data: {
                type: "user",
                id: id,
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                $("#staticID").val(id);
                $("#staticUsername").val(dataResult.username.trim());
                $("#inputName").val(dataResult.name.trim());
                $("#inputEmail").val(dataResult.email.trim());
                $("#user-enable").prop("checked", dataResult.enable === "t");
                $("#user-admin").prop("checked", dataResult.type === "0");
                $("#modify-user").click();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    }


    $("#popup_save_btn").on("click", function () {
        $("#user-error").text("");
        $("#email-error").text("");
        var pattern = new RegExp(/^[A-Za-z0-9]+$/);
        if ($("#inputName").val() == "") {
            $("#user-error").text("Name can't be empty");
            return;
        } else if (!pattern.test($("#inputName").val())) {
            $("#user-error").text("Name cannot contains special character.");
            return;
        } else if (!validateEmail($("#inputEmail").val())) {
            $("#email-error").text("Incorrect email format!");
            return;
        }

        $.ajax({
            url: "../lib/account.php/",
            type: "POST",
            cache: false,
            data: {
                type: "updateUser",
                id: $("#staticID").val(),
                name: $("#inputName").val(),
                email: $("#inputEmail").val(),
                password: $("#inputPassword").val(),
                enable: $("#user-enable").prop("checked"),
                admin: $("#user-admin").prop("checked") === true ? "0" : "1",
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                if (dataResult.status === true) {
                    swal("Success", "User Info has been updated", "success");
                    $("#inputPassword").val("");
                    loadList();
                } else {
                    swal("Update Failed!", dataResult.msg, "error");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });

    });

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }


</script>
</body>

</html>