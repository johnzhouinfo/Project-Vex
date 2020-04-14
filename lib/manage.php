<?php
// Include config file
require_once "../lib/config.php";
// Initialize the session
session_start();
try {
    if ((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) &&
        (isset($_SESSION["admin"]) && $_SESSION["admin"] === true)) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET["type"])) {
            switch ($_GET["type"]) {
                case "numUsers":
                    get_num_users($link);
                    break;
                case "numPages":
                    get_num_pages($link);
                    break;
                case "numLives":
                    get_num_lives($link);
                    break;
                case "numTickets":
                    get_num_tickets($link);
                    break;
            }
        }
    }
    pg_close($link);
    exit;
} catch (Exception $e) {

}


function get_num_users($link) {
    $sql = "SELECT count(*) AS amount FROM vex_user WHERE is_enable = true";
    if ($stmt = pg_prepare($link, "fetch_total_num_of_user", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_total_num_of_user", array())) {
            if (!$result) {
                writeErr("Get total number of user failed");
                throw new Exception("Get total number of user failed", 400);
            }
            echo json_encode(
                array(
                    'status' => true,
                    'result' => pg_fetch_row($result)[0],
                    'msg' => "Successfully Fetch Number of User.",
                    'code' => 200
                )
            );
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }

}

function get_num_pages($link) {
    $sql = "SELECT count(*) AS amount FROM vex_product WHERE is_delete = false";
    if ($stmt = pg_prepare($link, "fetch_total_num_of_page", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_total_num_of_page", array())) {
            if (!$result) {
                writeErr("Get total number of page failed");
                throw new Exception("Get total number of page failed", 400);
            }
            echo json_encode(
                array(
                    'status' => true,
                    'result' => pg_fetch_row($result)[0],
                    'msg' => "Successfully Fetch Number of Page.",
                    'code' => 200
                )
            );
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }

}

function get_num_lives($link) {
    $sql = "SELECT count(*) AS amount FROM vex_product WHERE is_live = true AND is_delete = false";
    if ($stmt = pg_prepare($link, "fetch_total_num_of_live", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_total_num_of_live", array())) {
            if (!$result) {
                writeErr("Get total number of live failed");
                throw new Exception("Get total number of live failed", 400);
            }
            echo json_encode(
                array(
                    'status' => true,
                    'result' => pg_fetch_row($result)[0],
                    'msg' => "Successfully Fetch Number of Live.",
                    'code' => 200
                )
            );
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }
}

function get_num_tickets($link) {
    $sql = "SELECT count(*) AS amount FROM vex_ticket WHERE is_solve = false AND is_delete = false";
    if ($stmt = pg_prepare($link, "fetch_total_num_of_ticket", $sql)) {
        // Execute sql
        if ($result = pg_execute($link, "fetch_total_num_of_ticket", array())) {
            if (!$result) {
                writeErr("Get total number of ticket failed");
                throw new Exception("Get total number of ticket failed", 400);
            }
            echo json_encode(
                array(
                    'status' => true,
                    'result' => pg_fetch_row($result)[0],
                    'msg' => "Successfully Fetch Number of Ticket.",
                    'code' => 200
                )
            );
        }
    } else {
        writeErr("Database Schema Exception: $sql");
        throw new Exception("Internal Server Error", 123);
    }
}