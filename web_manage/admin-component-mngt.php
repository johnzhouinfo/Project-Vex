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
    <title>Component Management</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="../lib/css/Toggle-Switch.css">
    <link rel="stylesheet" href="../lib/css/tln.css">
    <link rel="stylesheet" href="../lib/css/sweetalert.css">
    <link rel="icon" href="../img/Vex_Three.gif">
</head>

<body id="page-top"
      style="font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;">
<div id="wrapper"
     style="opacity: 1;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;font-weight: normal;font-style: normal;">
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
                        class="nav-item" role="presentation"><a class="nav-link" href="admin-user-mngt.php"
                                                                style="color: rgba(31,31,31,0.9);font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;"><i
                                class="fas fa-users" style="color: rgb(0,0,0,0.9);"></i><span style="font-size: 14px;">User management</span></a>
                </li>
                <li
                        class="nav-item" role="presentation"><a class="nav-link active" href="admin-component-mngt.php"
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
                                    <a id="manage-btn" role="presentation" class="dropdown-item" href="index.php"
                                       style="font-size: 14px;color: rgb(133,135,150);">
                                        <i class="fa fa-wrench fa-sm fa-fw mr-2 text-gray-400"></i>
                                         Web Manage
                                    </a>
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
                <h1 class="display-4 text-dark mb-4" style="font-size: 28px;">Components</h1>
                <div class="card border rounded-0 shadow">
                    <div class="card-header py-3" style="background-color: rgb(246,248,254);">
                        <p class="m-0 font-weight-bold" style="margin: 0px;padding: 0px;">&nbsp;<button
                                    class="btn btn-outline-dark border rounded-0" data-toggle="modal" data-bs-tooltip=""
                                    id="component-window" type="button"
                                    data-target="#user_modal" title="Add New Component" style="font-size: 12px;"><i
                                        class="fas fa-plus" style="font-size: 12px;"></i></button>
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-nowrap">
                                <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                    <label style="font-size: 14px;">Sorted by&nbsp;
                                        <select class="border rounded-0 form-control form-control-sm custom-select custom-select-sm"
                                                id="sort" style="background-color: rgb(246,248,254);">
                                            <option value="component_id">Component ID</option>
                                            <option value="component_name">Component Name</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right d-flex float-right dataTables_filter" id="dataTable_filter">
                                    <input class="border rounded-0" type="search" id="search-field"
                                           style="font-size: 14px;background-color: rgb(246,248,254);padding: 1px 10px;"
                                           placeholder="Search items" name="Search_bar">
                                    <button class="btn btn-outline-dark border rounded-0"
                                            data-toggle="tooltip" data-bs-tooltip="" type="button"
                                            style="font-size: 14px;" title="search" id="search">
                                        <i class="fa fa-search" data-bs-hover-animate="pulse"
                                           id="srch_cmpnt_btn_admin_pg"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTable" role="grid"
                             aria-describedby="dataTable_info">
                            <table class="table dataTable my-0" id="dataTable">
                                <thead>
                                <tr class="text-center" class="text-center" style="font-size: 14px;">
                                    <th>Component ID</th>
                                    <th>Component Icon</th>
                                    <th>Component Name</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody class="text-center" id="project-list">
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td></td>
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
        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Vex 2020</span></div>
            </div>
            <div class="modal fade border rounded" role="dialog" tabindex="-1" id="user_modal"
                 style="padding: 20px;margin: 0px;width: 100%;height: 100%;">
                <div class="modal-dialog" role="document" style=" max-width: 650px">
                    <div class="modal-content">
                        <div class="modal-header" style="width: 648px;height: 75px;">
                            <h1 class="display-4 modal-title" style="font-size: 33px;">Component</h1>
                            <button type="button" class="close" id="close-component-form" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body" id="popup_momorizeCheck"
                             style="width: 648px;background-color: #f6f5fb;">

                            <form>
                                <input id="staticID" hidden value="">
                                <div class="form-group row">
                                    <label for="inputImage" class="col-sm-2 col-form-label">Icon</label>
                                    <div class="col-sm-10">
                                        <img src="../img/empty-avatar.png" id="inputImage" alt="component logo"
                                             width="100"
                                             height="100"
                                             style="border:1px solid black; border-radius: 20px;">
                                        <input type="file" class="form-control" id="inputImage-btn"
                                               style="background-color: transparent; border: 0px">
                                        <span class="help-block" id="email-error" style="color: red"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName"
                                               placeholder="Component Name"
                                               style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);">
                                        <span class="help-block" id="user-error" style="color: red"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="component-code-field" class="col-sm-2 col-form-label">Code</label>
                                    <div class="col-sm-10">
                                        <div id="input-code">
                                            <textarea id="component-code-field" class="banana-cake"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    #input-code {

                                        position: relative;
                                        left: -50px;
                                        height: 300px;
                                        width: 560px;
                                        margin: 15px auto
                                    }

                                </style>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Enable</label>
                                    <div class="col-sm-10">
                                        <label class="switch" style="margin-top: 8px;">
                                            <input id="component-enable" type='checkbox'>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer" style="width: 648px;">
                            <button class="btn btn-block border rounded" id="preview_btn" type="submit"
                                    style="height: 45px;">Preview
                            </button>
                            <button class="btn btn-primary btn-block border rounded" id="popup_save_btn" type="submit"
                                    style="height: 45px; margin-top: 0px">Save
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="assets/js/script.min.js"></script>
<script src="../lib/js/sweetalert.min.js"></script>
<script src="../lib/js/tln.js"></script>
<script>
    var component_list_page = 1;
    var total_page = 1;
    var sort = "component_id";
    var keyword = "";
    $(this).on("load", function () {
        TLN.append_line_numbers('component-code-field');
        loadList();
    });

    $("#component-window").on("click", function () {
        clearField();
    });

    $("#inputImage-btn").on("change", uploadFile);

    // Click the page num btn
    function getPage(event) {
        $(".pagination li").removeClass("active");
        $(event.target.parentElement).addClass("active");
        component_list_page = parseInt($(event.target).attr("page"));
        loadList();
    }

    // Click the previous page btn
    function prePage(event) {
        if (component_list_page > 1) {
            var current = $(".pagination .active");
            $(current.get(0).previousElementSibling).addClass("active");
            current.removeClass("active");
            component_list_page--;
            loadList();
        }
    }

    // Click the next page btn
    function nextPage(event) {
        if (component_list_page < total_page) {
            var current = $(".pagination .active");
            console.log(current);
            $(current.get(0).nextElementSibling).addClass("active");
            current.removeClass("active");
            component_list_page++;
            loadList();

        }
    }

    // Fetch through ajax request and display the list
    function loadList() {
        $.ajax({
            url: "../lib/component.php/",
            type: "GET",
            cache: false,
            data: {
                type: "list",
                page: component_list_page,
                sort: sort,
                search: keyword,
            },
            success: function (data) {

                var dataResult = JSON.parse(data);
                console.log(dataResult);
                if (dataResult.status) {
                    $("#project-list").empty();
                    $("#project-list").append(html);
                    total_page = dataResult.page;
                    for (var i = 0; i < dataResult.project.length; i++) {
                        var component_status = dataResult.project[i].is_enable == "t" ? "Enable" : "Disable";
                        var img_url = dataResult.project[i].icon == "" ? "../img/empty-avatar.png" : dataResult.project[i].icon;
                        var html = "<tr>" +
                            "<td>" + dataResult.project[i].component_id + "</td>" +
                            "<td><img style='width:30px; height:30px; border-radius: 5px;' src='" + img_url + "' alt='" + dataResult.project[i].component_name + "'></td>" +
                            "<td>" + dataResult.project[i].component_name + "</td>" +
                            "<td>" + component_status + "</td>" +
                            "<td>" +
                            "<button class=\"btn\" onclick='changeComponent(" + dataResult.project[i].component_id + ")' data-toggle=\"tooltip\" data-bs-tooltip=\"\" data-bs-hover-animate=\"pulse\" id=\"properties_cmpnt_btn_admin_pg\" type=\"button\" style=\"font-size: 12px;\" title=\"Properties\">" +
                            "<i class=\"fas fa-cog\" onclick='changeComponent(" + dataResult.project[i].component_id + ")'></i></button>" +
                            "<button class=\"btn\" onclick='deleteComponent(event)' component-id='" + dataResult.project[i].component_id + "' data-bs-hover-animate=\"pulse\" id=\"delete_cmpnt_btn_admin_pg\" type=\"button\" style=\"font-size: 12px;\">" +
                            "<i class=\"fa fa-remove\" onclick='deleteComponent(event)' component-id='" + dataResult.project[i].component_id + "' data-toggle=\"tooltip\" data-bs-tooltip=\"\" title=\"Delete\"></i>" +
                            "</button>" +
                            "</td>" +
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

    // Sorting event
    $("#sort").on("change", function (event) {
        component_list_page = 1;
        sort = $("#sort").val();
        loadList();
    });

    // Search event
    $("#search").on("click", function () {
        component_list_page = 1;
        keyword = $("#search-field").val();
        loadList();
    });

    // Load the page nav btns
    function pagination(pages) {
        $(".pagination").empty();
        var html = "<li class=\"page-item pre-btn\" onclick=\"prePage(event)\"><a class=\"page-link\" href=\"#\" aria-label=\"Previous\" style='height:38px'><i class=\"fa fa-caret-left\" style='padding-top:2px'></i></a></li>" +
            "<li class=\"page-item\" onclick=\"getPage(event)\"><a class=\"page-link\" href=\"#\" page=\"1\">1</a></li>";
        for (var i = 2; i <= pages; i++) {
            html += "<li class=\"page-item\" onclick=\"getPage(event)\"><a class=\"page-link\" href=\"#\" page=\"" + i + "\">" + i + "</a></li>";
        }
        html += "<li class=\"page-item next-btn\" onclick=\"nextPage(event)\"><a class=\"page-link\" href=\"#\" aria-label=\"Next\" style='height:38px'><i class=\"fa fa-caret-right\" style='padding-top:2px'></i></a></li>";
        $(".pagination").append(html);
        $(".pagination :nth-child(" + (component_list_page + 1) + ")").addClass("active");
    }

    // preview the component that user input
    $("#preview_btn").on("click", function () {
        var html = "<head><meta charset=\"utf-8\">" +
            "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, shrink-to-fit=no\">" +
            "<title>Preview</title>" +
            "<link rel=\"stylesheet\" href=\"lib/bootstrap/css/bootstrap.min.css\">" +
            "<link rel=\"stylesheet\" href=\"lib/fonts/font-awesome.min.css\">" +
            "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'><" + "/script> " +
            "<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js'><" + "/script>" +
            "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'><" + "/script></head>";
        html += $("#component-code-field").val();
        OpenWindowWithPost(html);
    });

    // Open a preview page through post request
    function OpenWindowWithPost(html) {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "../preview.php");
        form.setAttribute("target", "Preview");

        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = "preview";
        input.value = html;
        form.appendChild(input);

        document.body.appendChild(form);
        window.open("../preview.php", "Preview");
        form.submit();
        document.body.removeChild(form);
    }

    //Click modify btn, the modify page will show up and load the component information
    function changeComponent(id) {
        clearField();
        $.ajax({
            url: "../lib/component.php/",
            type: "GET",
            cache: false,
            data: {
                type: "retrieve",
                id: id,
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                console.log(dataResult);
                $("#component-window").click();
                $("#staticID").val(dataResult.component_id.trim());
                $("#inputName").val(dataResult.component_name.trim());
                $("#inputImage").attr("src", dataResult.icon === "" ? "../img/empty_avatar.png" : dataResult.icon.trim());
                $("#component-code-field").val(dataResult.html.trim().replace(/&apos:/g, "'"));
                $("#component-enable").prop("checked", dataResult.is_enable === "t");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    }

    // It will save or update the component
    $("#popup_save_btn").on("click", function () {
        var isCreate = $("#staticID").val() === "";
        var type = isCreate ? "create" : "update";
        var html = $("#component-code-field").val().replace(/'/g, "&apos:");
        var src = $("#inputImage").attr("src") === "../img/empty_avatar.png" ? "./img/empty_avatar.png" : $("#inputImage").attr("src");
        $.ajax({
            url: "../lib/component.php/",
            type: "POST",
            cache: false,
            data: {
                type: type,
                id: $("#staticID").val(),
                name: $("#inputName").val(),
                icon: src,
                html: html,
                enable: $("#component-enable").prop("checked"),
            },
            success: function (data) {
                console.log(data);
                var dataResult = JSON.parse(data);
                if (dataResult.status === true) {
                    if (isCreate) {
                        swal("Success", "This Component has been created", "success");
                        $("#staticID").val(dataResult.component_id.trim());
                    } else {
                        swal("Success", "This Component has been updated", "success");
                    }
                    $("#close-component-form").click();
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

    // Delete the component
    function deleteComponent(event) {
        var componentId = $(event.target).attr("component-id");
        var parent = $(event.target.parentElement.parentElement);
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this component!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    //The page in the database
                    $.ajax({
                        type: "POST",
                        url: "../lib/component.php",
                        async: true,
                        timeout: 5000,
                        data: {
                            type: "delete",
                            id: componentId,
                        },
                        success: function (data) {
                            console.log(data);
                            var data = JSON.parse(data);
                            if (data.status == true) {
                                setTimeout(function () {
                                    swal("Deleted!", "This component has been deleted!", "success");
                                    parent.remove();
                                }, 1000);
                            } else {
                                setTimeout(function () {
                                    swal("Failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");
                                }, 1000);
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
                        }
                    });
                }
            });
    }

    function clearField() {
        $("#staticID").val("");
        $("#inputName").val("");
        $("#inputImage").attr("src", "../img/empty-avatar.png");
        $("#component-code-field").val("");
        $("#component-enable").prop("checked", false);
        $("#inputImage-btn").val("");
        //Reset field;
        TLN.remove_line_numbers("component-code-field");
        TLN.append_line_numbers("component-code-field");
    }

    /**
     * This method will convert image to base64 and return the URL to input field
     * @param event
     */
    function uploadFile(event) {
        var fileTypes = ['jpg', 'jpeg', 'png'];
        if (this.files && this.files[0]) {
            var extension = this.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
                isSuccess = fileTypes.indexOf(extension) > -1,
                FileSize = this.files[0].size / 1024 / 1024;
            if (FileSize > 5) {
                swal("File type incorrect", "File size exceeds 5 MB.", "error");
                $(event.target).val("");
            } else if (isSuccess) {
                var FR = new FileReader();
                FR.addEventListener("load", function (e) {
                    $.ajax({
                        type: "POST",
                        url: "../lib/upload.php",
                        data: {
                            data: e.target.result,
                            extension: extension,
                        },
                        success: function (data) {
                            console.log(data);
                            var data = JSON.parse(data);

                            if (data.status == true) {
                                var hostname = window.location.href.slice(0, window.location.href.indexOf("/web_manage"));
                                console.log(hostname);
                                $("#inputImage").attr("src", hostname + data.msg);
                            } else {
                                swal("Failed!", "Error Code: " + data.code + "\nDescription: " + data.msg, "error");
                            }
                        },
                    });

                });
                FR.readAsDataURL(this.files[0]);
            } else {
                swal("File type incorrect", "We only support jpg, jpeg, png format.", "error");
            }

        }
    }


</script>
</body>

</html>