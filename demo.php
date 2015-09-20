<?php
require_once("config/config.php");
echo "<pre>";

echo "Start Setup sample data=======<br />";
$e = new Elevator();
echo "Elevator standing in first floor. <br />";
$e->setCurrentFloor(1);
$e->setIsMoving(false);
$e->setDirection("stand");

echo "Request from 6th floor go down to ground(first floor). <br />";
//$e->requestFloor(6, "down");
//$e->moveToFloor(1, "down");
$e->transport(6, 1);

echo "Request from 5th floor go up to 7th floor. <br />";
//$e->requestFloor(5, "up");
//$e->moveToFloor(7, "up");
$e->transport(5, 7);

echo "Request from 3rd floor go down to ground. <br />";
//$e->requestFloor(3, "down");
//$e->moveToFloor(1, "down");
$e->transport(3, 1);

echo "Request from ground go up to 7th floor. <br />";
//$e->requestFloor(1, "up");
//$e->moveToFloor(7, "up");
$e->transport(1, 7);

//echo "Request from 5th floor go down to 4th floor. <br />";$e->requestFloor(6, "down");
//$e->requestFloor(5, "down");
//$e->moveToFloor(4, "down");
//$e->transport(5, 4);


print_r($e);
echo "Finish Setup sample data.<br />===========================<br /><br /><br /><br />";

//evelator run
$e->run();

echo "</pre>";