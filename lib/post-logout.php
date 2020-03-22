<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

echo json_encode(
    array(
        'status' => true,
        'msg' => "Logout Successfully.",
        'code' => 200
    )
);
exit;