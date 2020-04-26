<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $id = $_SESSION["id"];
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
    <title>Profile</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="../css/common.css">
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
               href="../index.php"
               style="color: rgb(0,0,0,0.9);opacity: 1;padding: 24px 0px;margin: 0px;">
                <h1 class="display-4 text-capitalize" style="font-size: 20px;"><img
                            style="width: 23px;height: 23px;padding: 0px;" src="assets/img/Vex_Three.gif">&nbsp;Vex</h1>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item" role="presentation"><a class="nav-link active" href="user_profile.php"
                                                            style="color: rgb(31,31,31);"><i class="fas fa-user"
                                                                                             style="font-size: 14px;color: rgb(31,31,31);"></i><span
                                style="font-size: 14px;">Profile</span></a><a class="nav-link" href="user_project.php"
                                                                              style="color: rgb(0,0,0,0.9);font-family: -apple-system, BlinkMacSystemFont,&quot;SegoeUI &quot;,Roboto&quot;;font-size: 14px;"><i
                                class="fas fa-pager" style="color: rgb(0,0,0,0.9);"></i><span
                                style="font-size: 14px;color: rgba(31,31,31,0.9);">Pages</span></a></li>
                <li
                        class="nav-item" role="presentation"></li>
                <li class="nav-item" role="presentation"></li>
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
                                <div
                                    class="dropdown-menu border rounded-0 shadow-sm dropdown-menu-right animated--grow-in"
                                    role="menu" style="color: rgb(62,63,69);">
                                    <a id="manage-btn" role="presentation" class="dropdown-item" href="../web_manage/"
                                       style="font-size: 14px;color: rgb(133,135,150); display: <?php
                                       if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true)
                                           echo "";
                                       else
                                           echo "none";
                                       ?>">
                                        <i class="fa fa-wrench fa-sm fa-fw mr-2 text-gray-400"></i>
                                         Web Manage
                                    </a>
                                    <a class="dropdown-item" role="presentation" href="user_profile.php"
                                       style="font-size: 14px;color: rgb(133,135,150);">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"
                                           style="color: rgb(44,44,47);"></i>
                                        &nbsp;Profile</a>
                                    <a class="dropdown-item" role="presentation" href="user_project.php"
                                       style="font-size: 14px;color: rgb(133,135,150);">
                                        <i class="fa fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
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
                <h1 class="display-4 text-dark mb-4" style="font-size: 28px;">Profile</h1>
                <div class="col-lg-4" style="max-width: 100%;padding: 0px;">
                    <div class="card mb-3">
                        <div class="card-body text-center border rounded-0 shadow" style="width: 100%;"><img
                                    class="rounded-circle mb-3 mt-4" id="profile_avatar" src="assets/img/Vex_Three.gif"
                                    width="160" height="160" style="height: 60px;width: 59px;">
                            <p id="usrID_display_usr_pg" style="font-size: 11px;">User ID: 0</p>
                            <p id="usrName_display_profile_usr_pg" style="font-size: 11px;">Username: USER</p>
                            <p id="name_display_profile_usr_pg" style="font-size: 11px;">Name: USER</p>
                            <p id="email_display_profile_usr_pg" style="font-size: 11px;">Email: USER@brocku.ca</p>
                            <div class="mb-3">
                                <button class="btn btn-outline-primary btn-sm border rounded-0"
                                        id="chgPht_btn_profile_usr_pg" type="button" style="font-size: 12px;">Change
                                    Photo
                                </button>
                                <input type="file" accept="image/*" style="display: none" id="changeBtn">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3" style="min-width: auto;">
                    <div class="col-lg-8" style="max-width: 50%;">
                        <div class="row">
                            <div class="col">
                                <div class="card border rounded-0 shadow mb-3" style="min-width: 333px;">
                                    <div class="card-header py-3" style="background-color: rgb(246,248,254);">
                                        <p class="m-0 font-weight-bold">Change Information</p>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="first_name"
                                                                                   style="font-size: 14px;"><strong>Name*</strong></label><span
                                                                class="help-block" id="profile-name-err"></span>
                                                        <input class="border rounded-0 form-control" type="text"
                                                               id="fname_inpt_profile_usr_pg" placeholder="First Name"
                                                               name="first_name"
                                                               style="font-size: 12px;background-color: rgb(246,248,254);">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="email" style="font-size: 14px;"><strong>Email
                                                                Address*</strong></label><span class="help-block"
                                                                                               id="profile-email-err"></span>
                                                        <input class="border rounded-0 form-control" type="email"
                                                               id="email_inpt_profile_usr_pg" placeholder="Email"
                                                               name="email"
                                                               style="font-size: 12px;background-color: rgb(246,248,254);">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-outline-primary btn-sm border rounded-0"
                                                        id="chgInfo_btn_profilelname_usr_pg"
                                                        onclick="updateProfile(event)" type="submit"
                                                        style="font-size: 12px;">Change Info
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8" style="max-width: 50%;">
                        <div class="row">
                            <div class="col">
                                <div class="card border rounded-0 shadow mb-3" style="min-width: 333px;">
                                    <div class="card-header py-3" style="background-color: rgb(246,248,254);">
                                        <p class="m-0 font-weight-bold">Change Password</p>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="username"
                                                                                   style="font-size: 14px;"><strong>Current
                                                                Password*</strong></label>
                                                        <span class="help-block" id="old-password-err"></span>
                                                        <input class="border rounded-0 form-control" type="password"
                                                               id="old-password"
                                                               style="background-color: rgb(246,248,254);font-size: 12px;"
                                                               required="" name="oldpw" placeholder="Current Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="first_name"
                                                                                   style="font-size: 14px;"><strong>New
                                                                Password*</strong><br></label>
                                                        <span class="help-block" id="new-password-err"></span>
                                                        <input class="border rounded-0 form-control" type="password"
                                                               id="new-password"
                                                               style="background-color: rgb(246,248,254);font-size: 12px;"
                                                               name="newpw" placeholder="New Password"></div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="last_name"
                                                                                   style="font-size: 14px;"><strong>Comfirm*</strong></label>
                                                        <span class="help-block" id="confirm-password-err"></span>
                                                        <input class="border rounded-0 form-control" type="password"
                                                               id="confirm-password"
                                                               style="background-color: rgb(246,248,254);font-size: 12px;"
                                                               name="Confirm" placeholder="Confirm"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-outline-primary btn-sm border rounded-0"
                                                        id="rstPW_btn_profilelname_usr_pg"
                                                        onclick="updatePassword(event)" type="submit"
                                                        style="font-size: 12px;">Change Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
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
        $.ajax({
            url: "../lib/account.php/",
            type: "GET",
            cache: false,
            data: {
                type: "user",
                id: <?php echo $id ?>,
            },
            success: function (data) {
                console.log(data);
                var dataResult = JSON.parse(data);
                if (dataResult.status) {
                    console.log(dataResult);

                    $("#usrID_display_usr_pg").text("User ID: " + dataResult.user_id.trim());
                    $("#usrName_display_profile_usr_pg").text("Username: " + dataResult.username.trim());
                    $("#name_display_profile_usr_pg").text("Name: " + dataResult.name.trim());
                    $("#email_display_profile_usr_pg").text("Email: " + dataResult.email.trim());
                    $("#profile-email").val(dataResult.email.trim());
                    $("#fname_inpt_profile_usr_pg").val(dataResult.name.trim());
                    $("#email_inpt_profile_usr_pg").val(dataResult.email.trim());
                    var icon_url = dataResult.icon == null ? "../img/empty-avatar.png" : dataResult.icon.trim();
                    $("#profile_avatar").attr("src", icon_url);
                } else
                    swal("Failed!", "ERR_CODE: " + data.code + "\n" + data.msg, "error");

            }
        })
    });

    //Update the user profile by sending the post request
    function updateProfile(event) {
        event.preventDefault();
        $("#profile-name-err").text("");
        $("#profile-email-err").text("");
        var email = $('#email_inpt_profile_usr_pg').val();
        var name = $('#fname_inpt_profile_usr_pg').val();
        var pattern = new RegExp(/^[A-Za-z0-9]+$/);
        if (validateEmail(email) && name.trim() !== "" && pattern.test(name.trim())) {
            $.ajax({
                url: "../lib/account.php",
                type: "POST",
                cache: false,
                async: true,
                timeout: 5000,
                data: {
                    type: "updateProfile",
                    name: name,
                    email: email,
                },
                success: function (dataResult) {
                    console.log(dataResult);
                    var dataResult = JSON.parse(dataResult);
                    if (dataResult.status) {
                        $("#name_display_profile_usr_pg").text("Name: " + name);
                        $("#email_display_profile_usr_pg").text("Email: " + email);
                        $("#nav-name").text("Hi, " + name);
                        swal("Success!", "Your profile has been updated!", "success");
                    } else {
                        swal("Failed!", "Error Code: " + dataResult.code + "\nDescription: " + dataResult.msg, "error");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
                }
            });
        } else {
            if (!validateEmail(email)) {
                $("#profile-email-err").text("Incorrect email format!");
            }
            if (name.trim() === "") {
                $("#profile-name-err").text("Name can't be empty");
            } else {
                $("#profile-name-err").text("Name cannot contains special character.");
            }
        }
    }

    //validate the inputed email
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    //Update user password
    function updatePassword(event) {
        event.preventDefault();
        $("#old-password-err").text("");
        $("#new-password-err").text("");
        $("#confirm-password-err").text("");
        var oldPassword = $("#old-password").val();
        var newPassword = $("#new-password").val();
        var confirmPassword = $("#confirm-password").val();

        if (oldPassword.trim() == "") {
            $("#old-password-err").text("Please enter your current password.");
            return;
        } else if (newPassword.length < 6) {
            $("#new-password-err").text("New password must have at least 6 characters.");
            return
        } else if (newPassword !== confirmPassword) {
            $("#confirm-password-err").text("The confirm password doesn't match.");
            return;
        }
        $.ajax({
            url: "../lib/account.php",
            type: "POST",
            cache: false,
            async: true,
            timeout: 5000,
            data: {
                type: "updatePassword",
                old_password: oldPassword,
                new_password: newPassword,
            },
            success: function (dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult.status) {
                    $("#old-password").val("");
                    $("#new-password").val("");
                    $("#confirm-password").val("");
                    swal("Success!", "Your password has been changed!", "success");
                } else {
                    switch (dataResult.code) {
                        case 302:
                            $("#old-password-err").text(dataResult.msg);
                            break;
                        default:
                            swal("Failed!", "Error Code: " + dataResult.code + "\nDescription: " + dataResult.msg, "error");
                            break;
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    }

    // Update the user icon
    function updateIcon(icon) {
        $.ajax({
            url: "../lib/account.php",
            type: "POST",
            cache: false,
            async: true,
            timeout: 5000,
            data: {
                type: "updateIcon",
                icon: icon,
            },
            success: function (dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult.status) {
                    swal("Success!", "Your new avatar has been changed!", "success");
                    $("#profile_avatar").attr("src", icon);
                    $("#nav-avatar").attr("src", icon);
                } else {
                    swal("Failed!", "Error Code: " + dataResult.code + "\nDescription: " + dataResult.msg, "error");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    }

    $("#chgPht_btn_profile_usr_pg").on("click", function () {
        $("#changeBtn").click();
    });

    //upload icon
    $("#changeBtn").on("change", uploadFile);

    function uploadFile(event) {
        var fileTypes = ['jpg', 'jpeg', 'png', 'svg'];
        var extension = this.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
            isSuccess = fileTypes.indexOf(extension) > -1,
            FileSize = this.files[0].size / 1024 / 1024;
        if (FileSize > 5) {
            swal("File Oversize", "File size exceeds 5 MB.", "error");
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
                        var data = JSON.parse(data);
                        if (data.status == true) {
                            var hostname = window.location.href.slice(0, window.location.href.indexOf("/user"));
                            updateIcon(hostname + data.msg);
                            $("#profile-icon").attr("src", hostname + data.msg);
                        } else {
                            swal("Failed!", "Error Code: " + data.code + "\nDescription: " + data.msg, "error");
                        }
                    },
                });

            });
            FR.readAsDataURL(this.files[0]);
        } else {
            swal("File type incorrect", "We only support jpg, jpeg, png, svg format.", "error");
        }
    }

    // Logout button for homepage and editor page
    $(".logout-btn").on("click", function () {
        $.ajax({
            type: "GET",
            url: "../lib/post-logout.php",
            async: true,
            timeout: 5000,
            success: function (data) {
                var data = JSON.parse(data);
                if (data.status == true) {
                    window.location.href = "../login.php";
                } else {

                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                swal("Server Error: " + textStatus, jqXHR.status + " " + errorThrown, "error");
            }
        });
    });
</script>
</body>

</html>