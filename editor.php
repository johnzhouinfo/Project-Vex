<?php
$result = pg_connect("host=localhost dbname=c4f00g04 user=c4f00g04 password=A-v9s4C&E7")
or die("Can't connect to database" . pg_last_error());
echo $result;