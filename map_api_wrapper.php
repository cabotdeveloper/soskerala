<?php

if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}

function get_geocode($address){
 
    // url encode the address
    $address = urlencode($address);
    
    // google map geocode api url
    $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";
 
    // get the json response from url
    $resp_json = file_get_contents($url);
    
    // decode the json response
    $resp = json_decode($resp_json, true);
    // response status will be 'OK', if able to geocode given address
    if($resp['status']=='OK'){
        //define empty array
        $data_arr = array(); 
        // get the important data
        $data_arr['latitude'] = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : '';
        $data_arr['longitude'] = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : '';
        $data_arr['formatted_address'] = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : '';
        
        // verify if data is exist
        if(!empty($data_arr) && !empty($data_arr['latitude']) && !empty($data_arr['longitude'])){
 
            return $data_arr;
            
        }else{
            return false;
        }
        
    }else{
        return false;
    }
}

function getAllIssues() {
    $db = new SQLite3('rescueDb.db');
    $results = $db->query('SELECT * FROM issues');
    $pins = array();
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $pins[] = $row;
    }
    echo json_encode($pins);
}

function changeStatus() {
    if (isset($_GET['issue_id']) && isset($_GET['newStatus'])){
        $db = new SQLite3('rescueDb.db');
        $db->query("BEGIN TRANSACTION");
        $db->query("UPDATE  issues SET issue_status = '".$_GET['newStatus']."' WHERE issue_id='".$_GET['issue_id']."'");
        $db->query("COMMIT");
        echo 1;
    } else {
        return 0;
    }
}

if (isset($_GET['getData'])){
    getAllIssues();
    exit;
}

if (isset($_GET['changeStatus'])) {
    changeStatus();
    exit;
}

//echo json_encode(get_geocode('Moovattupuzha'));
?>
