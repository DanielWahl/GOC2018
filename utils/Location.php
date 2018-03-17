<?php
/**
 * Created by PhpStorm.
 * User: Vesic
 * Date: 16.03.2018
 * Time: 23:52
 */

function Location($status, $location_name, $lat, $lng, $location_address, $mode="standing", $time=0, $distance=0) {

    if($status != "OK")
        return ["status" => "fail"];
    return [
        "status" => $status,
        "location" => [
            "name" => $location_name,
            "position" => [
                "lat" => $lat,
                "lng" => $lng
            ],
            "address" => $location_address
        ],
        "duration" => $time,
        "distance" => $distance,
        "mode" => $mode
    ];

}