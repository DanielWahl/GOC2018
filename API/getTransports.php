<?php
/**
 * Created by PhpStorm.
 * User: Vesic
 * Date: 16.03.2018
 * Time: 20:22
 */

header("Content-Type: application/json");

if(!isset($_POST["start_lng"])
    || !isset($_POST["start_lat"])
    || !isset($_POST["dest_lng"])
    || !isset($_POST["dest_lat"])) {
    
    echo "ERROR";
    exit;
    
}


$start_lng = $_POST["start_lng"];
$start_lat = $_POST["start_lat"];
$dest_lng = $_POST["dest_lng"];
$dest_lat = $_POST["dest_lat"];

require_once dirname(__FILE__) . "/../utils/Utils.php";

$veloh = getTransportVeloh($start_lat, $start_lng, $dest_lat, $dest_lng);

$car = getTransportCar($start_lat, $start_lng, $dest_lat, $dest_lng);

$output = [
    "veloh" => $veloh,
    "car" => $car
];


echo json_encode($output);