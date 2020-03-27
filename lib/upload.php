<?php
define('UPLOAD_DIR', '../img/');
$file_parts = explode(";base64,", $_POST['data']);
$file_base64 = base64_decode($file_parts[1]);
$file = uniqid() . '.' . $_POST['extension'];
$filePath = '/img/' . $file;
$file = UPLOAD_DIR . $file;
file_put_contents($file, $file_base64);
echo json_encode(
    array(
        'status' => true,
        'msg' => $filePath,
        'code' => 200
    )
);
exit;
