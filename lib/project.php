<?php
error_reporting(E_ERROR | E_PARSE);
// Include config file
require_once "../lib/config.php";
// Initialize the session
session_start();
try {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $id = $_SESSION["id"];
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["type"])) {
            $get_type = $_GET["type"];
            switch ($get_type) {
                case "user":
                    retrieve_project_list($id, $link);
                    break;
                case "admin":
                    if ((isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true))
                        retrieve_all_project_list($link);
                    else
                        throw new Exception("You don't have permission.", 1010);
                    break;
            }
        } else {
            $post_type = $_POST["type"];
            switch ($_POST["type"]) {
                case "delete":
                    delete_page($id, $_POST["id"], $link);
                    break;
                case "update":
                    update_page($id, $_POST["page"], $_POST["id"], $link);
                    break;
                case "save":
                    save_page($id, $_POST["page"], $_POST["name"], $link);
                    break;
                case "rename":
                    rename_page($id, $_POST["id"], $_POST["name"], $link);
                    break;
                case "live":
                    change_live($id, $_POST["id"], $_POST["value"], $link);
            }
        }

    } else {
        throw new Exception("You haven't logged in.", 1010);
    }
    pg_close($link);
    exit;
} catch (Exception $e) {
    echo json_encode(
        array(
            'status' => false,
            'msg' => $e->getMessage(),
            'code' => $e->getCode()
        )
    );
}

function change_live($id, $productId, $value, $link) {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        //Admins have ability to change the state
        $sql = "UPDATE vex_product SET is_live =$1 WHERE product_id = $2";
        if ($stmt = pg_prepare($link, "update_live_admin", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_live_admin", array($value, $productId))) {
                if (pg_affected_rows($result) == 1) {
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update live successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    throw new Exception("Update live failed, id:$productId, status:$value", 1010);
                }
            }
        } else
            throw new Exception("Database Schema Exception: $sql", 123);
    } else {
        //Make sure user can only change their own pages
        $sql = "UPDATE vex_product SET is_live =$1 WHERE product_id = $2 AND user_id = $3";
        if ($stmt = pg_prepare($link, "update_live_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_live_user", array($value, $productId, $id))) {
                if (pg_affected_rows($result) == 1) {
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update live successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    throw new Exception("Update live failed, id:$productId, status:$value", 1010);
                }
            }
        } else
            throw new Exception("Database Schema Exception: $sql", 123);
    }
}

function rename_page($id, $productId, $name, $link) {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        //Admins have ability to change the state
        $sql = "UPDATE vex_product SET product_name = $1 WHERE product_id = $2 AND is_delete = false";
        if ($stmt = pg_prepare($link, "update_page_name_admin", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_page_name_admin", array($name, $productId))) {
                if (pg_affected_rows($result) == 1) {
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update page name successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    throw new Exception("Update page name failed, id:$productId, name:$name", 1010);
                }
            }
        } else
            throw new Exception("Database Schema Exception: $sql", 123);
    } else {
        //Make sure user can only change their own pages
        $sql = "UPDATE vex_product SET product_name = $1 WHERE product_id = $2 AND user_id = $3 AND is_delete = false";
        if ($stmt = pg_prepare($link, "update_page_name_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_page_name_user", array($name, $productId, $id))) {
                if (pg_affected_rows($result) == 1) {
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update page name successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    throw new Exception("Update page name failed, id:$productId, name:$name", 1010);
                }
            }
        } else
            throw new Exception("Database Schema Exception: $sql", 123);
    }
}

function save_page($id, $code, $name, $link) {
    $sql = "INSERT INTO vex_product (user_id, product_name, code, create_time) VALUES ($1, $2, $3, $4) RETURNING product_id";
    if ($stmt = pg_prepare($link, "save_page", $sql)) {
        // Execute sql
        $date = date('Y-m-d h:i:s');
        if ($result = pg_execute($link, "save_page", array($id, $name, $code, $date))) {
            if (pg_affected_rows($result) == 1) {
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Save page successfully",
                        'code' => 200,
                        'product_id' => pg_fetch_row($result)[0]
                    )
                );
            } else {
                throw new Exception("Save page failed, Page Name:$name", 1010);
            }
        }
    } else
        throw new Exception("Database Schema Exception: $sql", 123);
}

function update_page($id, $code, $productId, $link) {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        //Admins have ability to change the state
        $sql = "UPDATE vex_product SET code = $1 WHERE product_id = $2 AND is_delete = false RETURNING product_id";
        if ($stmt = pg_prepare($link, "update_page_admin", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_page_admin", array($code, $productId))) {
                if (pg_affected_rows($result) == 1) {
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update page successfully",
                            'code' => 200,
                            'product_id' => pg_fetch_row($result)[0]
                        )
                    );
                } else {
                    throw new Exception("Update page failed, id:$productId", 1010);
                }
            }
        } else
            throw new Exception("Database Schema Exception: $sql", 123);
    } else {
        //Make sure user can only change their own pages
        $sql = "UPDATE vex_product SET code = $1 WHERE product_id = $2 AND user_id = $3 AND is_delete = false RETURNING product_id";
        if ($stmt = pg_prepare($link, "update_page_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_page_user", array($code, $productId, $id))) {
                if (pg_affected_rows($result) == 1) {
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update page successfully",
                            'code' => 200,
                            'product_id' => pg_fetch_row($result)[0]
                        )
                    );
                } else {
                    throw new Exception("Update page failed, id:$productId", 1010);
                }
            }
        } else
            throw new Exception("Database Schema Exception: $sql", 123);
    }
}

function delete_page($user_id, $productId, $link) {

    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        //Admins have ability to change the state
        $sql = "UPDATE vex_product SET is_delete = true WHERE product_id = $1";
        if ($stmt = pg_prepare($link, "delete_page", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "delete_page", array($productId))) {
                if (pg_affected_rows($result) == 1) {
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Delete page successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    throw new Exception("Delete page failed, id:$productId", 1010);
                }
            }
        } else
            throw new Exception("Database Schema Exception: $sql", 123);
    } else {
        //Make sure user can only change their own pages
        $sql = "UPDATE vex_product SET is_delete = true WHERE product_id = $1 AND user_id = $2";
        if ($stmt = pg_prepare($link, "delete_page_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "delete_page_user", array($productId, $user_id))) {
                if (pg_affected_rows($result) == 1) {
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Delete page successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    throw new Exception("Delete page failed, id:$productId", 1010);
                }
            }
        } else
            throw new Exception("Database Schema Exception: $sql", 123);

    }
}

function retrieve_project_list($id, $link) {
    if (isset($_GET["page"]))
        $page = $_GET["page"];
    else
        $page = 1;

    if (isset($_GET["sort"])) {
        // Test the input and prevent sql injection
        $valid_columns = array('product_id', 'product_name');
        if (in_array($_GET['sort'], $valid_columns))
            $sort = $_GET["sort"];
        else
            throw new Exception("Invalid sorting field", 1000);
    } else
        $sort = "product_id";

    if (isset($_GET["search"]))
        $keyword = $_GET["search"];
    else
        $keyword = "";

    if ($page <= 0)
        $page = 1;
    $page_size = 5;
    $sql = "SELECT count(*) AS amount FROM vex_product WHERE user_id = $1 AND is_delete = false";
    if ($stmt = pg_prepare($link, "fetch_user_total_num_of_page", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_user_total_num_of_page", array($id))) {
            if (!$result) {
                throw new Exception("Get product list failed, userId: $id", 400);
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

            $sql = "SELECT product_id, product_name, create_time, is_live FROM vex_product WHERE user_id = $1 AND is_delete = false AND UPPER(product_name) LIKE UPPER($2) ORDER BY $sort LIMIT $3 OFFSET $4";
            if ($stmt = pg_prepare($link, "fetch_user_pages", $sql)) {
                // Execute sql
                if ($result = pg_execute($link, "fetch_user_pages", array($id, ("%" . $keyword .
                    "%"), $page_size, (($page - 1) * $page_size)))) {
                    if (!$result) {
                        throw new Exception("Get product list failed, userId: $id", 400);
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
                            'msg' => "Fetch Pages Successfully.",
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

function retrieve_all_project_list($link) {
    if (isset($_GET["page"]))
        $page = $_GET["page"];
    else
        $page = 1;

    if (isset($_GET["sort"])) {
        $valid_columns = array('product_id', 'product_name');
        if (in_array($_GET['sort'], $valid_columns))
            $sort = $_GET["sort"];
        else
            throw new Exception("Invalid sorting field", 1000);
    } else
        $sort = "product_id";

    if (isset($_GET["search"]))
        $keyword = $_GET["search"];
    else
        $keyword = "";

    if ($page <= 0)
        $page = 1;
    $page_size = 5;
    $sql = "SELECT count(*) AS amount FROM vex_product WHERE is_delete = false";
    if ($stmt = pg_prepare($link, "fetch_total_num_of_page", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_total_num_of_page", array())) {
            if (!$result) {
                throw new Exception("Get all products list failed", 400);
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

            $sql = "SELECT p.product_id, p.product_name, p.create_time, p.is_live, u.username FROM vex_product AS p, vex_user AS u WHERE p.is_delete = false AND u.user_id = p.user_id AND UPPER(p.product_name) LIKE UPPER($1) ORDER BY $sort LIMIT $2 OFFSET $3";
            if ($stmt = pg_prepare($link, "fetch_all_pages", $sql)) {
                // Execute sql
                if ($result = pg_execute($link, "fetch_all_pages", array(("%" . $keyword .
                    "%"), $page_size, (($page - 1) * $page_size)))) {
                    if (!$result) {
                        throw new Exception("Get all product list failed", 400);
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
                            'msg' => "Fetch all projects successfully.",
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