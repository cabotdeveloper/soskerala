<?php
    if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
    }
    $user_name = $_POST['user_name'];
    $password = md5($_POST['password']);
    $user_type = $_POST['user_type'];
    $db = new SQLite3('../db/rescueDb.db');
    $sql ="SELECT * FROM users where user_name='".$user_name."' and password='".$password."' and user_type='".$user_type."'";
    $result = $db->querySingle($sql,true);
    if(count($result)){
        session_start();
        $_SESSION['user_id'] = $result['id'];
        echo "Success";
        return $result;
    }
    else{
        echo "Incorrect login";
        return ;
    }    
?>