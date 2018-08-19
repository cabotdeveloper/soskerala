<?php
if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}
$where = '';
if(isset($_GET['user']) && ($_GET['user'] == "Victim / Guest" || $_GET['user'] == "Victim/Guest") ){
    $where = " where reported_by='Victim / Guest'";
}
$db = new SQLite3('../db/rescueDb.db');
$results = $db->query("SELECT * FROM issues".$where." ORDER BY issue_id DESC");
$pins = array();
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $pins[] = $row;
}
echo json_encode(array('data' => $pins));