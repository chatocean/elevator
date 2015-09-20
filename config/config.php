<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$config = [
    'total_floors' => 10,
    'maintenance_floors' => [2, 4]
];

require_once("classes/LogUtils.php");
require_once("classes/Cookie.php");
require_once("classes/Elevator.php");
require_once("classes/RequestedFloor.php");
require_once("classes/Api.php");