<?php

$host = "host=127.0.0.1";
$port = "port=5432";
$dbname = "dbname=c4f00g04";
$credentials = "user=c4f00g04 password=A-v9s4C&E7";

$link = pg_connect("$host $port $dbname $credentials");
if (!$link) {
    echo "Error : Unable to open database\n";
}
