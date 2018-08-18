<?php
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
    $location = ($cordinates['formatted_address'])?$cordinates['formatted_address']:$data['location'];
    $rptTime = date('d-M-Y H:i:s', time());
    $db->query("BEGIN TRANSACTION");
    $sql = "insert into 'issues' ('latitude','longitude','location_address','no_of_persons','contact_person_name','contact_person_mobile','additional_notes','issue_status','reported_date','updated_date') VALUES('".$cordinates['latitude']."','".$cordinates['longitude']."','".$location."','".$data['noPersons']."','".$data['contactName']."','".$data['contactMobile']."','".$data['notes']."',0,'".$rptTime."','".$rptTime."')";    
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