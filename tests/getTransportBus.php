<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 16/03/18
 * Time: 20:38
 */

//phpinfo();
//header('Content-Type: application/json');

/* saved local */
$result = file_get_contents('http://localhost/data_collection/busStations/tfl_busStations.json');
//echo file_get_contents("https://api.tfl.lu/v1/StopPoint");

$result = json_decode($result);

$busStations = $result->features;

foreach($busStations as $busStation){
    $busStation->lat = $busStation->geometry->coordinates[0];
    $busStation->lng = $busStation->geometry->coordinates[1];
    $busStation->id = $busStation->properties->id;
    $busStation->name = $busStation->properties->name;
    echo $busStation->lat . ';' . $busStation->lng . '||' . $busStation->id . '||' . $busStation->name . '<br />';
}




