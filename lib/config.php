<?php
include "log.php";

$conn_string = "host=127.0.0.1 port=5432 dbname=c4f00g04 user=c4f00g04 password=A-v9s4C&E7";
$link = pg_connect($conn_string);
if (!$link) {
    writeErr("Unable to open database");
    echo "Error : Unable to open database\n";
}
