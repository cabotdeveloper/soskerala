<?php
if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}
if (isset($_POST['issue_id'])){
    $db = new SQLite3('../db/rescueDb.db');
    $db->query("BEGIN TRANSACTION");
    $db->query("DELETE FROM issues WHERE issue_id='".$_POST['issue_id']."'");
    $db->query("COMMIT");
    echo 1;
} else {
    return 0;
}