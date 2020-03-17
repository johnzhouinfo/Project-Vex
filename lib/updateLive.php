<?php

try {

    throw new Exception('Something Went Wrong', 512);


} catch (Exception $e) {

    echo json_encode(
        array(
            'status' => false,
            'error' => $e->getMessage(),
            'error_code' => $e->getCode()
        )
    );

    // do some process if needed. ex: MYSQL Rollbacks

    exit;

}
//$projectResult = pg_query($link, "SELECT * FROM vex_product WHERE user_id = $userId AND is_delete = false");