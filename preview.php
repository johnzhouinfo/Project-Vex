<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Preview</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/fonts/font-awesome.min.css">
</head>
<body>
<?php
if (isset($_POST["preview"])) {
    echo $_POST["preview"];
}
?>
</body>
</html>
