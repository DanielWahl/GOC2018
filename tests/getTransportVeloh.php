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

echo "SUCCESS";

$start_lng = $_POST["start_lng"];
$start_lat = $_POST["start_lat"];
$dest_lng = $_POST["dest_lng"];
$dest_lat = $_POST["dest_lat"];

$live_data = file_get_contents("https://api.jcdecaux.com/vls/v1/stations?apiKey=3f088ee5bcc929c27d169a53c71bb8b97aaf001e");

$live_data = json_decode($live_data);

require_once "../utils/Utils.php";

$start_distance = 99999999;
$dest_distance = 9999999;

for($i = 0; $i < count($live_data); $i++) {

    if($live_data[$i]->contract_name != "Luxembourg") continue;


    $dif = PythagorasBlaaa($start_lat, $start_lng, $live_data[$i]->position->lat, $live_data[$i]->position->lng);

    if($start_distance > $dif) {
        $start_distance = $dif;
        $start_loc = $live_data[$i];
    }

    $dif = PythagorasBlaaa($dest_lat, $dest_lng, $live_data[$i]->position->lat, $live_data[$i]->position->lng);

    if($dest_distance > $dif) {
        $dest_distance = $dif;
        $dest_loc = $live_data[$i];
    }
}

echo "START:\n";
echo json_encode($start_loc);

echo "\n\nDEST:\n";

echo json_encode($dest_loc);