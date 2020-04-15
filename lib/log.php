<?php
/**
 * This class will write log to /log folder,
 * It will record normal operation and errors
 */

function writeInfo($log) {
    if (!is_dir("../log")) {
        //Create our directory if it does not exist
        mkdir("../log");
    }
    $date = date('h:i:s');
    file_put_contents('../log/log_' . date("j.n.Y") . '.log', "[INFO] $date: $log\n", FILE_APPEND);
}

function writeErr($log) {
    if (!is_dir("../log")) {
        //Create our directory if it does not exist
        mkdir("../log");
    }
    $date = date('h:i:s');
    file_put_contents('../log/err_log_' . date("j.n.Y") . '.log', "[ERROR] $date: $log\n", FILE_APPEND);
}