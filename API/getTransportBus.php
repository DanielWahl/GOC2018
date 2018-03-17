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
    'lat' => floatval($_POST['start_lat']),
    'lng' => floatval($_POST['start_lng'])


    /*
    'lat' => floatval(49.519645),
    'lng' => floatval(6.109404)*/
    ];
$destination = [
    'lat' => floatval( $_POST['dest_lat']),
    'lng' => floatval($_POST['dest_lng'])
    ];


$result = json_decode(file_get_contents('https://api.tfl.lu/v1/Journey/' . $origin['lat'] . ',' . $origin['lng'] . '/to/' . $destination['lat'] . ',' . $origin['lng'] . '?maxWalkDistance=50000'));
echo 'https://api.tfl.lu/v1/Journey/' . $origin['lat'] . ',' . $origin['lng'] . '/to/' . $destination['lat'] . ',' . $origin['lng'];
echo '<pre>';
//echo print_r($result->plan->itineraries[0]->legs);
echo var_dump($result);
$legs = $result->plan->itineraries[0]->legs;
//echo print_r($result->plan->itineraries[0]);
$output = [
    'steps' => [
        [
            'status' => 'OK',
            'location' => [
                'name' => 'Start',
                'position' => [
                    'lat' => $origin['lat'],
                    'lng' => $origin['lng']
                ],
                'address' => null
            ],
            'time' => 0,
            'mode' => 'standing',
            'busNo' => null
        ]
    ]
];

foreach($legs as $leg){
    if($leg->to->name !== "NONE") {
        $output['steps'][] = [
            'status' => 'OK',
            'location' => [
                'name' => $leg->to->name,
                'position' => [
                    'lat' => $leg->to->lat,
                    'lng' => $leg->to->lon
                ],
                'address' => null
            ],
            'time' => $leg->duration,
            'name' => $leg->to->name,
            'mode' => $leg->mode,
            'busNo' => $leg->routeShortName,
            'departure' => $leg->from->departure,
            'arrival' => $leg->to->arrival
        ];
    }else{
        /* destination arrived */
        $output['steps'][] = [
            'status' => 'OK',
            'location' => [
                'name' => $leg->to->name,
                'position' => [
                    'lat' => $destination['lat'],
                    'lng' => $destination['lng']
                ],
                'address' => null
            ],
            'time' => $leg->duration,
            'name' => $leg->to->name,
            'mode' => $leg->mode,
            'arrival' => $leg->to->arrival
        ];
    }
}

$googleKey = 'AIzaSyD0klnwhWakNF6e3pkI2hkYGvu-By8CZ7I';

foreach($output['steps'] as $key => $step){
    $parsedCoordinate = $step['location']['position']['lat'] . ',' . $step['location']['position']['lng'];
    $formattedAddress = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $parsedCoordinate . '&key=' . $googleKey))->results[0]->formatted_address;
    $output['steps'][$key]['location']['address'] = $formattedAddress;
}

echo print_r($output['steps']);