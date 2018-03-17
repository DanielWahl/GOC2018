<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 16/03/18
 * Time: 20:38
 */
//header('Content-Type: application/json');

/* input */

/*class InputData {
        {
            'lat': $_GET['lat_0'],
            'lng': $_GET['lng_0']
        },
        {
            'lat': $_GET['lat_1'],
            'lng': $_GET['lng_1']
        }
}*/

include_once('../utils/Location.php');

$origin = [
    'lat' => floatval(49.611409),
    'lng' => floatval(6.126431)


    /*
    'lat' => floatval(49.519645),
    'lng' => floatval(6.109404)*/
    ];
$destination = [
    'lat' => floatval( 49.620609),
    'lng' => floatval(6.181827)
    ];


$result = json_decode(file_get_contents('https://api.tfl.lu/v1/Journey/' . $origin['lat'] . ',' . $origin['lng'] . '/to/' . $destination['lat'] . ',' . $origin['lng']));
echo 'https://api.tfl.lu/v1/Journey/' . $origin['lat'] . ',' . $origin['lng'] . '/to/' . $destination['lat'] . ',' . $origin['lng'];
echo '<pre>';
//echo print_r($result->plan->itineraries[0]->legs);
$legs = $result->plan->itineraries[0]->legs;
//echo print_r($result->plan->itineraries[0]);
$output = [
    'start_location' => Location('OK', '-', $origin['lat'], $origin['lng'], 'no address'),
    'steps' => []
];
foreach($legs as $leg){
    if($leg->to->lat !== ""){
        $output['steps'][] = Location('OK', $leg->to->name, $leg->to->lat, $leg->to->lon, $leg->routeShortName, $leg->mode);
    }
    //echo print_r($leg);
    //exit;
    //echo $leg->from->name . ' > ' . $leg->to->name . '(' . $leg->mode . '; start: ' . date('m.d.yyyy H:i', $leg->startTime) . ')<br />';
}

foreach($output['steps'] as $step){
    file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=YOUR_API_KEY')
}
https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&key=YOUR_API_KEY

$output['steps'][] = Location('OK', $leg->)
echo print_r($output);