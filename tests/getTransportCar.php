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


$start_lng = $_POST["start_lng"];
$start_lat = $_POST["start_lat"];
$dest_lng = $_POST["dest_lng"];
$dest_lat = $_POST["dest_lat"];


$way = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $start_lat . "," . $start_lng . "&destinations=" . $dest_lat . "," . $dest_lng . "&mode=driving"));

require_once "../utils/Location.php";


$output = [];

$output[] = Location("OK", "START", $start_lat, $start_lng, $way->origin_addresses[0]);

$infos = $way->rows[0]->elements[0];
$output[] = Location($way->status, "DESTINATION", $dest_lat, $dest_lng, $way->destination_addresses[0], "driving", $infos->duration->value, $infos->distance->value);


echo json_encode($output);