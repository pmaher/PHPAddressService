<?php

    session_start();
    header('Content-Type: application/json');
    
    switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            //$_POST will not be set when the content-type is JSON, so we need to set it
            $_POST = json_decode(file_get_contents("php://input"), true);
            if(empty($_POST['address'])) {
                $error = array('error'=>'Operation requires an address.');
                echo json_encode($error, JSON_PRETTY_PRINT);
            } else {
                initializeAddressesIfNotSet();
                $address = $_POST['address'];
                $address['id'] = $_SESSION['nextAddressId'];
                $_SESSION['addresses'][] = $address;
                $_SESSION['nextAddressId'] = intval($_SESSION['nextAddressId']) + 1;
                echo json_encode($address, JSON_PRETTY_PRINT);
            }
            break;
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
            $_SESSION['nextAddressId'] = count($someArray) + 1;
        }
    }
?>