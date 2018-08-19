<?php
    session_start();
    if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
    }
    $user_name = $_POST['user_name'];
    $password = md5($_POST['password']);
    $user_type = $_POST['user_type'];
    
    if($user_type == 1){                
        session_start();
        $_SESSION['user_type'] = $user_type;
        echo "Success";
        exit;
    }
    else{
        $db = new SQLite3('../db/rescueDb.db');
        $sql ="SELECT * FROM users where user_name='".$user_name."' and password='".$password."' and user_type='".$user_type."'";
        $result = $db->querySingle($sql,true);
        if(count($result)){
            $_SESSION['user_name'] = $result['user_name'];
            $_SESSION['user_type'] = $result['user_type'];
            echo "Success";
            exit;
        }
        else{
            echo "Incorrect login";
            exit;
        }    
    }    
?>