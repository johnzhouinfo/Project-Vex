<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="' . $_POST["name"] . '.html"');
    echo $_POST["code"];
    die();
}




