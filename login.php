<?php
// Initialize the session
// Include config file
require_once "lib/config.php";
session_start();

// Check if the user is already logged in, if yes then redirect him to specific page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if (isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true)
        header("location: admin.php");
    else
        header("location: editor.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = $captcha = "";
$username_err = $password_err = $captcha_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    // Validate captcha
    if (isset($_REQUEST['captcha'])) {
        if (empty($_REQUEST['captcha'])) {
            $captcha_err = "Please enter captcha";
        } else {
            if (strtolower($_REQUEST['captcha']) != $_SESSION['authcode']) {
                $captcha_err = "Incorrect captcha";
            }
        }
    }
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err) && empty($captcha_err)) {
        // Prepare a select statement
        $sql = "select * from vex_user where username = $1";
        if ($stmt = pg_prepare($link, "find_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "find_user", array($username))) {
                $result_array = pg_fetch_row($result);
                if (trim($result_array[1]) == $username) {
                    if (hash_equals(hash("sha256", $password), trim($result_array[2]))) {
                        // Checking the user who has been blocked or not
                        if (trim($result_array[8]) == 't') {
                            // If the user is administrator or not
                            if ($result_array[5] == 0) {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["username"] = $username;
                                $_SESSION["admin"] = true;
                                header("location: admin.php");
                            } else {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["username"] = $username;
                                header("location: editor.php");
                            }
                        } else {
                            echo '<script language="javascript">';
                            echo "alert('This account has been blocked')";
                            echo '</script>';
                        }
                    } else {
                        // Display an error message if password is not valid
                        $password_err = "The password you entered was not valid.";
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            }
        }
    }
}
// Close statement
pg_close($link);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($captcha_err)) ? 'has-error' : ''; ?>">
            <label>Captcha</label>
            <img id="captcha_img" border="1" src="model/captcha.php?r=<?php echo rand(); ?>" alt="" width="100"
                 height="30">
            <input type="text" name="captcha" class="form-control"
                   value="<?php echo $captcha; ?>">
            <span class="help-block"><?php echo $captcha_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>
</body>
</html>