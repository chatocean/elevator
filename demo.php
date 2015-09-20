<?php
require_once("config/config.php");
echo "<pre>";

echo "<h3>Start Setup sample data</h3><br />=======<br />";
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

echo "<h3>Finish Setup sample data.</h3><br />===========================<br />";
echo "<h3>Evelator data:</h3><br />";
echo "Current floor level <strong>#" . $e->getCurrentFloor() . "</strong><br />";
echo "Current direction <strong>" . $e->getDirection() . "</strong><br />";
echo "Maintenance floors: <br />";
echo "<ul>";
$maintenanceFloors = $e->getMaintenanceFloors();
foreach($maintenanceFloors as $f) {
  echo "<li>";
  echo "Floor level: <strong>#{$f}</strong>";
  echo "</li>";
}
echo "</ul>";

echo "List of requested floor sorted by direction: <br />";
echo "<ul>";
$requestedFloors = $e->getRequestedFloors();
foreach($requestedFloors as $f) {
  echo "<li>";
  echo "Direction: <strong>" . $f->direction . "</strong> - ";
  echo "Floor level: <strong>#" . $f->level . "</strong>";
  echo "</li>";
}
echo "</ul>";
echo "<br />===========================<br /><br /><br />";
echo "<h3>Elevator simulator is running.</h3><br />===========================<br />";
//evelator run
$e->run();
echo "<h3>Elevator simulator stopped.</h3><br />===========================<br />";
echo "</pre>";