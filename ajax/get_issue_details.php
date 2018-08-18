<?php

if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}


$data = $_POST;

$id = $data['id'];
$db = new SQLite3('../db/rescueDb.db');

$results = $db->query('SELECT * FROM issues WHERE issue_id='.$id);

//$pins = {};
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $pins = $row;
}

echo json_encode($pins);