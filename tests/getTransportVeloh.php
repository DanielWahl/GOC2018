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


// load veloh stations
$live_data = file_get_contents("https://api.jcdecaux.com/vls/v1/stations?apiKey=3f088ee5bcc929c27d169a53c71bb8b97aaf001e");
$live_data = json_decode($live_data);

<<<<<<< HEAD
require_once "../utils/Utils.php";
=======

// search nearest bicycle station for start and dest
require_once "../utils/LocationUtils.php";
>>>>>>> master

$start_distance = 99999999;
$dest_distance = 9999999;

for($i = 0; $i < count($live_data); $i++) {

    // filter for luxembourg
    if($live_data[$i]->contract_name != "Luxembourg") continue;

    // nearest to start
    $dif = PythagorasBlaaa($start_lat, $start_lng, $live_data[$i]->position->lat, $live_data[$i]->position->lng);

    if($start_distance > $dif) {
        $start_distance = $dif;
        $start_loc = $live_data[$i];
    }

    // nearest to dest
    $dif = PythagorasBlaaa($dest_lat, $dest_lng, $live_data[$i]->position->lat, $live_data[$i]->position->lng);

    if($dest_distance > $dif) {
        $dest_distance = $dif;
        $dest_loc = $live_data[$i];
    }
}


// http://maps.googleapis.com/maps/api/distancematrix/json?origins=<START_LAT>,<START_LNG>&destinations=<DEST_LAT>,<DEST_LNG>&mode=<bicycling|walking|driving>

$way_to_start = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $start_lat . "," . $start_lng . "&destinations=" . $start_loc->position->lat . "," . $start_loc->position->lng . "&mode=walking"));

$way_with_bicycle = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $start_loc->position->lat . "," . $start_loc->position->lng . "&destinations=" . $dest_loc->position->lat . "," . $dest_loc->position->lng . "&mode=bicycling"));

$way_to_dest = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $dest_loc->position->lat . "," . $dest_loc->position->lng . "&destinations=" . $dest_lat . "," . $dest_lng . "&mode=walking"));


// create output
require_once "../utils/Location.php";
$output = [];

$output[] = Location("OK","Start", floatval($start_lat), floatval($start_lng), $way_to_start->origin_addresses[0]);

$infos = $way_to_start->rows[0]->elements[0];
$output[] = Location($way_to_start->status ,$start_loc->name, $start_loc->position->lat, $start_loc->position->lng, $start_loc->address, "walking", $infos->distance->value, $infos->duration->value);

$infos = $way_with_bicycle->rows[0]->elements[0];
$output[] = Location($way_with_bicycle->status,$dest_loc->name, $dest_loc->position->lat, $dest_loc->position->lng, $dest_loc->address, "bicycling", $infos->distance->value, $infos->duration->value);

$infos = $way_to_dest->rows[0]->elements[0];
$output[] = Location($way_to_dest->status,"Destination", floatval($dest_lat), floatval($dest_lng), $way_to_dest->destination_addresses[0], "walking", $infos->distance->value, $infos->duration->value);

echo json_encode($output);

