<?php

$db = new SQLite3('rescueDb.db');
$results = $db->query('SELECT * FROM issues ORDER BY issue_id DESC');
$pins = array();
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $pins[] = $row;
}
echo json_encode(array('data' => $pins));