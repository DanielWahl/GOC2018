<?php
/**
 * Created by PhpStorm.
 * User: Vesic
 * Date: 16.03.2018
 * Time: 20:22
 */
if(!isset($_POST["start_lng"])
    || !isset($_POST["start_lat"])
    || !isset($_POST["dest_lng"])
    || !isset($_POST["dest_lat"])) {
    
    echo "ERROR";
    exit;
    
}


echo "SUCCESS";