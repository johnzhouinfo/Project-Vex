<?php
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
                    else {
                        writeInfo("Access User Page Denied, uid: " . $_SESSION["id"]);
                        throw new Exception("You don't have permission", 304);
                    }
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
        pg_close($link);
        exit;
    } else {
        throw new Exception("You haven't logged in.", 300);
    }
} catch (Exception $e) {
    echo json_encode(
        array(
            'status' => false,
            'msg' => $e->getMessage(),
            'code' => $e->getCode()
        )
    );
}

/**
 * List all users
 * @param $link
 * @throws Exception
 */
function retrieve_all_user($link) {
    $keyword = "";
    if (isset($_GET["page"]))
        $page = $_GET["page"];
    if (isset($_GET["sort"])) {
        // Test the input and prevent sql injection
        $valid_columns = array('user_id', 'username', 'email', 'type');
        if (in_array($_GET['sort'], $valid_columns))
            $sort = $_GET["sort"];
        else {
            writeErr("Invalid User Sorting Field: " . $_GET["sort"] . " uid: " . $_SESSION["id"]);
            throw new Exception("Invalid sorting field", 305);
        }

    } else
        $sort = "user_id";
    if (isset($_GET["search"]))
        $keyword = $_GET["search"];
    if ($page <= 0)
        $page = 1;
    $page_size = 5;
    $sql = "SELECT count(*) AS amount FROM vex_user WHERE upper(username) LIKE upper($1)";
    if ($stmt = pg_prepare($link, "fetch_total_num_of_user", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_total_num_of_user", array(("%" . $keyword . "%")))) {
            if (!$result) {
                writeErr("Fetch User Number Failed");
                throw new Exception("Fetch Failed", 401);
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
                        writeErr("Get User List Failed");
                        throw new Exception("Fetch Failed", 401);
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
                            'msg' => "Fetch Successfully.",
                            'code' => 200
                        )
                    );
                }
            } else {
                writeErr("Database Schema Exception: $sql");
                throw new Exception("Internal Server Error", 500);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 500);
    }

}

/**
 * List specific user info
 * @param $id uid
 * @param $link db
 * @throws Exception
 */
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
                        'msg' => "Fetch Successfully.",
                        'code' => 200
                    )
                );
            } else {
                throw new Exception("User doesn't exist", 301);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 500);
    }

}

/**
 * Change user profile
 * @param $id id that user logged in
 * @param $name new user's name
 * @param $email new user's email
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
                writeInfo("Update User profile, ID: $id, Name: $name, Email: $email");
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Update Successfully",
                        'code' => 200,
                    )
                );
            } else {
                writeErr("Update profile failed, id:$id");
                throw new Exception("Update Failed", 402);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 500);
    }

}

/**
 * Change user icon
 * @param $id uid
 * @param $icon icon url
 * @param $link db
 * @throws Exception
 */
function update_user_icon($id, $icon, $link) {
    $sql = "UPDATE vex_user SET icon = $1 where user_id = $2";
    if ($stmt = pg_prepare($link, "update_icon", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "update_icon", array($icon, $id))) {
            if (pg_affected_rows($result) == 1) {
                $_SESSION["icon"] = $icon;
                writeInfo("Update User Icon, ID:$id, URL: $icon");
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Update Successfully",
                        'code' => 200,
                    )
                );
            } else {
                writeErr("Update icon failed, id:$id");
                throw new Exception("Update Failed!", 403);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 500);
    }
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
                                    'msg' => "Update Successfully",
                                    'code' => 200,
                                )
                            );
                        } else {
                            writeErr("Update password failed, id:$id");
                            throw new Exception("Update Failed", 404);
                        }
                    }
                }
            } else {
                echo json_encode(
                    array(
                        'status' => false,
                        'msg' => "Old password doesn't match!",
                        'code' => 302,
                    )
                );
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 500);
    }
}

/**
 * Change user info, admin page
 * @param $id
 * @param $name
 * @param $email
 * @param $password
 * @param $enable
 * @param $admin
 * @param $link
 * @throws Exception
 */
function update_user($id, $name, $email, $password, $enable, $admin, $link) {
    if ($id == $_SESSION["id"]) {
        writeInfo("Attempt to modify itself in user-mngt, ID: $id");
        throw new Exception("Preventing disable yourself, change profile in this page were disabled, please change your information by click your icon in top-right corner.", 0);
    }

    if ($password == "") {
        $sql = "UPDATE vex_user SET name = $1, email = $2, is_enable = $3, type = $4 where user_id = $5";
        $insertion = array($name, $email, $enable, $admin, $id);
    } else {
        $sql = "UPDATE vex_user SET name = $1, email = $2, password = $3, is_enable = $4, type = $5 where user_id = $6";
        $insertion = array($name, $email, hash("sha256", $password), $enable, $admin, $id);
    }

    if ($stmt = pg_prepare($link, "update_user", $sql)) {
        if ($result = pg_execute($link, "update_user", $insertion)) {
            //if disable the user, user's page also need disabled
            if ($enable == "false") {
                $sql2 = "UPDATE vex_product SET is_live = false where user_id = $1";
                if ($stmt2 = pg_prepare($link, "disable_user_all_page", $sql2)) {
                    if ($result2 = pg_execute($link, "disable_user_all_page", array($id))) {
                        pg_query("commit");
                        writeInfo("Disable User ID:$id, Name: $name, Email:$email, enable:$enable, admin:$admin");
                        echo json_encode(
                            array(
                                'status' => true,
                                'msg' => "Update Successfully",
                                'code' => 200,
                            )
                        );
                    } else {
                        //Case when failed at update at multi sql lines, it needs rollback to prevent data loss.
                        pg_query("rollback");
                        writeErr("Disable user's all page failed, User ID: $id");
                        throw new Exception("Disable failed!", 405);
                    }
                } else {
                    writeErr("Database Schema Exception: $sql2");
                    throw new Exception("Internal Server Error", 500);
                }
            } else {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Update User Info ID:$id, Name: $name, Email:$email, enable:$enable, admin:$admin");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    writeErr("Update user failed, id:$id");
                    throw new Exception("Update Failed!", 402);
                }
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 500);
    }


}