<?php
/**
 * Created by PhpStorm.
 * User: Vesic
 * Date: 16.03.2018
 * Time: 22:42
 */
if(!isset($_POST["src"])) {
    echo "nul";
    exit;
}


echo file_get_contents($_POST["src"]);