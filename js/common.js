// Generate a new captcha
$("#captcha_change").on("click", function () {
    $('#captcha_img').attr('src', './lib/captcha.php?r=' + Math.random());
});

// Login button in homepage and editor page
$("#popup_loginBTN").on("click", function (event) {
    $("#username-error").text("");
    $("#password-error").text("");
    var username = $("#popup_username").val().trim();
    var password = $("#popup_password").val().trim();
    if (username == "") {
        $("#username-error").text("Please enter username!");
    } else if (password == "") {
        $("#password-error").text("Please enter password!");
    } else {
        $.ajax({
            type: "POST",
            url: "./lib/post-login.php",
            async: true,
            timeout: 5000,
            data: {
                username: username,
                password: password,
            },
            success: function (data) {

                var data = JSON.parse(data);
                console.log(data);
                if (data.status) {
                    $("#close-login-form").click();
                    $("#login-btn-group").css("display", "none");
                    $("#user-btn-group").css("display", "");
                    $("#username-text").text(data.name);
                    var icon = data.icon == "" ? "img/empty-avatar.png" : data.icon;
                    $("#user-avatar").attr("src", icon);
                    $("#popup_username").val("");
                    $("#popup_password").val("");
                    if (data.is_admin) {
                        $("#manage-btn").css("display", "");
                    } else
                        $("#manage-btn").css("display", "none");

                    console.log(event.originalEvent.view.location.pathname);
                    if (event.originalEvent.view.location.pathname.includes("/editor.php")) {
                        console.log(data.project);
                        for (var i = 0; i < data.project.length; i++) {
                            var array = data.project[i];
                            var isChecked = array.is_live == "t" ? "checked" : "";
                            var isCheckedText = array.is_live == "t" ? "" : "none";
                            // var html = "<li>" +
                            //     " <a id = 'product-id-" + array.product_id + "'  href='' class='product-list' onclick='loadPage(event)' productId='" + array.product_id + "'>" + array.product_name + "</a>" +
                            //     "<input class='product-list-is-live' onChange='changeLiveStatus(event)' productId='" + array.product_id + "' type='checkbox' " + isChecked + ">" +
                            //     "<button class='product-list-share product-list-btn' onclick='shareURL(" + array.product_id + ")'><i class=\"fa fa-link\"></i></button>" +
                            //     "<button class='product-list-delete product-list-btn' onclick='deleteProduct(event)' productId='" + array.product_id + "'><i class=\"fa fa-trash\" productId='" + array.product_id + "'></i></button>" +
                            //     "<button class='product-list-change-name product-list-btn' onclick='initChangeName(event)' data-toggle=\"modal\" data-target=\"#change_name_modal\"><i class=\"fa fa-pencil\" product-name='" + array.product_name + "' product-id='" + array.product_id + "'></i></button>" +
                            //     "</li>";
                            var html = "<li new='true' style=\"padding: 5px 10px;margin: 5px 10px; border-style: solid; border-width: 1px; border-radius: 5px\">\n" +
                                "                    <img src =\"img/file.svg\" alt=\"page\" width=\"19px\" style=\"padding-bottom: 2px\">\n" +
                                "                    <a id='product-id-" + array.product_id + "'  class='product-list product-list-name' onclick='loadPage(event)' productId='" + array.product_id + "'>" + array.product_name + "</a>\n" +
                                "                    <div class=\"product-option\" style=\"float: right\">\n" +
                                "                        <label class=\"switch\" style=\"margin-top: 2px;\" title='Make page live, save this page first'>\n" +
                                "                            <input class='product-list-is-live product-list-name' onChange='changeLiveStatus(event)' productId='" + array.product_id + "' type='checkbox' " + isChecked + ">\n" +
                                "                            <span class=\"slider round\"><img src='img/LIVE.svg' class='live-text' style='display: " + isCheckedText + "'></span>\n" +
                                "                        </label>\n" +
                                "                        <a href=\"#\" class=\"\" data-toggle=\"dropdown\" style=\"margin: 4px\"><button class=\"product-list-btn\" style=\"width: 20px\"><strong>&#8942;</strong></button></a>\n" +
                                "                        <div class=\"dropdown-menu\">\n" +
                                "                            <a role=\"presentation\" class='dropdown-item product-list-share product-list-btn' onclick='shareURL(" + array.product_id + ")'>\n" +
                                "                                <i class=\"fa fa-link\"></i>\n" +
                                "                                 Share URL\n" +
                                "                            </a>\n" +
                                "                            <a role=\"presentation\" class='dropdown-item product-list-change-name product-list-btn' onclick='initChangeName(event)' product-name='" + array.product_name + "' product-id='" + array.product_id + "' data-toggle=\"modal\" data-target =\"#change_name_modal\">\n" +
                                "                                <i class=\"fa fa-pencil\"></i>\n" +
                                "                                 Rename\n" +
                                "                            </a>\n" +
                                "                            <a role=\"presentation\" class='dropdown-item product-list-delete product-list-btn' onclick='deleteProduct(event)' productId='" + array.product_id + "'>\n" +
                                "                                <i class=\"fa fa-trash\" style=\"color: red\" productId=''></i>\n" +
                                "                                 Delete\n" +
                                "                            </a>\n" +
                                "                        </div>\n" +
                                "                </li>";
                            $("#product-list").append(html);
                        }
                    }
                } else {
                    if (data.code == 300 || data.code == 301 || data.code == 303) {
                        $("#username-error").text(data.msg);
                    }
                    if (data.code == 302) {
                        $("#password-error").text(data.msg);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    }
});

// Logout button for homepage and editor page
$("#logout-btn").on("click", function () {
    $.ajax({
        type: "GET",
        url: "lib/post-logout.php",
        async: true,
        timeout: 5000,
        success: function (data) {
            console.log(data);
            var data = JSON.parse(data);
            if (data.status == true) {
                $("#login-btn-group").css("display", "flex");
                $("#user-btn-group").css("display", "none");
            } else {

            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
        }
    });
});

/**
 * User-nav-bar btn click
 */
$("#profile-btn").on("click", function () {
    window.open("./user/user_profile.php");
});

$("#project-btn").on("click", function () {
    window.open("./user/user_project.php");
});

$("#manage-btn").on("click", function () {
    window.open("./web_manage/");
});

