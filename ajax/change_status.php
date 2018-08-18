<?php
if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}
session_start();
if(isset($_SESSION) && $_SESSION["user_type"] == 1){
    echo 2;
    exit;
}
else if (isset($_GET['issue_id']) && isset($_GET['newStatus'])){
    $db = new SQLite3('../db/rescueDb.db');
    $db->query("BEGIN TRANSACTION");
    $db->query("UPDATE  issues SET issue_status = '".$_GET['newStatus']."' WHERE issue_id='".$_GET['issue_id']."'");
    $db->query("COMMIT");
    echo 1;
} else {
    return 0;
}