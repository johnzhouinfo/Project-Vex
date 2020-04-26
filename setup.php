<?php
//error_reporting(0);
//Default database information
$status = "";
$hostname = "127.0.0.1";
$dbname = "c4f00g04";
$port = "5432";
$username = "c4f00g04";
$password = "A-v9s4C&E7";

if (isset($_POST["submit"])) {
    $hostname = trim($_POST["hostname"]);
    $port = trim($_POST["port"]);
    $dbname = trim($_POST["dbname"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $conn_string = "host=$hostname port=$port dbname=$dbname user=$username password=$password";
    $link = pg_connect($conn_string);
    if (!$link) {
        $status = "[Error] : Unable to connect database, please check the the information is correct\n";
    } else {
        $status = "[Success] : Connected to Database: $dbname\n";
        $query = file_get_contents("_sql/initial.sql");
        $result = pg_query($link, "BEGIN; " . $query);
        if (!$result) {
            //Show error message in status bar if database throw error
            $status = $status . pg_last_error($link) . "\nPlease check the database, and try again\n";
            pg_query($link, "ROLLBACK;");
        } else {
            //Commit the query
            $status = $status .
                "Initial System Successfully\nAdmin account: admin, password: 123456\nYou may close this page";
            pg_query($link, "COMMIT;");
            //Update the database info to the config file
            $str = file_get_contents('lib/config.php');
            $str = str_replace("host=127.0.0.1 port=5432 dbname=c4f00g04 user=c4f00g04 password=A-v9s4C&E7", $conn_string, $str);
            file_put_contents('lib/config.php', $str);
            //Create a marker file, prevent other user access this page
            $setup_file = fopen("setup", "w");
            fwrite($setup_file, "If this file exists, it will disable the operations in setup.php");
            fclose($setup_file);
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Setup</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="lib/css/Features-Clean.css">
    <link rel="stylesheet" href="lib/css/Footer-Basic.css">
    <link rel="stylesheet" href="lib/css/Highlight-Clean.css">
    <link rel="stylesheet" href="lib/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="lib/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="lib/css/styles.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="lib/css/sweetalert.css">
    <link rel="icon" href="img/Vex_Three.gif">
</head>

<body>
<div class="container">
    <nav class="navbar navbar-light navbar-expand fixed-top text-left"
         style="background-color: #ffffff;padding: 2% 5%;height: 80px;">
        <div class="container-fluid"><img id="home_emblem" style="width: 24px;height: 24px;" src="img/Vex_Three.gif"
                                          alt="vex_logo"><a
                    class="navbar-brand" id="home_brand" href="">&nbsp;Vex</a>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav"></ul>
            </div>
        </div>
    </nav>
</div>
<div class="login-clean" style="height: 100vh;background-color: rgb(255,255,255);padding: 150px;">
    <form class="text-left border rounded"
          style="font-size: 12px;width: 408px;padding: 37px; max-width: 400px;" method="post">
        <h1 class="display-4"
            style="margin: 10px 10px;padding: 0px;margin-top: -19px;margin-left: -11px;font-size: 20px;">System
            Setup</h1>
        <br>
        <?php
        //if the file exists, prevent user access the content
        if (file_exists("setup") && !isset($_POST["submit"])) {
            ?>
            <div class="form-group text-center">
                <img class="rounded-circle" id="setup_pg_avatar" style="width: 90px;height: 90px;"
                     src="img/Vex_Three.gif">
            </div>
            <br>
            <?php
            http_response_code(403);
            echo "<h2>System Already Setup</h2>";
            echo "<button class=\"btn btn-primary btn-block text-center border rounded d-block\" onclick=\"window.location.href='index.php'\"
                   type='button' style=\"background-color: #007bff;height: 40px;padding: 0px;\">Return</button>";
            die();
        } else {
            ?>
            <label style="font-size: 12px;">Hostname</label>
            <div class="form-group">
                <input class="border rounded border-light form-control d-flex" type="text" id="setup_pg_host"
                       style="height: 37px;font-size: 12px;background-color: rgb(220,225,232);" name="hostname"
                       placeholder="Hostname" value="<?php echo $hostname; ?>">
            </div>
            <label style="font-size: 12px;">Port</label>
            <div class="form-group">
                <input class="border rounded border-light form-control d-flex" type="text" id="setup_pg_port"
                       style="height: 37px;font-size: 12px;background-color: rgb(220,225,232);" name="port"
                       placeholder="Port" value="<?php echo $port; ?>">
            </div>

            <label style="font-size: 12px;">Database</label>
            <div class="form-group">
                <input class="border rounded border-light form-control d-flex" type="text" id="setup_pg_db_name"
                       style="height: 37px;font-size: 12px;background-color: rgb(220,225,232);" name="dbname"
                       placeholder="Database Name" value="<?php echo $dbname; ?>">
            </div>

            <label style="font-size: 12px;">Database Username</label>
            <div class="form-group">
                <input class="border rounded border-light form-control d-flex" type="text" id="setup_pg_host_username"
                       style="height: 37px;font-size: 12px;background-color: rgb(220,225,232);" name="username"
                       placeholder="Username" value="<?php echo $username; ?>">
            </div>

            <label>Database Password</label>
            <div class="form-group">
                <input class="border rounded border-light form-control d-flex" type="password" id="setup_pg_password"
                       name="password" placeholder="Password"
                       style="background-color: rgb(220,225,232);height: 37px;font-size: 12px;"
                       value="<?php echo $password; ?>">
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block text-center border rounded d-block" id="setup_pg_submit_btn"
                        type="submit" name="submit"
                        style="background-color: #007bff;height: 40px;padding: 0px;">
                    Submit
                </button>
            </div>
            <hr>

            <label>Status</label>
            <div class="form-group">
            <textarea id="w3mission" rows="4" cols="50" style="background-color: white; resize: none; color: red;"
                      disabled><?php
                echo $status;
                ?>
            </textarea>
            </div>
            <?php
        }
        ?>
    </form>
</div>
<script src="lib/js/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.min.js"></script>
<script src="lib/js/sweetalert.min.js"></script>
</body>

</html>