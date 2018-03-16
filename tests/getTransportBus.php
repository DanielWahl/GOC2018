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


//https://maps.googleapis.com/maps/api/distancematrix/json?origins=49.519645,6.109404&destinations=49.520195,6.114957&mode=walking&key=AIzaSyD0klnwhWakNF6e3pkI2hkYGvu-By8CZ7I
/* saved local */
$result = file_get_contents('http://localhost/data_collection/busStations/tfl_busStations.json');
//echo file_get_contents("https://api.tfl.lu/v1/StopPoint");

$result = json_decode($result);

$busStations = $result->features;

// dev origin => (49.519645, 6.109404)
// dev destination => (49.520195, 6.114957)
$origin = '49.519645,6.109404';
$destination = '49.520195,6.114957';
$nearestStationOrigin = null;
$nearestStationDestination = null;

$googleAPIKey = 'AIzaSyD0klnwhWakNF6e3pkI2hkYGvu-By8CZ7I';

foreach($busStations as $busStation){
    $busStation->lat = $busStation->geometry->coordianates[0];
    $busStation->lng = $busStation->geometry->coordinates[1];
    $busStation->latlng = $busStation->geometry->coordinates[0] . ',' . $busStation->geometry->coordinates[1];
    $busStation->id = $busStation->properties->id;
    $busStation->name = $busStation->properties->name;

    if($nearestStationDestination === null){ /* origin and destination are null */
        $nearestStationDestination = [
            'station' => $busStation,
            'distance' => -1
        ];
        $nearestStationOrigin = [
            'station' => $busStation,
            'distance' => M($busStation->lat + $busStation->lng)
        ];
        continue;
    }
    //https://maps.googleapis.com/maps/api/distancematrix/json?origins=49.519645,6.109404&destinations=49.520195,6.114957&mode=walking&key=AIzaSyD0klnwhWakNF6e3pkI2hkYGvu-By8CZ7I
    //echo file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origin . '|' . $destination . '&destinations=' . $busStation->latlng . '&key=' . $googleAPIKey);
    //if($nearestStationDestination['distance'] )

   // echo $busStation->lat . ';' . $busStation->lng . '||' . $busStation->id . '||' . $busStation->name . '<br />';
}




