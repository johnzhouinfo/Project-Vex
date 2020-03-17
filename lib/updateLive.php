<?php
require_once "../lib/config.php";
session_start();
try {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $user_id = $_SESSION["id"];
        $productId = $_POST["id"];
        $value = $_POST["value"];
        if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
            //Admins have ability to change the state
            $res1 = pg_query($link, "UPDATE vex_product SET is_live =$value WHERE product_id = $productId");
        } else {
            //Make sure user can only change their own pages
            $res1 = pg_query($link, "UPDATE vex_product SET is_live =$value WHERE product_id = $productId AND user_id = $user_id");
        }
        if (!$res1 || pg_affected_rows($res1) == 0) {
            //In case of inserting error, rollback sql
            pg_query("rollback");
            throw new Exception("Update is_live into Database failed. Product ID: $productId, User ID: $user_id", 102);
        } else {
            pg_query("commit");
            echo json_encode(
                array(
                    'status' => true,
                    'msg' => "Update live page Successfully.",
                    'code' => 200
                )
            );
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
    exit;
}