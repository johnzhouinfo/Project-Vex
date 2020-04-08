<?php
error_reporting(E_ERROR | E_PARSE);
require_once "../lib/config.php";
session_start();
try {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $id = $_SESSION["id"];
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["type"])) {
            $get_type = $_GET["type"];
            switch ($get_type) {
                case "user":
                    if ((isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true) && isset($_GET["id"]))
                        retrieve_profile($_GET["id"], $link);
                    else
                        retrieve_profile($id, $link);
                    break;
                case "admin":
                    if ((isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true))
                        retrieve_all_user($link);
                    else
                        throw new Exception("You don't have permission", 400);
                    break;
            }

        } else {
            $post_type = $_POST["type"];
            switch ($_POST["type"]) {
                case "updateProfile":
                    update_profile($id, $_POST["name"], $_POST["email"], $link);
                    break;
                case "updatePassword":
                    update_password($id, $_POST["old_password"], $_POST["new_password"], $link);
                    break;
                case "updateUser":
                    update_user($_POST["id"], $_POST["name"], $_POST["email"], $_POST["password"], $_POST["enable"], $_POST["admin"], $link);
                    break;
                case "updateIcon":
                    update_user_icon($id, $_POST["icon"], $link);
                    break;
            }
        }

    } else {
        throw new Exception("You haven't logged in.", 1010);
    }
} catch (Exception $e) {
    echo json_encode(
        array(
            'status' => false,
            'msg' => $e->getMessage(),
            'code' => $e->getCode()
        )
    );
} finally {
    pg_close($link);
    exit;
}

function retrieve_all_user($link) {
    $keyword = "";
    if (isset($_GET["page"]))
        $page = $_GET["page"];
    if (isset($_GET["sort"])) {
        // Test the input and prevent sql injection
        $valid_columns = array('user_id', 'username', 'email', 'type');
        if (in_array($_GET['sort'], $valid_columns))
            $sort = $_GET["sort"];
        else
            throw new Exception("Invalid sorting field", 1000);
    } else
        $sort = "user_id";
    if (isset($_GET["search"]))
        $keyword = $_GET["search"];
    if ($page <= 0)
        $page = 1;
    $page_size = 5;
    $sql = "SELECT count(*) AS amount FROM vex_user";
    if ($stmt = pg_prepare($link, "fetch_total_num_of_user", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_total_num_of_user", array())) {
            if (!$result) {
                throw new Exception("Get user list failed", 400);
            }
            $total_page = pg_fetch_row($result)[0];
            if ($total_page) {
                if ($total_page < $page_size) {
                    $page_count = 1;
                }
                if ($total_page % $page_size) {
                    $page_count = (int)($total_page / $page_size) + 1;

                } else {
                    $page_count = $total_page / $page_size;

                }

            } else {
                $page_count = 1;
            }
            if ($page > $page_count)
                $page = $page_count;

            $sql = "SELECT user_id, username, name, email, create_time, type, is_enable FROM vex_user WHERE upper(username) LIKE upper($1) ORDER BY $sort LIMIT $2 OFFSET $3";
            if ($stmt = pg_prepare($link, "fetch_users", $sql)) {
                // Execute sql
                if ($result = pg_execute($link, "fetch_users", array(("%" . $keyword .
                    "%"), $page_size, (($page - 1) * $page_size)))) {
                    if (!$result) {
                        throw new Exception("Get user list failed", 400);
                    }
                    $projectResult = array();
                    while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                        $projectResult[] = $row;
                    }
                    echo json_encode(
                        array(
                            'status' => true,
                            'page' => $page_count,
                            'project' => $projectResult,
                            'msg' => "Fetch Users Successfully.",
                            'code' => 200
                        )
                    );
                }
            } else
                throw new Exception("Database Schema Exception: $sql", 123);
        }
    } else
        throw new Exception("Database Schema Exception: $sql", 123);
}

function retrieve_profile($id, $link) {
    // The request is using the GET method
    $sql = "select username, name, email, icon, type, is_enable from vex_user where user_id = $1";
    if ($stmt = pg_prepare($link, "find_user", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "find_user", array($id))) {
            if (pg_num_rows($result) == 1) {
                $result_array = pg_fetch_row($result);
                echo json_encode(
                    array(
                        'status' => true,
                        'user_id' => $id,
                        'username' => $result_array[0],
                        'name' => $result_array[1],
                        'email' => $result_array[2],
                        'icon' => $result_array[3],
                        'type' => $result_array[4],
                        'enable' => $result_array[5],
                        'msg' => "Fetch user info successfully.",
                        'code' => 200
                    )
                );
            } else {
                throw new Exception("User doesn't exist, userId $id", 1000);
            }
        }
    } else
        throw new Exception("Database Schema Exception: $sql", 123);
}

/**
 * Change user profile
 * @param $id id that user logged in
 * @param $name new user's name
 * @param $email new user's email
 * @param $icon new user's icon link
 * @param $link database
 * @throws Exception
 */
function update_profile($id, $name, $email, $link) {
    $sql = "UPDATE vex_user SET name = $1,  email = $2 where user_id = $3";
    if ($stmt = pg_prepare($link, "update_profile", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "update_profile", array($name, $email, $id))) {
            if (pg_affected_rows($result) == 1) {
                $_SESSION["name"] = $name;

                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Update profile successfully",
                        'code' => 200,
                    )
                );
            } else {
                throw new Exception("Update profile failed, id:$id", 1010);
            }
        }
    } else
        throw new Exception("Database Schema Exception: $sql", 123);
}

function update_user_icon($id, $icon, $link) {
    $sql = "UPDATE vex_user SET icon = $1 where user_id = $2";
    if ($stmt = pg_prepare($link, "update_icon", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "update_icon", array($icon, $id))) {
            if (pg_affected_rows($result) == 1) {
                $_SESSION["icon"] = $icon;
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Update icon successfully",
                        'code' => 200,
                    )
                );
            } else {
                throw new Exception("Update icon failed, id:$id", 1010);
            }
        }
    } else
        throw new Exception("Database Schema Exception: $sql", 123);
}

/**
 * Change user's password
 * @param $id
 * @param $oldPassword
 * @param $newPassword
 * @param $link
 * @throws Exception
 */
function update_password($id, $oldPassword, $newPassword, $link) {
    $sql = "select password from vex_user where user_id = $1";
    if ($stmt = pg_prepare($link, "check_password", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "check_password", array($id))) {
            $fetch_result = pg_fetch_row($result)[0];
            if (hash("sha256", $oldPassword) === trim($fetch_result)) {
                $sql = "UPDATE vex_user SET password = $1 where user_id = $2";
                if ($stmt = pg_prepare($link, "update_password", $sql)) {
                    if ($result = pg_execute($link, "update_password", array(hash("sha256", $newPassword), $id))) {
                        if (pg_affected_rows($result) == 1) {
                            echo json_encode(
                                array(
                                    'status' => true,
                                    'msg' => "Update password successfully",
                                    'code' => 200,
                                )
                            );
                        } else {
                            throw new Exception("Update password failed, id:$id", 1010);
                        }
                    }
                }
            } else {
                echo json_encode(
                    array(
                        'status' => false,
                        'msg' => "Old password doesn't match!",
                        'code' => 304,
                    )
                );
            }
        }
    } else
        throw new Exception("Database Schema Exception: $sql", 123);
}

function update_user($id, $name, $email, $password, $enable, $admin, $link) {
    if ($password == "") {
        $sql = "UPDATE vex_user SET name = $1, email = $2, is_enable = $3, type = $4 where user_id = $5";
        $insertion = array($name, $email, $enable, $admin, $id);
    } else {
        $sql = "UPDATE vex_user SET name = $1, email = $2, password = $3, is_enable = $4, type = $5 where user_id = $6";
        $insertion = array($name, $email, hash("sha256", $password), $enable, $admin, $id);
    }

    if ($stmt = pg_prepare($link, "update_user", $sql)) {

        if ($result = pg_execute($link, "update_user", $insertion)) {
            if (pg_affected_rows($result) == 1) {
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Update User Info successfully",
                        'code' => 200,
                    )
                );
            } else {
                throw new Exception("Update password failed, id:$id", 1010);
            }
        }
    } else
        throw new Exception("Database Schema Exception: $sql", 123);
}
