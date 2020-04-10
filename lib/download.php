<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo $_POST["code"];
    header('Content-Disposition: attachment; filename="' . $_POST["name"] . '.html"');
    die();
}




