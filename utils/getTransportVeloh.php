<?php
/**
 * Created by PhpStorm.
 * User: Vesic
 * Date: 16.03.2018
 * Time: 20:22
 */

if(!isset($_POST["start_lng"]) || !isset($_POST["start_lat"]) || !isset($_POST["dest_lng"]) || !isset($_POST["dest_lat"])) {

    echo "ERROR";
    exit;

}

$start_lng = $_POST["start_lng"];
$start_lat = $_POST["start_lat"];
$dest_lng = $_POST["dest_lng"];
$dest_lat = $_POST["dest_lat"];


require_once dirname(__FILE__) . "/Utils.php";

echo json_encode(getTransportVeloh($start_lat, $start_lng, $dest_lat, $dest_lng));