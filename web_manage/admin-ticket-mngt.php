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
    <title>Ticket Management</title>
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
    <link rel="icon" href="../img/Vex_Three.gif">
</head>

<body id="page-top"
      style="font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;">
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
                <li class="nav-item" role="presentation"><a class="nav-link active" href="admin-ticket-mngt.php"
                                                            style="color: rgba(31,31,31,0.9);"><i
                                class="fas fa-question-circle" style="color: rgb(0,0,0,0.9);"></i><span
                                style="font-size: 14px;">Tickets</span></a></li>
                <li
                        class="nav-item" role="presentation"></li>
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
                <h1 class="display-4 text-dark mb-4" style="font-size: 28px;">Tickets</h1>
                <div class="card border rounded-0 shadow">
                    <div class="card-header py-3" style="background-color: rgb(246,248,254);">
                        <p class="m-0 font-weight-bold" style="font-size: 12px;">
                            <input class="btn btn-primary" id="modify-user" type="hidden" data-toggle="modal"
                                   data-target="#user_modal">
                            <button class="btn btn-outline-dark border rounded-0" data-toggle="tooltip"
                                    data-bs-tooltip="" id="addTicket_tkt_btn_admin_pg" type="button"
                                    title="add new ticket" style="font-size: 12px; visibility: hidden"><i
                                        class="fas fa-plus" id="add_tkt_btn_admin_pg" style="font-size: 12px;"></i>
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
                                            <option value="ticket_id" selected="">Ticket ID</option>
                                            <option value="title">Topic</option>
                                            <option value="create_time">Submitted Date</option>
                                            <option value="name">Customer Name</option>
                                        </select>&nbsp;
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right dataTables_filter" id="dataTable_filter"><label>
                                        <input class="border rounded-0 form-control form-control-sm" type="search"
                                               id="search-field" aria-controls="dataTable" placeholder="Search Topic"
                                               style="background-color: rgb(246,248,254);"></label>
                                    <button
                                            class="btn btn-outline-dark border rounded-0" data-toggle="tooltip"
                                            data-bs-tooltip="" id="search" type="button" style="font-size: 12px;"
                                            title="Search"><i class="fa fa-search" data-bs-hover-animate="pulse"
                                                              id="serach_tkt_btn_admin_pg" style="font-size: 12px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive text-center table mt-2" id="dataTable" role="grid"
                             aria-describedby="dataTable_info">
                            <table class="table dataTable my-0" id="dataTable">
                                <thead>
                                <tr style="font-size: 14px;" class="text-center">
                                    <th>Ticket ID</th>
                                    <th style="font-size: 14px;">Topic</th>
                                    <th style="font-size: 14px;">Customer Name</th>
                                    <th style="font-size: 14px;">Submitted Date</th>
                                    <th style="font-size: 14px;">Status</th>
                                    <th style="font-size: 14px;">Options</th>
                                </tr>
                                </thead>
                                <tbody id="project-list" class="text-center">
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td><br></td>
                                    <td></td>
                                    <td><strong></strong></td>
                                    <td><br></td>
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
                <div class="modal fade border rounded" role="dialog" tabindex="-1" id="user_modal"
                     style="padding: 30px;margin: 0px;width: 100%;height: 100%;">
                    <div class="modal-dialog" role="document" style=" max-width: 650px">
                        <div class="modal-content">
                            <div class="modal-header" style="width: 648px;height: 75px;">
                                <h1 class="display-4 modal-title" style="font-size: 33px;">Ticket</h1>
                                <button type="button" class="close" id="close-contact-form" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body" id="popup_momorizeCheck"
                                 style="width: 648px;background-color: #f6f5fb;">

                                <form>
                                    <input type="hidden" id="staticTicketID">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group row">
                                                <label for="staticID"
                                                       class="col-sm-3 col-form-label"><strong>Title</strong></label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                           id="staticTitle"
                                                           value="TITLE">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group row">
                                                <label for="staticCreate"
                                                       class="col-sm-3 col-form-label text-nowrap"><strong>Created
                                                        Time</strong></label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                           id="staticCreate"
                                                           value="2020-02-22 20:20:20">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group row">
                                                <label for="staticUpdate"
                                                       class="col-sm-3 col-form-label text-nowrap"><strong>Last
                                                        Update</strong></label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                           id="staticUpdate"
                                                           value="2020-02-22 20:20:21">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group row">
                                                <label for="staticID"
                                                       class="col-sm-4 col-form-label text-nowrap"><strong>User
                                                        ID</strong></label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                           id="staticID"
                                                           value="123">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group row">
                                                <label for="staticID"
                                                       class="col-sm-3 col-form-label"><strong>Email</strong></label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                           id="staticEmail"
                                                           value="TEST@BROCKU.CA">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group row">
                                                <label for="staticName"
                                                       class="col-sm-4 col-form-label"><strong>Name</strong></label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control-plaintext"
                                                           id="staticName"
                                                           value="NAME">
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="staticUserMsg"
                                               class="col-sm-2 col-form-label"><strong>Message</strong></label>
                                        <div class="col-sm-10">
                            <textarea type="text" readonly class="form-control-plaintext" id="staticUserMsg"
                                      style="height: 200px; border: 1px solid; border-radius: 5px">MESSAGE</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputReplyMsg"
                                               class="col-sm-2 col-form-label"><strong>Reply</strong></label>
                                        <div class="col-sm-10">
                            <textarea type="text" class="form-control-plaintext" id="inputReplyMsg"
                                      style="height: 200px; border: 1px solid; border-radius: 5px; background-color: white">REPLY MESSAGE</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"><strong>Solve</strong></label>
                                        <div class="col-sm-10" style="padding-top: 8px;">
                                            <label class="switch">
                                                <input id="solve-switch" type='checkbox'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer" style="width: 648px;">
                                <button class="btn btn-primary btn-block border rounded" id="popup_save_btn"
                                        type="submit"
                                        style="height: 45px;">Save
                                </button>
                            </div>

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
<script>
    var ticket_list_page = 1;
    var total_page = 1;
    var sort = "ticket_id";
    var keyword = "";
    $(this).on("load", function () {
        loadList();
    });

    function getPage(event) {
        $(".pagination li").removeClass("active");
        $(event.target.parentElement).addClass("active");
        ticket_list_page = parseInt($(event.target).attr("page"));
        loadList();
    }

    function prePage(event) {
        if (ticket_list_page > 1) {
            var current = $(".pagination .active");
            $(current.get(0).previousElementSibling).addClass("active");
            current.removeClass("active");
            ticket_list_page--;
            loadList();
        }
    }

    function nextPage(event) {
        if (ticket_list_page < total_page) {
            var current = $(".pagination .active");
            $(current.get(0).nextElementSibling).addClass("active");
            current.removeClass("active");
            ticket_list_page++;
            loadList();
        }
    }

    //Load ticket list
    function loadList() {
        $.ajax({
            url: "../lib/ticket.php/",
            type: "GET",
            cache: false,
            data: {
                type: "list",
                page: ticket_list_page,
                sort: sort,
                search: keyword,
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                if (dataResult.status) {
                    $("#project-list").empty();
                    $("#project-list").append(html);
                    total_page = dataResult.page;
                    if (ticket_list_page > total_page)
                        ticket_list_page = total_page;
                    if (ticket_list_page <= 0)
                        ticket_list_page = 1;

                    for (var i = 0; i < dataResult.project.length; i++) {
                        var status = dataResult.project[i].is_solve == "t" ? "Solved" : "NEW";
                        var html = "<tr>" +
                            "<td>" + dataResult.project[i].ticket_id + "</td>" +
                            "<td>" + dataResult.project[i].title + "</td>" +
                            "<td>" + dataResult.project[i].name + "</td>" +
                            "<td>" + dataResult.project[i].create_time + "</td>" +
                            "<td>" + status + "</td>" +
                            "<td>" +
                            "<div class=\"btn-group\" role=\"group\" style=\"font-size: 12px;\">" +
                            "<button class=\"btn\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" data-bs-hover-animate=\"pulse\" id=\"reply_tkt_btn_admin_pg\" onclick='reply(" + dataResult.project[i].ticket_id + ")' type=\"button\" style=\"font-size: 12px;\" title=\"Reply\">" +
                            "<i class=\"fas fa-reply\" onclick='reply(" + dataResult.project[i].ticket_id + ")'></i></button>\n" +
                            "<button class=\"btn\" data-bs-hover-animate=\"pulse\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" title=\"Delete\" id=\"delete_tkt_btn_admin_pg\" onclick='deleteTicket(event)' ticket-id='" + dataResult.project[i].ticket_id + "' type=\"button\" style=\"font-size: 12px;\">" +
                            "<i class=\"fa fa-remove\" onclick='deleteTicket(event)' ticket-id='" + dataResult.project[i].ticket_id + "'></i></button>\n" +
                            "</div>" +
                            "</td>" +
                            "</tr>";
                        $("#project-list").append(html);
                    }
                    $('[data-toggle="tooltip"]').tooltip();
                    pagination(total_page);
                } else
                    swal("Failed!", "ERR_CODE: " + dataResult.code + "\n" + dataResult.msg, "error");

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
        $(".pagination :nth-child(" + (ticket_list_page + 1) + ")").addClass("active");
    }

    $("#sort").on("change", function (event) {
        ticket_list_page = 1;
        sort = $("#sort").val();
        loadList();
    });

    $("#search").on("click", function () {
        ticket_list_page = 1;
        keyword = $("#search-field").val();
        loadList();
    });

    function reply(id) {
        $("#staticTicketID").val(id);
        $("#staticTitle").val("");
        $("#staticEmail").val("");
        $("#staticID").val("");
        $("#staticName").val("");
        $("#staticUserMsg").val("");
        $("#inputReplyMsg").val("");
        $("#staticCreate").val("");
        $("#staticUpdate").val("");
        $("#solve-switch").prop("checked", false);

        $.ajax({
            url: "../lib/ticket.php/",
            type: "GET",
            cache: false,
            data: {
                type: "retrieve",
                id: id,
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                if (dataResult.status) {
                    $("#staticTitle").val(dataResult.data.title.trim());
                    $("#staticEmail").val(dataResult.data.email.trim());
                    $("#staticID").val(dataResult.data.user_id == null ? "Anonymous" : dataResult.data.user_id);
                    $("#staticName").val(dataResult.data.name.trim());
                    $("#staticUserMsg").val(dataResult.data.msg.trim());
                    $("#staticCreate").val(dataResult.data.create_time.trim());
                    $("#staticUpdate").val(dataResult.data.update_time == null ? "NEW" : dataResult.data.update_time.trim());
                    $("#inputReplyMsg").val(dataResult.data.reply == null ? "" : dataResult.data.reply.trim());
                    $("#solve-switch").prop("checked", dataResult.data.is_solve === "t");
                    $("#modify-user").click();
                } else {
                    swal("Failed!", "Error Code: " + dataResult.code + "\nDescription: " + dataResult.msg, "error");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    }


    $("#popup_save_btn").on("click", function () {
        console.log($("#inputReplyMsg").text());
        $.ajax({
            url: "../lib/ticket.php/",
            type: "POST",
            cache: false,
            data: {
                type: "update",
                id: $("#staticTicketID").val(),
                reply: $("#inputReplyMsg").val(),
                solve: $("#solve-switch").prop("checked"),
                email: $("#staticEmail").val(),
            },
            success: function (data) {
                var dataResult = JSON.parse(data);
                if (dataResult.status === true) {
                    swal("Success", "Ticket has been updated", "success");
                    $("#close-contact-form").click();
                    loadList();
                } else {
                    swal("Update Failed!", "Error Code: " + dataResult.code + "\nDescription: " + dataResult.msg, "error");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });

    });

    function deleteTicket(event) {
        var ticketId = $(event.target).attr("ticket-id");

        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this project!",
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
                        url: "../lib/ticket.php",
                        async: true,
                        timeout: 5000,
                        data: {
                            type: "delete",
                            id: ticketId,
                        },
                        success: function (data) {
                            var data = JSON.parse(data);
                            if (data.status == true) {
                                setTimeout(function () {
                                    swal("Deleted!", "Ticket has been deleted!", "success");
                                    loadList();
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

</script>
</body>

</html>