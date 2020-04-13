<?php
// Include config file
require_once "./lib/config.php";
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $captcha = "";
$username_err = $password_err = $confirm_password_err = $email_err = $captcha_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    $username = trim($_POST["username"]);
    if (empty($username)) {
        $username_err = "Please enter a username.";
    } else if (!preg_match("/^[A-Za-z0-9]+$/", $username)) {
        $username_err = "Username cannot contains special character.";
    } else {
        // Prepare a select statement
        $sql = "SELECT user_id FROM vex_user WHERE username = $1";

        if ($stmt = pg_prepare($link, "search_name", $sql)) {

            // Attempt to execute the prepared statement
            if ($result = pg_execute($link, "search_name", array(trim($_POST["username"])))) {
                /* store result */
                if (pg_num_rows($result) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

        }
    }

    // Validate password
    $password = trim($_POST["password"]);
    if (empty($password)) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    }
    // Validate confirm password
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($confirm_password)) {
        $confirm_password_err = "Please confirm password.";
    } else {

        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    // Validate email
    $email = trim($_POST["email"]);
    if (empty($email)) {
        $email_err = "Please enter email.";
    } else {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $email_err = "Incorrect email format.";
    }

    // Validate captcha
    if (isset($_REQUEST['captcha'])) {
        session_start();

        if (empty($_REQUEST['captcha'])) {
            $captcha_err = "Please enter captcha.";
        } else {
            if (strtolower($_REQUEST['captcha']) != $_SESSION['authcode']) {
                $captcha_err = "Please enter correct captcha.";
            }
        }

    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) &&
        empty($captcha_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO vex_user (username, password, name, email, create_time) VALUES ($1, $2, $3, $4, $5) RETURNING user_id";

        if ($stmt = pg_prepare($link, "insert_user", $sql)) {
            // Attempt to execute the prepared statement
            if ($result = pg_execute($link, "insert_user", array($username, hash("sha256", trim($_POST["password"])), $username, trim($_POST["email"]), date('Y-m-d h:i:s')))) {
                // Redirect to login page
                writeInfo("Created User, uid:" . pg_fetch_row($result)[0]);
                if (isset($_GET["redirect"]) && $_GET["redirect"] == "true") {
                    echo "<script>setTimeout(function() {
                      swal(\"Success!\", \"This page will close at 5 sec.\", \"success\");
                    },100)</script>";

                    echo "<script>setTimeout(function() {
                      window.close();
                    },5000);</script>";
                } else {
                    echo "<script>setTimeout(function() {
                      swal(\"Success!\", \"This page will close at 5 sec.\", \"success\");
                    },100)</script>";
                    echo "<script>setTimeout(function() {
                      window.location.replace('./login.php')
                    },5000);</script>";
                }
            } else {
                writeErr("Create User Failed!, username:$username");
                echo "<script>setTimeout(function() {
                      swal(\"Failed!\", \"Create User Failed! Please Try again.\", \"Error\");
                    },100)</script>";
            }
        }
    }
    // Close connection
    pg_close($link);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register</title>
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
    <link rel="icon" href="img/Vex_Three.gif">
</head>

<body>
<div class="container" style="padding: 30px;">
    <nav class="navbar navbar-light navbar-expand fixed-top d-inline-flex"
         style="background-color: White;padding: 2% 5%;height: 80px;">
        <div class="container-fluid"><img id="reg_Emblem" style="width: 23px;height: 23px;" src="img/Vex_Three.gif"
                                          alt="vex_logo"><a class="navbar-brand" id="reg_Name" href="index.php">&nbsp;Vex</a>
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-2"><span class="sr-only">Toggle navigation</span><span
                        class="navbar-toggler-icon"></span></button>
            <div
                    class="collapse navbar-collapse" id="navcol-2">
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav"></ul>
                </div>

                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation">
                        <a class="btn btn-outline-primary btn-sm" role="button" id="reg_button"
                           href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="login-clean" style="height: 100vh;background-color: rgb(255,255,255);">
    <form class="text-left border rounded"
          style="font-size: 12px;width: 733px;height: 624px;padding: 31px; max-width: 400px; action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>
    " method="post"">
    <h1 class="display-4" style="margin: 10px 10px;padding: 11px;margin-top: -19px;margin-left: -11px;font-size: 22px;">
        <strong>Create</strong> an account</h1>
    <div class="form-group">
        <h2 class="display-4" style="font-size: 11px;">"*" Required field</h2>
    </div>
    <label style="font-size: 12px;">Username *</label>
    <span class="help-block"><?php echo $username_err; ?></span>
    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <input class="border rounded border-light form-control d-flex" type="text"
               id="register_pg_usrname"
               style="height: 37px;font-size: 12px;background-color: rgb(220,225,232); padding: 0px;" name="username"
               placeholder="Username"
               value="<?php echo $username; ?>">
    </div>
    <label>Email *</label><span class="help-block"><?php echo $email_err; ?></span>
    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        <input class="border rounded form-control" type="email"
               id="register_pg_email"
               style="background-color: rgb(220,225,232);height: 37px;font-size: 12px;padding: 0px;" name="email"
               placeholder="Email"
               value="<?php echo $email; ?>">
    </div>
    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" style="height: 18px;">
        <label>Password *</label><span class="help-block"><?php echo $password_err; ?></span>
    </div>
    <div class="form-group">
        <input class="border rounded form-control" type="password"
               id="register_pg_pw" style="height: 37px;background-color: rgb(220,225,232);font-size: 12px;padding: 0px;"
               name="password" placeholder="Password"
               value="<?php echo $password; ?>">
    </div>
    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>" style="height: 18px;">
        <label>Confirm *</label><span class="help-block"><?php echo $confirm_password_err; ?></span>
    </div>
    <div class="form-group">
        <input class="border rounded form-control" type="password"
               id="register_pg_confirm"
               style="height: 37px;background-color: rgb(220,225,232);padding: 0px;font-size: 12px;"
               name="confirm_password" placeholder="Confirm"
               value="<?php echo $confirm_password; ?>">
    </div>
    <div class="form-group">
        <label style="height: 18px;">Captcha *&nbsp;
            <a id="captcha_change" href="javascript:void(0)">
                <img id="captcha_img" border="1" src="./lib/captcha.php?r=<?php echo rand(); ?>" alt="" width="100"
                     height="30">
            </a>

        </label>
        <span class="help-block"><?php echo $captcha_err; ?></span>
    </div>
    <div class="form-group <?php echo (!empty($captcha_err)) ? 'has-error' : ''; ?>">
        <input class="border rounded form-control" type="text"
               id="register_pg_captcha"
               style="height: 37px;background-color: rgb(220,225,232);font-size: 12px;padding: 0px;" name="captcha"
               placeholder="Captcha"
               value="<?php echo $captcha; ?>">
    </div>
    <div class="form-group">
        <button class="btn btn-primary btn-block text-center border rounded d-block" id="login_pg_signUp_btn"
                type="submit" style="background-color: rgb(137,112,235);height: 40px;padding: 0px;">Sign up
        </button>
    </div>
    </form>
</div>
<div class="footer-basic" style="background-color: rgb(245,244,244);">
    <footer>
        <p class="copyright">COSC4F00 VEX Group © 2020 March</p>
    </footer>
    <div class="modal fade border rounded" role="dialog" tabindex="-1" id="login_modal"
         style="padding: 100px;margin: 0px;width: 100%;height: 100%;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="width: 498px;height: 75px;">
                    <h1 class="display-4 modal-title" style="font-size: 33px;">Login</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="popup_momorizeCheck"
                     style="height: 241px;width: 498px;background-color: #f6f5fb;"><label
                            style="color: rgb(114,120,126);font-size: 14px;">Username</label>
                    <form>
                        <div class="form-group"><input class="border rounded border-light form-control" type="text"
                                                       id="popup_username"
                                                       style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);"
                                                       required="" name="usrnm" placeholder="Username"></div>
                        <label style="color: rgb(114,120,126);font-size: 14px;">Password</label>
                        <div
                                class="form-group"><input class="border rounded border-light form-control"
                                                          type="password" id="popup_password"
                                                          style="font-size: 14px;height: 40px;background-color: rgb(220,225,232);"
                                                          required="" name="PW" placeholder="Password"></div>
                        <div class="form-group">
                            <div class="form-check"><input class="form-check-input" type="checkbox"
                                                           id="formCheck-1"><label class="form-check-label"
                                                                                   for="formCheck-1"
                                                                                   style="font-size: 14px;">Remember
                                    me</label></div>
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
<script src="./js/common.js"></script>
<script src="lib/js/sweetalert.min.js"></script>
</body>

</html>
