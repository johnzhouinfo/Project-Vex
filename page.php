<?php
// Include config file
require_once "./lib/config.php";
// Initialize the session
session_start();

$page_id = '';
// Set page_id if user entered
if (isset($_GET['id']) === true) {
    $page_id = trim($_GET['id']);
}

$sql = "SELECT * from vex_product WHERE product_id = $1";

// Redirect to Welcome page when page id is empty or 0
if (empty($page_id) || $page_id === '0') {
    redirectWelcomePage();
}

// Fetch page from DB
if (verifyPageId($page_id)) {
    if ($stmt = pg_prepare($link, "search_page", $sql)) {
        if ($result = pg_execute($link, "search_page", array($page_id))) {
            $page_result = pg_fetch_row($result);
            if (pg_num_rows($result) == 1) {
                $page_user_id = $page_result[1];
                $page_is_live = $page_result[5];
                $page_is_delete = $page_result[6];
                // The page can only be accessed by administrator or owner, or when the page is public and was not deleted
                if ($page_is_delete === 'f' &&
                    ($page_is_live === 't' || (isset($_SESSION["admin"]) && isset($_SESSION["admin"]) === true) ||
                        (isset($_SESSION["id"]) && $_SESSION["id"] === $page_user_id))) {
                    echo $page_result[3];
                } else {
                    pageNotFound($page_id);
                }
            } else {
                pageNotFound($page_id);
            }
        }
    }
} else {
    pageNotFound($page_id);
}

/**
 * Check if user entered a correct page id
 * @param $page_id
 * @return bool
 */
function verifyPageId($page_id)
{
    return is_numeric($page_id);
}

/**
 * Show the page is not available
 * @param $page_id
 */
function pageNotFound($page_id)
{
    header("HTTP/1.0 404 Page Not Found");
    echo "<h1>Page Not Found</h1>";
    echo("The requested page id = <strong>$page_id</strong> was not found or not available at the moment.");
    exit();
}

/**
 * It will redirect to welcome page
 */
function redirectWelcomePage()
{
    header("location: ./model/demo/Welcome.html");
    exit();
}