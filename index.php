<?php

    session_start();
    //header('Content-Type: application/json');
    
    switch($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            //$_POST will not be set when the content-type is JSON, so we need to set it
            $_POST = json_decode(file_get_contents("php://input"), true);

            // $json = '{
            //     "title": "PHP",
            //     "site": "GeeksforGeeks"
            // }';
            // $data = json_decode($json);
            // echo '<pre>'; print_r($data);

            // break;
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
        case 'DELETE':
            $body = file_get_contents('php://input');
            $bodyArray = json_decode($body, JSON_PRETTY_PRINT);

            if(is_null($bodyArray['addressId'])) {
                $error = array('error'=>'Address id not found.');
                echo json_encode($error, JSON_PRETTY_PRINT);
            } else {
                $address = getAddressById($bodyArray['addressId']);
                if(is_null($address)) {
                    $error = array('error'=>'Address with id ' . strval($bodyArray['addressId']) . ' not found.');
                    echo json_encode($error, JSON_PRETTY_PRINT);
                } else {
                    removeAddressById($bodyArray['addressId']);
                    echo json_encode($donationRequest, JSON_PRETTY_PRINT);
                }
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

    function removeAddressById($id) {
        //need to use 'use' here since $id is not accessible inside the array_filter method
        $newArray = array_filter($_SESSION['addresses'], function($value, $key) use ($id) {
            return $value['id'] != intval($id);
        }, ARRAY_FILTER_USE_BOTH);
        //we need to re-index the array, as the keys might be off now that we removed one - so it can be properly printed in the response
        $_SESSION['addresses'] = array_values($newArray);
    }

    function getAddressById($id) {

        foreach ($_SESSION['addresses'] as &$address) {
            if($address['id'] == $id) {
                return $address;
            }
        }
        return null;
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