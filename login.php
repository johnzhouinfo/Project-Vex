<?php
// Include config file
require_once "./lib/config.php";
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to specific page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if (isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true) {
        header("location: ./web_manage/admin.php");
    } else {
        header("location: ./editor.php");
    }
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    $username = trim($_POST["username"]);
    if (empty($username)) {
        $username_err = "Please enter username.";
    }
    // Check if password is empty
    $password = trim($_POST["password"]);
    if (empty($password)) {
        $password_err = "Please enter your password.";
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "select * from vex_user where username = $1";
        if ($stmt = pg_prepare($link, "find_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "find_user", array($username))) {
                $result_array = pg_fetch_row($result);
                $user_id = trim($result_array[0]);
                $name = trim($result_array[3]);
                $icon = trim($result_array[6]);
                if (pg_num_rows($result) == 1) {
                    if (hash_equals(hash("sha256", $password), trim($result_array[2]))) {
                        // Checking the user who has been blocked or not
                        if (trim($result_array[8]) == 't') {
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $user_id;
                            $_SESSION["name"] = $name;
                            $_SESSION["icon"] = $icon;
                            // If the user is administrator or not
                            if ($result_array[5] == 0) {
                                $_SESSION["admin"] = true;
                                header("location: ./web_manage/admin.php");
                            } else {
                                header("location: ./editor.php");
                            }
                        } else {
                            $username_err = "This account has been blocked";
                        }
                    } else {
                        // Display an error message if password is not valid
                        $password_err = "Password doesn't match.";
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "Username doesn't exist.";
                }
            }
        }
    }
// Close statement
    pg_close($link);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>SignINSheet</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="lib/css/Features-Clean.css">
    <link rel="stylesheet" href="lib/css/Footer-Basic.css">
    <link rel="stylesheet" href="lib/css/Highlight-Clean.css">
    <link rel="stylesheet" href="lib/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="lib/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="lib/css/styles.css">
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
<div class="container">
    <nav class="navbar navbar-light navbar-expand fixed-top text-left"
         style="background-color: #ffffff;padding: 2% 5%;height: 80px;">
        <div class="container-fluid"><img id="home_emblem" style="width: 24px;height: 24px;" src="img/Vex_Three.gif"><a
                class="navbar-brand" id="home_brand" href="index.php">&nbsp;Vex</a>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav"></ul>
            </div>
            <ul class="nav navbar-nav">
                <li class="nav-item" role="presentation"><a class="nav-link text-primary" id="home_register"
                                                            href="register.php">Register</a></li>
            </ul>
        </div>
    </nav>
</div>
<div class="login-clean" style="height: 100vh;background-color: rgb(255,255,255);padding: 150px;">
    <form class="text-left border rounded" style="font-size: 12px;width: 408px;height: 449px;padding: 37px;" action="
    <?php
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    ?>"
          method="post">
        <h1 class="display-4"
            style="margin: 10px 10px;padding: 0px;margin-top: -19px;margin-left: -11px;font-size: 20px;">Login</h1>
        <div class="form-group text-center">
            <img class="rounded-circle" id="login_pg_avatar" style="width: 90px;height: 90px;" src="img/Vex_Three.gif">
        </div>

        <label style="font-size: 12px;">Username</label> <span class="help-block" id="username-error"
                                                               style="float: right"><?php echo $username_err; ?></span>
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <input class="border rounded border-light form-control d-flex" type="text" id="login_pg_usrname"
                   style="height: 37px;font-size: 12px;background-color: rgb(220,225,232);width: 244px;" name="username"
                   placeholder="Username" value="<?php echo $username; ?>">
        </div>

        <label>Password</label> <span class="help-block" id="username-error"
                                      style="float: right"><?php echo $password_err; ?></span>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <input class="border rounded border-light form-control d-flex" type="password" id="login_pg_password"
                   name="password" placeholder="Password"
                   style="background-color: rgb(220,225,232);height: 37px;font-size: 12px;"
                   value="<?php echo $password; ?>">
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-block text-center border rounded d-block" id="login_pg_signIn_btn"
                    type="submit" style="background-color: rgb(137,112,235);height: 40px;padding: 0px;">Sign in
            </button>
        </div>
    </form>
</div>
<div class="footer-basic" style="height: 70px;padding: 10px;background-color: rgb(244,236,236);">
    <footer>
        <p class="copyright">COSC4F00 VEX Group © 2020 March</p>
    </footer>
</div>
<script src="lib/js/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>