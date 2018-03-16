<?php
/**
 * Created by PhpStorm.
 * User: Vesic
 * Date: 16.03.2018
 * Time: 20:52
 */
/*
function deg2Rad($deg) {
    return $deg * pi() / 180;
}*/

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