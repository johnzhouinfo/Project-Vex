<?php
// Include config file
require_once "../lib/config.php";
// Initialize the session
session_start();
try {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET["type"])) {
                switch ($_GET["type"]) {
                    case "list":
                        retrieve_component_list_with_page($link);
                        break;
                    case "retrieve":
                        retrieve_component_detail_by_id($_GET["id"], $link);
                        break;
                }
            } else
                retrieve_component_list($link);
        } else {
            $post_type = $_POST["type"];
            if ((isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true))
                switch ($_POST["type"]) {
                    case "create":
                        create_component($_POST["name"], $_POST["icon"], $_POST["html"], $_POST["enable"], $link);
                        break;
                    case "update":
                        update_component($_POST["id"], $_POST["name"], $_POST["icon"], $_POST["html"], $_POST["enable"], $link);
                        break;
                    case "delete":
                        delete_component($_POST["id"], $link);
                        break;
                }
            else {
                writeInfo("Access Component Page Denied, uid: " . $_SESSION["id"]);
                throw new Exception("You don't have permission.", 304);
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
 * Create component
 * @param $name component name
 * @param $icon component icon
 * @param $html component html code
 * @param $enable visibility
 * @param $link db
 * @throws Exception
 */
function create_component($name, $icon, $html, $enable, $link) {
    $sql = "INSERT INTO vex_component (component_name, icon, code, is_enable) VALUES ($1, $2, $3, $4) RETURNING component_id";
    if ($stmt = pg_prepare($link, "create_component", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "create_component", array($name, $icon, $html, $enable))) {
            if (!$result || pg_affected_rows($result) == 0) {
                writeErr("Save Record in Database failed. Name: $name");
                throw new Exception("Save Failed. ", 102);
            } else {
                $cid = pg_fetch_row($result)[0];
                writeInfo("Save Component, cid:$cid");
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Save Successfully.",
                        'code' => 200,
                        'component_id' => $cid,
                    )
                );
            }
        }
    } else {
        writeErr("Database Scheme ERROR $sql");
        throw new Exception("Internal Server Error", 500);
    }
}

/**
 * Change component info
 * @param $id
 * @param $name
 * @param $icon
 * @param $html
 * @param $enable
 * @param $link
 * @throws Exception
 */
function update_component($id, $name, $icon, $html, $enable, $link) {
    $sql = "UPDATE vex_component SET component_name = $1, icon = $2, code = $3, is_enable = $4 WHERE component_id = $5 AND is_delete = false";
    if ($stmt = pg_prepare($link, "update_component", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "update_component", array($name, $icon, $html, $enable, $id))) {
            if (!$result || pg_affected_rows($result) == 0) {
                writeErr("Update Component Failed, cid:$id");
                throw new Exception("Update Record in Database failed. ", 102);
            } else {
                writeInfo("Update Component, cid:$id");
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Update Component Successfully.",
                        'code' => 200,
                    )
                );
            }
        } else {
            writeErr("Update Component Failed, cid $id");
            throw new Exception("Update Failed", 408);
        }
    } else {
        writeErr("Database Scheme ERROR $sql");
        throw new Exception("Internal Server Error", 500);
    }
}

/**
 * Remove component
 * @param $id
 * @param $link
 * @throws Exception
 */
function delete_component($id, $link) {
    $sql = "UPDATE vex_component SET is_delete = true WHERE component_id = $1 AND is_delete = false";
    if ($stmt = pg_prepare($link, "delete_component", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "delete_component", array($id))) {
            if (!$result || pg_affected_rows($result) == 0) {
                writeErr("Delete Record in Database failed. cid:$id");
                throw new Exception("Delete Record in Database failed. ", 102);
            } else {
                writeInfo("Deleted Component, cid:$id");
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Delete Successfully.",
                        'code' => 200,
                    )
                );
            }
        } else {
            writeErr("Delete Component Failed, cid: $id");
            throw new Exception("Delete Failed", 406);
        }
    } else {
        writeErr("Database Scheme ERROR $sql");
        throw new Exception("Internal Server Error", 500);
    }
}

/**
 * List components
 * @param $link
 * @throws Exception
 */
function retrieve_component_list($link) {
    $sql = "SELECT * FROM vex_component WHERE is_delete = false AND is_enable = true";
    if ($stmt = pg_prepare($link, "fetch_all_component", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_all_component", array())) {
            if (!$result) {
                $id = $_SESSION["id"];
                writeErr("Get all component failed, request by uid:$id");
                throw new Exception("Get all component failed", 407);
            }
            $projectResult = array();
            while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                $projectResult[] = $row;
            }
            echo json_encode(
                array(
                    'status' => true,
                    'project' => $projectResult,
                    'msg' => "Fetch Successfully.",
                    'code' => 200
                )
            );
        }
    } else {
        writeErr("Database Scheme ERROR $sql");
        throw new Exception("Internal Server Error", 500);
    }
}

/**
 * List all components
 * @param $link
 * @throws Exception
 */
function retrieve_component_list_with_page($link) {
    if (isset($_GET["page"]))
        $page = $_GET["page"];
    else
        $page = 1;

    if (isset($_GET["sort"])) {
        // Test the input and prevent sql injection
        $valid_columns = array('component_id', 'component_name');
        if (in_array($_GET['sort'], $valid_columns))
            $sort = $_GET["sort"];
        else {
            writeErr("Invalid Component Sorting Field: " . $_GET["sort"] . " uid: " . $_SESSION["id"]);
            throw new Exception("Invalid sorting field", 305);
        }

    } else
        $sort = "component_id";

    if (isset($_GET["search"]))
        $keyword = $_GET["search"];
    else
        $keyword = "";
    if ($page <= 0)
        $page = 1;
    $page_size = 5;
    $sql = "SELECT count(*) AS amount FROM vex_component WHERE is_delete = false AND upper(component_name) LIKE upper($1)";
    if ($stmt = pg_prepare($link, "fetch_component_total_num", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_component_total_num", array(("%" . $keyword .
            "%")))) {
            if (!$result) {
                writeErr("Count component list failed");
                throw new Exception("Fetch Failed", 407);
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

            $sql = "SELECT component_id, component_name, icon, is_enable FROM vex_component WHERE is_delete = false AND upper(component_name) LIKE upper($1) ORDER BY $sort LIMIT $2 OFFSET $3 ";
            if ($stmt = pg_prepare($link, "fetch_component_with_pages", $sql)) {
                // Execute sql
                if ($result = pg_execute($link, "fetch_component_with_pages", array(("%" . $keyword .
                    "%"), $page_size, (($page - 1) * $page_size)))) {
                    if (!$result) {
                        writeErr("Get component list failed");
                        throw new Exception("Fetch Failed", 407);
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
                } else {
                    writeErr("Fetch component list failed");
                    throw new Exception("Fetch Failed", 407);
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
 * List specific component
 * @param $id
 * @param $link
 * @throws Exception
 */
function retrieve_component_detail_by_id($id, $link) {
    $sql = "SELECT * FROM vex_component WHERE component_id = $1";
    if ($stmt = pg_prepare($link, "fetch_component", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_component", array($id))) {
            if (!$result) {
                writeErr("Fetch component failed");
                throw new Exception("Fetch Failed", 407);
            }
            if (pg_num_rows($result) == 1) {
                $result_array = pg_fetch_row($result);
                echo json_encode(
                    array(
                        'status' => true,
                        'component_id' => $result_array[0],
                        'component_name' => $result_array[1],
                        'icon' => $result_array[2],
                        'html' => $result_array[3],
                        'is_enable' => $result_array[4],
                        'msg' => "Fetch Successfully.",
                        'code' => 200
                    )
                );
            } else {
                throw new Exception("Component doesn't exist", 306);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 500);
    }

}


