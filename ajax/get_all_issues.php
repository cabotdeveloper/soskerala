<?php

if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}

$where = '';
if(isset($_POST['user']) && ($_POST['user'] == "Victim / Guest" || $_POST['user'] == "Victim/Guest") ){
    $where = " where reported_by='Victim / Guest'";
}
$db = new SQLite3('../db/rescueDb.db');
$results = $db->query("SELECT * FROM issues".$where);
$pins = array();
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $pins[] = $row;
}
echo json_encode($pins);