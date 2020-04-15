<?php
//NOTE - Needs remove at deployment, since local doesn't have mail() function enable, which sandcastle has been configured
error_reporting(E_ERROR | E_PARSE);
// Include config file
require_once "../lib/config.php";
require_once "../lib/mailer.php";
// Initialize the session
session_start();
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["type"] === "insert") {
        create_ticket($_POST["name"], $_POST["email"], $_POST["title"], $_POST["message"], $link);
    } else if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
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
            } else {
                writeInfo("Access Ticket Page Denied, uid: $id");
                throw new Exception("You don't have permission.", 1010);
            }
        } else {
            $post_type = $_POST["type"];
            switch ($post_type) {
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
 * Create a ticket
 * @param $name user's name
 * @param $email email
 * @param $title ticket's title
 * @param $message ticket's msg
 * @param $link db
 * @throws Exception
 */
function create_ticket($name, $email, $title, $message, $link) {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
        $id = $_SESSION["id"];
    else
        $id = null;
    // Prepare an insert statement
    $sql = "INSERT INTO vex_ticket (user_id, name, email, title, msg, create_time) VALUES ($1, $2, $3, $4, $5, $6) RETURNING ticket_id";

    if ($stmt = pg_prepare($link, "insert_ticket", $sql)) {
        // Attempt to execute the prepared statement
        if ($result = pg_execute($link, "insert_ticket", array($id, $name, $email, $title, $message, date('Y-m-d h:i:s')))) {
            if (!$result || pg_affected_rows($result) == 0) {
                writeErr("Save Ticket Record in Database failed. uid:$id, title:$title");
                throw new Exception("Save Record in Database failed.", 102);
            } else {
                $ticket_id = pg_fetch_row($result)[0];
                //send email to user
                sendMail($email, $message, $ticket_id);
                writeInfo("Create ticket, uid: $id, tid: $ticket_id");
                echo json_encode(
                    array(
                        'status' => true,
                        'msg' => "Submit Successfully.",
                        'code' => 200,
                        'ticket_id' => $ticket_id,
                    )
                );
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }
}

/**
 * Remove ticket
 * @param $id tid
 * @param $link db
 * @throws Exception
 */
function delete_ticket($id, $link) {
    if (!(isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true)) {
        writeInfo("Access Ticket-Delete Denied, tid:$id uid:" . $_SESSION["id"]);
        throw new Exception("You don't have permission.", 1010);
    }
    $sql = "UPDATE vex_ticket SET is_delete = true WHERE ticket_id = $1 AND is_delete = false";
    if ($stmt = pg_prepare($link, "delete_ticket", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "delete_ticket", array($id))) {
            if (!$result || pg_affected_rows($result) == 0) {
                writeErr("Delete Record in Database failed. tid: $id, uid: " . $_SESSION["id"]);
                throw new Exception("Delete Record in Database failed. ", 102);
            } else {
                writeInfo("Delete Ticket, tid: $id");
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
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }
}

/**
 * Change ticket info
 * @param $id tid
 * @param $reply reply msg
 * @param $solve true/false
 * @param $link db
 * @throws Exception
 */
function update_ticket($id, $reply, $solve, $link) {
    if (!(isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true)) {
        writeInfo("Access Ticket-Update Denied, tid:$id uid:" . $_SESSION["id"]);
        throw new Exception("You don't have permission.", 1010);
    }
    $email = "";
    $msg = "";
    // Get ticket info
    $sql = "select email, msg from vex_ticket where ticket_id = $1";
    if ($stmt = pg_prepare($link, "get_reply_ticket", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "get_reply_ticket", array($id))) {
            if (pg_num_rows($result) == 1) {
                $result_array = pg_fetch_array($result, null, PGSQL_ASSOC);
                $email = trim($result_array[0]);

                $msg = $result_array[1];
            } else {
                throw new Exception("Ticket doesn't exist, ticketId $id", 1000);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }

    //Update ticket
    $sql = "UPDATE vex_ticket SET reply = $1, reply_by = $2, update_time = $3, is_solve = $4 WHERE ticket_id = $5 AND is_delete = false";
    if ($stmt = pg_prepare($link, "update_ticket", $sql)) {
        // Execute sql
        $date = date('Y-m-d h:i:s');
        if ($result = pg_execute($link, "update_ticket", array($reply, $_SESSION["id"], $date, $solve, $id))) {
            if (!$result || pg_affected_rows($result) == 0) {
                writeErr("Update Ticket failed, tid: $id, uid: " . $_SESSION["id"]);
                throw new Exception("Update Record in Database failed. ", 102);
            } else {
                writeInfo("Update Ticket, tid:$id, uid: " . $_SESSION["id"]);
                //Send email to user
                sendReplyMail($email, $msg, $reply, $_SESSION["name"], $id, $solve ? "Solved" : "Unsolved");
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
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }
}

/**
 * List all tickets
 * @param $link
 * @throws Exception
 */
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
        else {
            writeErr("Invalid Ticket Sorting Field: " . $_GET["sort"] . " uid: " . $_SESSION["id"]);
            throw new Exception("Invalid sorting field", 1000);
        }

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
                writeErr("Count all ticket list failed");
                throw new Exception("Count all ticket list failed", 400);
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
                        writeErr("Get all ticket list failed");
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
            } else {
                writeErr("Database Schema Exception: $sql");
                throw new Exception("Internal Server Error", 123);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }
}

/**
 * List specific ticket info
 * @param $id tid
 * @param $link db
 * @throws Exception
 */
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
                        'msg' => "Fetch Ticket successfully.",
                        'code' => 200
                    )
                );
            } else {
                throw new Exception("Ticket doesn't exist, ticketId $id", 1000);
            }
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }
}