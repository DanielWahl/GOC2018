<?php
/**
 * Created by PhpStorm.
 * User: Vesic
 * Date: 17.03.2018
 * Time: 00:47
 */

if(!isset($_POST["start_lng"]) || !isset($_POST["start_lat"]) || !isset($_POST["dest_lng"]) || !isset($_POST["dest_lat"])) {

    echo "ERROR";
    exit;

}


$start_lat = $_POST["start_lat"];
$start_lng = $_POST["start_lng"];
$dest_lat = $_POST["dest_lat"];
$dest_lng = $_POST["dest_lng"];


require_once dirname(__FILE__) . "/Utils.php";

echo json_encode(getTransportCar($start_lat, $start_lng, $dest_lat, $dest_lng));