<?php

function writeInfo($log) {
    $date = date('h:i:s');
    file_put_contents('../log/log_' . date("j.n.Y") . '.log', "[INFO] $date: $log\n", FILE_APPEND);
}

function writeErr($log) {
    $date = date('h:i:s');
    file_put_contents('../log/err_log_' . date("j.n.Y") . '.log', "[ERROR] $date: $log\n", FILE_APPEND);
}