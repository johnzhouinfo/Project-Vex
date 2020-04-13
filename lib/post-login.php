<?php
session_start();
require_once "config.php";
try {
    if (!isset($_SESSION["loggedin"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "select * from vex_user where username = $1";
        if ($stmt = pg_prepare($link, "find_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "find_user", array($username))) {
                $result_array = pg_fetch_row($result);
                $user_id = trim($result_array[0]);
                $name = trim($result_array[3]);
                $icon = trim($result_array[6]);
                if (pg_num_rows($result) == 1) {
                    if (hash("sha256", $password) === trim($result_array[2])) {
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
                            }
                            //fetch the user related products
                            $sql = "SELECT product_id, product_name, is_live FROM vex_product WHERE user_id = $1 AND is_delete = false ORDER BY create_time";
                            if ($stmt = pg_prepare($link, "find_user_pages", $sql)) {
                                // Execute sql
                                if ($result = pg_execute($link, "find_user_pages", array($user_id))) {
                                    $projectResult = array();
                                    while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                                        $projectResult[] = $row;
                                    }
                                }
                            } else
                                throw new Exception("Get product list failed, userId: $user_id", 400);

//                            $result = pg_query($link, "SELECT product_id, product_name, is_live FROM vex_product WHERE user_id = $user_id AND is_delete = false ORDER BY create_time");


                            echo json_encode(
                                array(
                                    'status' => true,
                                    'name' => $name,
                                    'icon' => $icon,
                                    'project' => $projectResult,
                                    'is_admin' => $result_array[5] == 0,
                                    'msg' => "Login Successfully.",
                                    'code' => 200
                                )
                            );
                        } else {
                            throw new Exception("This account has been blocked!", 303);
                        }
                    } else {
                        // Display an error message if password is not valid
                        throw new Exception("The password was not corrected.", 302);
                    }
                } else {
                    // Display an error message if username doesn't exist
                    throw new Exception("The username does not exist.", 301);
                }
            }
            pg_close($link);
        }
    } else {
        throw new Exception("You have already logged in.", 300);
    }
} catch (Exception $e) {
    echo json_encode(
        array(
            'status' => false,
            'msg' => $e->getMessage(),
            'code' => $e->getCode()
        )
    );
    exit;
}
