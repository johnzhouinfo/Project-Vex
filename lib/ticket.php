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
            if (isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true) {
                $get_type = $_GET["type"];
                switch ($get_type) {
                    case "list":
                        retrieve_ticket_list($link);
                        break;
                    case "retrieve":
                        if (isset($_GET["id"]))
                            retrieve_ticket($_GET["id"], $link);
                        break;
                }
            } else
                throw new Exception("You don't have permission.", 1010);
        } else {
            $post_type = $_POST["type"];
            switch ($post_type) {
                case "insert":
                    break;
                case "update":
                    update_ticket($_POST["id"], $_POST["reply"], $_POST["solve"], $link);
                    break;
                case "delete":
                    delete_ticket($_POST["id"], $link);
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


function delete_ticket($id, $link) {
    if (!(isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true)) {
        throw new Exception("You don't have permission.", 1010);
    }
    $sql = "UPDATE vex_ticket SET is_delete = true WHERE ticket_id = $1 AND is_delete = false";
    if ($stmt = pg_prepare($link, "delete_ticket", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "delete_ticket", array($id))) {
            if (!$result) {
                throw new Exception("Delete Ticket failed", 400);
            }
            if (!$result || pg_affected_rows($result) == 0) {
                throw new Exception("Delete Record in Database failed. ", 102);
            } else {
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Delete Ticket Successfully.",
                        'code' => 200,
                    )
                );
            }
        }
    } else {
        throw new Exception("Database Scheme ERROR $sql", 1000);
    }
}

function update_ticket($id, $reply, $solve, $link) {
    if (!(isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true)) {
        throw new Exception("You don't have permission.", 1010);
    }
    $sql = "UPDATE vex_ticket SET reply = $1, reply_by = $2, update_time = $3, is_solve = $4 WHERE ticket_id = $5 AND is_delete = false";
    if ($stmt = pg_prepare($link, "update_ticket", $sql)) {
        // Execute sql
        $date = date('Y-m-d h:i:s');
        if ($result = pg_execute($link, "update_ticket", array($reply, $_SESSION["id"], $date, $solve, $id))) {
            if (!$result) {
                throw new Exception("Update Ticket failed", 400);
            }
            if (!$result || pg_affected_rows($result) == 0) {
                throw new Exception("Update Record in Database failed. ", 102);
            } else {
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Update Ticket Successfully.",
                        'code' => 200,
                    )
                );
            }
        }
    } else {
        throw new Exception("Database Scheme ERROR $sql", 1000);
    }
}

function retrieve_ticket_list($link) {
    if (isset($_GET["page"]))
        $page = $_GET["page"];
    else
        $page = 1;
    if (isset($_GET["sort"])) {
        // Test the input and prevent sql injection
        $valid_columns = array('ticket_id', 'title', 'create_time', 'name');
        if (in_array($_GET['sort'], $valid_columns))
            $sort = $_GET["sort"];
        else
            throw new Exception("Invalid sorting field", 1000);
    } else
        $sort = "ticket_id";

    if (isset($_GET["search"]))
        $keyword = $_GET["search"];
    else
        $keyword = "";

    if ($page <= 0)
        $page = 1;
    $page_size = 5;
    $sql = "SELECT count(*) AS amount FROM vex_ticket WHERE is_delete = false";
    if ($stmt = pg_prepare($link, "fetch_total_num_of_page", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_total_num_of_page", array())) {
            if (!$result) {
                throw new Exception("Get all ticket list failed", 400);
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

            $sql = "SELECT ticket_id, title, name, create_time, is_solve FROM vex_ticket WHERE is_delete = false AND upper(title) LIKE upper($1) ORDER BY $sort LIMIT $2 OFFSET $3";
            if ($stmt = pg_prepare($link, "fetch_all_tickets", $sql)) {
                // Execute sql
                if ($result = pg_execute($link, "fetch_all_tickets", array(("%" . $keyword .
                    "%"), $page_size, (($page - 1) * $page_size)))) {
                    if (!$result) {
                        throw new Exception("Get all ticket list failed", 400);
                    }
                    $projectResult = array();
                    while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                        $projectResult[] = $row;
                    }
                    echo json_encode(
                        array(
                            'status' => true,
                            'pages' => $page_count,
                            'project' => $projectResult,
                            'msg' => "Login Successfully.",
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

function retrieve_ticket($id, $link) {
// The request is using the GET method
    $sql = "select * from vex_ticket where ticket_id = $1";
    if ($stmt = pg_prepare($link, "get_ticket", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "get_ticket", array($id))) {
            if (pg_num_rows($result) == 1) {
                $result_array = pg_fetch_array($result, null, PGSQL_ASSOC);
                echo json_encode(
                    array(
                        'status' => true,
                        'data' => $result_array,
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