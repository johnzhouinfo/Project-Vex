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
    <title>Table - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="../lib/css/Toggle-Switch.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="../lib/css/sweetalert.css">
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
                        class="nav-item" role="presentation"><a class="nav-link active" href="admin-project-mngt.php"
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
                        <li class="nav-item dropdown d-sm-none no-arrow">
                            <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                                <i class="fas fa-search"></i>
                            </a>
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
                <h1 class="display-4 text-dark mb-4" style="font-size: 28px;">Pages</h1>
                <div class="card border rounded-0 shadow">
                    <div class="card-header py-3" style="background-color: rgb(246,248,254);">
                        <input class="btn btn-primary" id="change-name" type="hidden" data-toggle="modal"
                               data-target="#change_name_modal">
                        <p class="m-0 font-weight-bold">
                            <button class="btn btn-outline-dark border rounded-0 invisible" data-toggle="tooltip"
                                    data-bs-tooltip="" id="addpg_btn_usr_pg" type="button" title="add new page"
                                    style="font-size: 12px;"><i class="fas fa-plus" style="font-size: 12px;"></i>
                            </button>
                            <br></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-nowrap">
                                <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label
                                            style="font-size: 14px;">Sorted by&nbsp;<select
                                                class="border rounded-0 form-control form-control-sm custom-select custom-select-sm"
                                                id="sort" style="background-color: rgb(246,248,254);">
                                            <option value="product_id" selected="">Project ID</option>
                                            <option value="product_name">Project Name</option>
                                        </select>&nbsp;</label></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right d-flex float-right dataTables_filter" id="dataTable_filter">
                                    <input class="border rounded-0" type="search" id="search-field"
                                           style="background-color: rgb(246,248,254);font-size: 14px;padding: 1px 10px;"
                                           placeholder="Search pages">
                                    <button class="btn btn-outline-dark border rounded-0"
                                            type="button" style="font-size: 12px;" id="search"><i
                                                class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTable" role="grid"
                             aria-describedby="dataTable_info">
                            <table class="table dataTable my-0" id="dataTable">
                                <thead>
                                <tr style="font-size: 15px; width: 100%" class="text-center">
                                    <th style="width: 16.66%">Project ID</th>
                                    <th style="width: 16.66%">Project Name</th>
                                    <th style="width: 16.66%">Username</th>
                                    <th style="width: 20%">Created Time</th>
                                    <th style="width: 16.66%">Visibility</th>
                                    <th style="width: 16.66%">Options</th>
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
    </div>
</div>
<div class="modal fade border rounded" role="dialog" tabindex="-1" id="change_name_modal"
     style="padding: 100px;margin: 0px;width: 100%;height: 100%;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 498px;height: 75px;">
                <h1 class="display-4 modal-title" style="font-size: 33px;">Change Project Name</h1>
                <button type="button" class="close" id="close-save-name-form" data-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="popup_momorizeCheck"
                 style="height: 105px;width: 498px;background-color: #f6f5fb;">
                <label style="color: rgb(114,120,126);font-size: 14px;">New Name</label> <span class="help-block"
                                                                                               id="name-error"
                                                                                               style="float: right"></span>
                <form>
                    <div class="form-group" style="padding-bottom: 16px; margin-bottom: 0">
                        <input class="border rounded border-light form-control" type="text" id="popup_change_name"
                               style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);" required=""
                               name="projectname" placeholder="Name">
                        <input type="hidden" id="change-name-product-id" value="">
                    </div>
                </form>

            </div>
            <div class="modal-footer" style="width: 498px;">
                <button class="btn btn-primary btn-block border rounded" id="popup_save_name_BTN" type="submit"
                        style="height: 45px;">Save
                </button>
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
    var project_list_page = 1;
    var total_page = 1;
    var sort = "product_id";
    var keyword = "";
    $(this).on("load", function () {
        loadList();
        $("form input").keypress(
            function (event) {
                if (event.which == '13') {
                    event.preventDefault();
                }
            });
    });

    function getPage(event) {
        $(".pagination li").removeClass("active");
        $(event.target.parentElement).addClass("active");
        project_list_page = parseInt($(event.target).attr("page"));
        loadList();
    }

    function prePage(event) {
        if (project_list_page > 1) {
            var current = $(".pagination .active");
            $(current.get(0).previousElementSibling).addClass("active");
            current.removeClass("active");
            project_list_page--;
            loadList();
        }
    }

    function nextPage(event) {
        if (project_list_page < total_page) {

            var current = $(".pagination .active");
            console.log(current);
            $(current.get(0).nextElementSibling).addClass("active");
            current.removeClass("active");
            project_list_page++;
            loadList();

        }
    }

    function loadList() {
        $.ajax({
            url: "../lib/project.php/",
            type: "GET",
            cache: false,
            data: {
                type: "admin",
                page: project_list_page,
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
                    //make sure the page are in the range
                    if (project_list_page > total_page)
                        project_list_page = total_page;
                    if (project_list_page <= 0)
                        project_list_page = 1;

                    for (var i = 0; i < dataResult.project.length; i++) {
                        var isChecked = dataResult.project[i].is_live == "t" ? "checked" : "";
                        var html = "<tr>" +
                            "<td style=\"padding: 17px;\">" + dataResult.project[i].product_id + "</td>" +
                            "<td style=\"padding: 17px;\"><a href='#' onclick=\"window.open('../editor.php?id=" + dataResult.project[i].product_id + "')\">" + dataResult.project[i].product_name + "</a></td>" +
                            "<td style=\"padding: 17px;\">" + dataResult.project[i].username + "</td>" +
                            "<td style=\"padding: 17px;\">" + dataResult.project[i].create_time + "</td>" +
                            "<td style=\"padding: 17px;\"><label class=\"switch\" style=\"margin-top: 5px;\">\n" +
                            " <input class='product-list-is-live product-list-name' onChange='changeLiveStatus(event)' productId='" + dataResult.project[i].product_id + "' type='checkbox' " + isChecked + ">\n" +
                            " <span class=\"slider round\"></span></label>\n" +
                            "</td >" +
                            "<td style=\"padding: 17px;\"><div class='btn-group' role='group' style='font-size: 12px;'>" +
                            "<button class=\"btn\" data-toggle=\"tooltip\" data-bs-tooltip=\"\" data-bs-hover-animate=\"pulse\" onclick='changePageName(event)' product-id='" + dataResult.project[i].product_id + "' product-name='" + dataResult.project[i].product_name.trim() + "' type=\"button\" style=\"font-size: 12px;\" title=\"Rename\"><i class=\"fas fa-edit\" product-id='" + dataResult.project[i].product_id + "' product-name='" + dataResult.project[i].product_name.trim() + "' ></i></button>" +
                            "<button class='btn' data-bs-hover-animate='pulse' id='delete_pg_btn_usr_pg' type='button' onclick='deleteProduct(event)' product-id='" + dataResult.project[i].product_id + "' style='font-size: 12px;'><i class='fa fa-remove' data-toggle='tooltip' data-bs-tooltip='' product-id='" + dataResult.project[i].product_id + "'  title='Delete'></i></button></div></td>" +
                            "</tr>";
                        $("#project-list").append(html);
                    }
                    pagination(total_page);
                } else
                    alert(dataResult.msg);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        })
    }

    $("#sort").on("change", function (event) {
        project_list_page = 1;
        sort = $("#sort").val();
        loadList();
    });

    $("#search").on("click", function () {
        project_list_page = 1;
        keyword = $("#search-field").val();
        loadList();
    });

    function pagination(pages) {
        $(".pagination").empty();

        var html = "<li class=\"page-item pre-btn\" onclick=\"prePage(event)\"><a class=\"page-link\" href=\"#\" aria-label=\"Previous\"><i class=\"fa fa-caret-left\"></i></a></li>" +
            "<li class=\"page-item\" onclick=\"getPage(event)\"><a class=\"page-link\" href=\"#\" page=\"1\">1</a></li>";
        for (var i = 2; i <= pages; i++) {
            html += "<li class=\"page-item\" onclick=\"getPage(event)\"><a class=\"page-link\" href=\"#\" page=\"" + i + "\">" + i + "</a></li>";
        }
        html += "<li class=\"page-item next-btn\" onclick=\"nextPage(event)\"><a class=\"page-link\" href=\"#\" aria-label=\"Next\"><i class=\"fa fa-caret-right\"></i></a></li>";
        $(".pagination").append(html);
        $(".pagination :nth-child(" + (project_list_page + 1) + ")").addClass("active");
    }

    function deleteProduct(event) {
        event.stopPropagation();
        var productId = $(event.target).attr("product-id");

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
                        url: "../lib/project.php",
                        async: true,
                        timeout: 5000,
                        data: {
                            type: "delete",
                            id: productId,
                        },
                        success: function (data) {
                            var data = JSON.parse(data);
                            if (data.status == true) {
                                setTimeout(function () {
                                    swal("Deleted!", "Your page has been deleted!", "success");
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

    function changePageName(event) {
        event.stopPropagation();
        var id = $(event.target).attr("product-id");
        var name = $(event.target).attr("product-name");
        $("#popup_change_name").val(name);
        $("#change-name-product-id").val(id);
        $("#change-name").click();

    }

    $("#popup_save_name_BTN").on("click", function () {
        var name = $("#popup_change_name").val();
        var id = $("#change-name-product-id").val();
        $.ajax({
            type: "POST",
            url: "../lib/project.php",
            async: true,
            timeout: 5000,
            data: {
                type: "rename",
                id: id,
                name: $("#popup_change_name").val(),
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == true) {
                    loadList();
                    $("#close-save-name-form").click();
                    swal("Success!", "Project name has been changed!", "success");
                } else {
                    swal("Failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    });

    /**
     * This method will send Ajax request to PHP server
     * Update the page's live status
     * @param event
     */
    function changeLiveStatus(event) {
        var productId = $(event.target).attr("productId");
        var checked = $(event.target).is(":checked");
        $.ajax({
            type: "POST",
            url: "../lib/project.php",
            async: true,
            timeout: 5000,
            data: {
                type: "live",
                id: productId,
                value: checked
            },
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == true) {
                    var status = data.page_status === "true" ? "LIVE" : "OFFLINE";
                    $($($(event.target).get(0).nextElementSibling).find(".live-text"))
                        .css("display", checked ? "" : "none");
                    swal("Success!", "Your page now " + status, "success");
                } else {
                    swal("Update page failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");
                    $(event.target).attr("checked", !checked);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    }

</script>
</body>

</html>