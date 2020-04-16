<?php
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
                    else {
                        writeInfo("Access Project Page Denied, uid: $id");
                        throw new Exception("You don't have permission.", 305);
                    }
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
        throw new Exception("You haven't logged in.", 300);
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

/**
 * Change page's live status
 * @param $id uid
 * @param $productId pid
 * @param $value true/false
 * @param $link database
 * @throws Exception
 */
function change_live($id, $productId, $value, $link) {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        //Admins have ability to change the state
        $sql = "UPDATE vex_product SET is_live =$1 WHERE product_id = $2";
        if ($stmt = pg_prepare($link, "update_live_admin", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_live_admin", array($value, $productId))) {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Update live status, uid:$id, pid:$productId, status:$value");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update live successfully",
                            'code' => 200,
                            'page_status' => $value,
                        )
                    );
                } else {
                    writeErr("Update live failed, id:$productId, status:$value");
                    throw new Exception("Update Failed", 410);
                }
            }
        } else {
            writeErr("Database Schema Exception: $sql");
            throw new Exception("Internal Server Error", 500);
        }

    } else {
        //Make sure user can only change their own pages
        $sql = "UPDATE vex_product SET is_live =$1 WHERE product_id = $2 AND user_id = $3";
        if ($stmt = pg_prepare($link, "update_live_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_live_user", array($value, $productId, $id))) {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Update live status, uid:$id, pid:$productId, status:$value");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update Successfully",
                            'code' => 200,
                            'page_status' => $value,
                        )
                    );
                } else {
                    writeErr("Update live failed, uid: $id pid:$productId, status:$value");
                    throw new Exception("Update Failed", 410);
                }
            }
        } else {
            writeErr("Database Schema Exception: $sql");
            throw new Exception("Internal Server Error", 500);
        }
    }
}

/**
 * Rename page
 * @param $id uid
 * @param $productId pid
 * @param $name page'name
 * @param $link database
 * @throws Exception
 */
function rename_page($id, $productId, $name, $link) {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        //Admins have ability to change the state
        $sql = "UPDATE vex_product SET product_name = $1 WHERE product_id = $2 AND is_delete = false";
        if ($stmt = pg_prepare($link, "update_page_name_admin", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_page_name_admin", array($name, $productId))) {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Update page name, uid: $id, pid: $productId, name: $name");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update Successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    writeErr("Update page name failed, uid:$id, pid:$productId, name:$name");
                    throw new Exception("Update Failed!", 411);
                }
            }
        } else {
            writeErr("Database Schema Exception: $sql");
            throw new Exception("Internal Server Error", 500);
        }
    } else {
        //Make sure user can only change their own pages
        $sql = "UPDATE vex_product SET product_name = $1 WHERE product_id = $2 AND user_id = $3 AND is_delete = false";
        if ($stmt = pg_prepare($link, "update_page_name_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_page_name_user", array($name, $productId, $id))) {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Update page name, uid: $id, pid: $productId, name: $name");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update Successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    writeErr("Update page name failed, uid:$id, pid:$productId, name:$name");
                    throw new Exception("Update Failed!", 411);
                }
            }
        } else {
            writeErr("Database Schema Exception: $sql");
            throw new Exception("Internal Server Error", 500);
        }
    }
}

/**
 * Insert page into the database
 * @param $id uid
 * @param $code html code
 * @param $name page name
 * @param $link database
 * @throws Exception
 */
function save_page($id, $code, $name, $link) {
    $sql = "INSERT INTO vex_product (user_id, product_name, code, create_time) VALUES ($1, $2, $3, $4) RETURNING product_id";
    if ($stmt = pg_prepare($link, "save_page", $sql)) {
        // Execute sql
        $date = date('Y-m-d h:i:s');
        if ($result = pg_execute($link, "save_page", array($id, $name, $code, $date))) {
            if (pg_affected_rows($result) == 1) {
                $pid = pg_fetch_row($result)[0];
                writeInfo("Save page, uid:$id, pid:$pid");
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Save page successfully",
                        'code' => 200,
                        'product_id' => $pid
                    )
                );
            } else {
                writeErr("Save page failed, uid: $id, name:$name");
                throw new Exception("Save Failed!", 412);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 500);
    }
}

/**
 * Modify the page
 * @param $id uid
 * @param $code html
 * @param $productId pid
 * @param $link database
 * @throws Exception
 */
function update_page($id, $code, $productId, $link) {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        //Admins have ability to change the state
        $sql = "UPDATE vex_product SET code = $1 WHERE product_id = $2 AND is_delete = false RETURNING product_id";
        if ($stmt = pg_prepare($link, "update_page_admin", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_page_admin", array($code, $productId))) {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Update page, uid:$id, pid:$productId");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update Successfully",
                            'code' => 200,
                            'product_id' => pg_fetch_row($result)[0]
                        )
                    );
                } else {
                    writeErr("Update page failed, uid:$id, pid:$productId");
                    throw new Exception("Update Failed", 413);
                }
            }
        } else {
            writeErr("Database Schema Exception: $sql");
            throw new Exception("Internal Server Error", 500);
        }
    } else {
        //Make sure user can only change their own pages
        $sql = "UPDATE vex_product SET code = $1 WHERE product_id = $2 AND user_id = $3 AND is_delete = false RETURNING product_id";
        if ($stmt = pg_prepare($link, "update_page_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "update_page_user", array($code, $productId, $id))) {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Update page, uid:$id, pid:$productId");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Update Successfully",
                            'code' => 200,
                            'product_id' => pg_fetch_row($result)[0]
                        )
                    );
                } else {
                    writeErr("Update page failed, uid:$id, pid:$productId");
                    throw new Exception("Update Failed", 413);
                }
            }
        } else {
            writeErr("Database Schema Exception: $sql");
            throw new Exception("Internal Server Error", 500);
        }
    }
}

/**
 * Remove page
 * @param $id uid
 * @param $productId pid
 * @param $link db
 * @throws Exception
 */
function delete_page($id, $productId, $link) {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        //Admins have ability to change the state
        $sql = "UPDATE vex_product SET is_delete = true WHERE product_id = $1";
        if ($stmt = pg_prepare($link, "delete_page", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "delete_page", array($productId))) {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Delete page, uid:$id, pid:$productId");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Delete Successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    writeErr("Update page failed, uid:$id, pid:$productId");
                    throw new Exception("Delete Failed", 414);
                }
            }
        } else {
            writeErr("Database Schema Exception: $sql");
            throw new Exception("Internal Server Error", 500);
        }
    } else {
        //Make sure user can only change their own pages
        $sql = "UPDATE vex_product SET is_delete = true WHERE product_id = $1 AND user_id = $2";
        if ($stmt = pg_prepare($link, "delete_page_user", $sql)) {
            // Execute sql
            if ($result = pg_execute($link, "delete_page_user", array($productId, $id))) {
                if (pg_affected_rows($result) == 1) {
                    writeInfo("Delete page, uid:$id, pid:$productId");
                    echo json_encode(
                        array(
                            'status' => true,
                            'msg' => "Delete Successfully",
                            'code' => 200,
                        )
                    );
                } else {
                    writeErr("Delete page failed, uid:$id, pid:$productId");
                    throw new Exception("Delete Failed", 414);
                }
            }
        } else {
            writeErr("Database Schema Exception: $sql");
            throw new Exception("Internal Server Error", 500);
        }

    }
}

/**
 * List project by uid
 * @param $id uid
 * @param $link db
 * @throws Exception
 */
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
        else {
            writeErr("Invalid Product Sorting Field: " . $_GET["sort"] . " uid: " . $_SESSION["id"]);
            throw new Exception("Invalid sorting field", 305);
        }
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
                writeErr("Count product list failed, uid: $id");
                throw new Exception("Fetch Failed!", 415);
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
                        writeErr("Get product list failed, uid: $id");
                        throw new Exception("Fetch Failed!", 415);
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
 * List all the projects
 * @param $link
 * @throws Exception
 */
function retrieve_all_project_list($link) {
    if (isset($_GET["page"]))
        $page = $_GET["page"];
    else
        $page = 1;

    if (isset($_GET["sort"])) {
        $valid_columns = array('product_id', 'product_name');
        if (in_array($_GET['sort'], $valid_columns))
            $sort = $_GET["sort"];
        else {
            writeErr("Invalid sorting field sort: " . $_GET["sort"]);
            throw new Exception("Invalid sorting field", 305);
        }
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
                writeErr("Count all products list failed");
                throw new Exception("Fetch failed", 415);
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
                        writeErr("Get all product list failed");
                        throw new Exception("Fetch failed", 415);
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