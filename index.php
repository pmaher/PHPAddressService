<?php

    session_start();
    header('Content-Type: application/json');
    
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            initializeAddressesIfNotSet();
            echo json_encode($_SESSION['addresses'], JSON_PRETTY_PRINT);
            break;
        default:
            $error = array('error'=>'Operation not supported.');
            echo json_encode($error, JSON_PRETTY_PRINT);
    }

    function initializeAddressesIfNotSet() {
        if(!isset($_SESSION['addresses'])) {
            $jsonurl='./addresses.json'; 
            $json = file_get_contents($jsonurl,true); 
            $someArray = json_decode($json, JSON_PRETTY_PRINT); 
            $_SESSION['addresses'] = $someArray;
        }
    }
?>