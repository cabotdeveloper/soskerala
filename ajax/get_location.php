<?php

if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}

include_once("../helper/map_api.php");
$cordinates = get_geocode($_POST['location']);
echo $latitude = $cordinates['latitude'];
// $longitude = $cordinates['longitude'];
//echo json_encode($cordinates);