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
    //echo '<pre>';print_r($data);exit;
    $db = new SQLite3('../db/rescueDb.db');
   // $cordinates = get_geocode($data['location']);
   // $location = ($cordinates['formatted_address'])?$cordinates['formatted_address']:$data['location'];
    date_default_timezone_set('Asia/Kolkata');
    $rptTime = date('d-M-Y H:i:s', time());
    $db->query("BEGIN TRANSACTION");
    if(isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == 2 || $_SESSION["user_type"] == 3)) {
        $sql = "UPDATE issues SET no_of_persons = '".$data['noPersons']."', contact_person_name = '".$data['contactName']."',contact_person_mobile = '".$data['contactMobile']."', additional_notes = '".$data['notes']."', issue_status = '".$data['status']."',updated_date = '".$rptTime."' where issue_id=".$data['issueId'];
    }   
    else{
        $sql = "UPDATE issues SET no_of_persons = '".$data['noPersons']."', contact_person_name = '".$data['contactName']."',contact_person_mobile = '".$data['contactMobile']."', additional_notes = '".$data['notes']."',updated_date = '".$rptTime."' where issue_id=".$data['issueId'];
    }
    $res= $db->query($sql);
    $db->query("COMMIT");
    if(!$res){
        echo "Error".$db->lastErrorMsg();
    } 
    else {
        echo "Issue has been Edited successfully.";
        $ret = 1;
        unset($_POST);
        return "success";
    } 
    
    
}    
?>