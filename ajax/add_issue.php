<?php
session_start();
if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}

$ret=0;
include_once("../helper/map_api.php");

if($_POST ){
    $data = $_POST;
    $db = new SQLite3('../db/rescueDb.db');
    $cordinates = get_geocode($data['location']);
    // $location = ($cordinates['formatted_address'])?$cordinates['formatted_address']:$data['location'];
    $location = $data['location'];
    $latitude = (trim($data['latitude']) != '')? $data['latitude'] : $cordinates['latitude'];
    $longitude = (trim($data['longitude']) != '')? $data['longitude'] : $cordinates['longitude'];
    $rptTime = date('d-M-Y H:i:s', time());
    $reported_by = "Victim / Guest";
    if (isset($_SESSION['user_name'])) {
        $reported_by = $_SESSION['user_name'];
    } 
    $db->query("BEGIN TRANSACTION");
    $sql = "insert into 'issues' ('latitude','longitude','location_address','no_of_persons','contact_person_name','contact_person_mobile','additional_notes','issue_status','reported_date','updated_date', 'reported_by') VALUES('".$latitude."','".$longitude."','".$location."','".$data['noPersons']."','".$data['contactName']."','".$data['contactMobile']."','".$data['notes']."',0,'".$rptTime."','".$rptTime."', '".$reported_by."')";    
    $res= $db->query($sql);
    $db->query("COMMIT");
    if(!$res){
        echo "Error ".$db->lastErrorMsg();
    } 
    else {
        echo "Issue has been saved successfully.";
        $ret = 1;
        unset($_POST);
        return "success";
    }
    
}    
?>