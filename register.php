<?php
// Include config file
require_once "lib/config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $captcha = "";
$username_err = $password_err = $confirm_password_err = $email_err = $captcha_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
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
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $email_err = "Incorrect email format.";
    }

    // Validate captcha
    if (isset($_REQUEST['captcha'])) {
        session_start();

        if (empty($_REQUEST['captcha'])) {
            $captcha_err = "Please enter captcha";
        } else {
            if (strtolower($_REQUEST['captcha']) != $_SESSION['authcode']) {
                $captcha_err = "Incorrect captcha";
            }
        }

    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($captcha_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO vex_user (username, password, name, email, create_time) VALUES ($1, $2, $3, $4, $5)";

        if ($stmt = pg_prepare($link, "insert_user", $sql)) {
            // Attempt to execute the prepared statement
            if ($result = pg_execute($link, "insert_user", array($username, hash("sha256", trim($_POST["password"])), $username, trim($_POST["email"]), date('Y-m-d h:i:s')))) {
                // Redirect to login page
                header("location: login.php");

            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    }
    // Close connection
    pg_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control"
                   value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($captcha_err)) ? 'has-error' : ''; ?>">
            <label>Captcha</label>
            <a id="captcha_change" href="javascript:void(0)">
                <img id="captcha_img" border="1" src="model/captcha.php?r=<?php echo rand(); ?>" alt="" width="100"
                     height="30">
            </a>
            <input type="text" name="captcha" class="form-control"
                   value="<?php echo $captcha; ?>">
            <span class="help-block"><?php echo $captcha_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
    <script>
        $("#captcha_change").on("click", function () {
            $('#captcha_img').attr('src', 'model/captcha.php?r=' + Math.random());
        });
    </script>
</div>
</body>
</html>