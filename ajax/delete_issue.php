<?php
session_start();
if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}

if(isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == 2 || $_SESSION["user_type"] == 3)) {
    if (isset($_POST['issue_id'])){
        $db = new SQLite3('../db/rescueDb.db');
        $db->query("BEGIN TRANSACTION");
        $db->query("DELETE FROM issues WHERE issue_id='".$_POST['issue_id']."'");
        $db->query("COMMIT");
        echo 1;
    } else {
        return 0;
    }
} else {
    return 0;
}