<?php
/**
 * Created by PhpStorm.
 * User: Vesic
 * Date: 16.03.2018
 * Time: 20:52
 */


require_once dirname(__FILE__) . "/Location.php";

function PythagorasBlaaa($lat1, $lng1, $lat2, $lng2) {

    $lat1 = deg2rad($lat1);
    $lng1 = deg2rad($lng1);
    $lat2 = deg2rad($lat2);
    $lng2 = deg2rad($lng2);
    $radius = 6371;
    $x = ($lng2 - $lng1) * cos(($lat1 + $lat2) / 2);
    $y = ($lat2 - $lat1);
    $d = sqrt($x * $x + $y * $y) * $radius;

    return $d;

}


function parseFloat($value) {
    return floatval(preg_replace('#^([-]*[0-9\.,\' ]+?)((\.|,){1}([0-9-]{1,3}))*$#e', "str_replace(array('.', ',', \"'\", ' '), '', '\\1') . '.\\4'", $value));
}

function getTransportCar($start_lat, $start_lng, $dest_lat, $dest_lng) {

    $way = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $start_lat . "," . $start_lng . "&destinations=" . $dest_lat . "," . $dest_lng . "&mode=driving"));


    $output = [];

    $output[] = Location("OK", "START", $start_lat, $start_lng, $way->origin_addresses[0]);

    $infos = $way->rows[0]->elements[0];
    $output[] = Location($way->status, "DESTINATION", $dest_lat, $dest_lng, $way->destination_addresses[0], "driving", $infos->duration->value, $infos->distance->value);


    return $output;

}

function getTransportVeloh($start_lat, $start_lng, $dest_lat, $dest_lng) {


// load veloh stations
    $live_data = file_get_contents("https://api.jcdecaux.com/vls/v1/stations?apiKey=3f088ee5bcc929c27d169a53c71bb8b97aaf001e");
    $live_data = json_decode($live_data);


// search nearest bicycle station for start and dest

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
    $output = [];

    $output[] = Location("OK","Start", floatval($start_lat), floatval($start_lng), $way_to_start->origin_addresses[0]);

    $infos = $way_to_start->rows[0]->elements[0];
    $output[] = Location($way_to_start->status ,$start_loc->name, $start_loc->position->lat, $start_loc->position->lng, $start_loc->address, "walking", $infos->distance->value, $infos->duration->value);

    $infos = $way_with_bicycle->rows[0]->elements[0];
    $output[] = Location($way_with_bicycle->status,$dest_loc->name, $dest_loc->position->lat, $dest_loc->position->lng, $dest_loc->address, "bicycling", $infos->distance->value, $infos->duration->value);

    $infos = $way_to_dest->rows[0]->elements[0];
    $output[] = Location($way_to_dest->status,"Destination", floatval($dest_lat), floatval($dest_lng), $way_to_dest->destination_addresses[0], "walking", $infos->distance->value, $infos->duration->value);

    return $output;
}



function getTransportWalking($start_lat, $start_lng, $dest_lat, $dest_lng) {

    $way = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $start_lat . "," . $start_lng . "&destinations=" . $dest_lat . "," . $dest_lng . "&mode=walking"));


    $output = [];

    $output[] = Location("OK", "START", $start_lat, $start_lng, $way->origin_addresses[0]);

    $infos = $way->rows[0]->elements[0];
    $output[] = Location($way->status, "DESTINATION", $dest_lat, $dest_lng, $way->destination_addresses[0], "walking", $infos->duration->value, $infos->distance->value);


    return $output;
}