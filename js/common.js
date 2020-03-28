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
            data: {
                username: username,
                password: password,
            },
            success: function (data) {

                var data = JSON.parse(data);
                console.log(data);
                if (data.status == true) {
                    $("#close-login-form").click();
                    $("#login-btn-group").css("display", "none");
                    $("#user-btn-group").css("display", "");
                    $("#username-text").text(data.name);
                    var icon = data.icon == "" ? "img/empty-avatar.png" : data.icon;
                    $("#user-avatar").attr("src", icon);
                    $("#popup_username").val("");
                    $("#popup_password").val("");
                    console.log(event.originalEvent.view.location.pathname);
                    if (event.originalEvent.view.location.pathname.includes("/editor.php")) {
                        console.log(data.project);
                        for (var i = 0; i < data.project.length; i++) {
                            var array = data.project[i];
                            var isChecked = array.is_live == "t" ? "checked" : "";
                            var html = "<li>" +
                                " <a id = 'product-id-" + array.product_id + "'  href='' class='product-list' onclick='loadPage(event)' productId='" + array.product_id + "'>" + array.product_name + "</a>" +
                                "<input class='product-list-is-live' onChange='changeLiveStatus(event)' productId='" + array.product_id + "' type='checkbox' " + isChecked + ">" +
                                "<button class='product-list-share product-list-btn' onclick='shareURL(" + array.product_id + ")'><i class=\"fa fa-link\"></i></button>" +
                                "<button class='product-list-delete product-list-btn' onclick='deleteProduct(event)' productId='" + array.product_id + "'><i class=\"fa fa-trash\" productId='" + array.product_id + "'></i></button>" +
                                "<button class='product-list-change-name product-list-btn' onclick='initChangeName(event)' data-toggle=\"modal\" data-target=\"#change_name_modal\"><i class=\"fa fa-pencil\" product-name='" + array.product_name + "' product-id='" + array.product_id + "'></i></button>" +
                                "</li>";
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
            }
        });
    }
});

// Logout button for homepage and editor page
$("#logout-btn").on("click", function () {
    $.ajax({
        type: "GET",
        url: "lib/post-logout.php",
        success: function (data) {
            console.log(data);
            var data = JSON.parse(data);
            if (data.status == true) {
                $("#login-btn-group").css("display", "flex");
                $("#user-btn-group").css("display", "none");
            } else {

            }
        }
    });
})