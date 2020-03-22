<?php
require_once "../lib/config.php";
session_start();
try {
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $user_id = $_SESSION["id"];
        $code = $_POST["page"];
        $productName = $_POST["name"];
        if ($_POST["type"] == "update") {
            $productId = $_POST["id"];
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
                //Admins have ability to change the state
                $res1 = pg_query($link, "UPDATE vex_product SET code = '$code', product_name = '$productName' WHERE product_id = $productId RETURNING product_id");
            } else {
                //Make sure user can only change their own pages
                $res1 = pg_query($link, "UPDATE vex_product SET code = '$code', product_name = '$productName' WHERE product_id = $productId AND user_id = $user_id RETURNING product_id");
            }
        } else if ($_POST["type"] == "save") {
            //if the request type is save, insert new page into database
            $date = date('Y-m-d h:i:s');
            $res1 = pg_query($link, "INSERT INTO vex_product (user_id, product_name, code, create_time) VALUES ($user_id, '$productName','$code','$date') RETURNING product_id");
        }

        if (!$res1 || pg_affected_rows($res1) == 0) {
            //In case of inserting error, rollback sql
            pg_query("rollback");
            if ($productId == null) {
                throw new Exception("Save Record in Database failed. User ID: $user_id, Code: $code", 102);
            } else {
                throw new Exception("Upate Record in Database failed. Product ID: $productId, User ID: $user_id, Code: $code", 102);
            }
        } else {
            pg_query("commit");
            echo json_encode(
                array(
                    'status' => true,
                    'msg' => "Save/Update page Successfully.",
                    'code' => 200,
                    'product_id' => pg_fetch_row($res1)[0]
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
