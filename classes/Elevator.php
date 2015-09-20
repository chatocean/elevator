<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Evalator
 *
 * @author chatocean
 */
class Elevator {

  private $isMoving = false; //boolean
  private $direction; // up, down
  private $requestedFloors = []; //array requestedFloor
  private $currentFloor; // current floor
  private $totalFloors;
  private $maintenanceFloors = [];

  public function __construct() {
    global $config;
    $this->totalFloors = $config['total_floors'];
    $this->maintenanceFloors = $config['maintenance_floors'];
  }

  /*
   * Set moving
   * Input  $moving
   * Output void
   */

  public function setIsMoving($moving) {
    $this->isMoving = $moving;
  }

  /*
   * Get moving
   * Output $moving
   */

  public function getIsMoving() {
    return $this->isMoving;
  }

  /*
   * Set direction
   * Input  $direction
   * Output void
   */

  public function setDirection($d) {
    $this->direction = $d;
  }

  /*
   * Get direction
   * Output $direction
   */

  public function getDirection() {
    return $this->direction;
  }

  /*
   * Set current floor
   * Input  $floor
   * Output void
   */

  public function setCurrentFloor($floor) {
    $this->currentFloor = $floor;
  }

  /*
   * Add floor you want to move to requested Floors
   * Input  $level floor level you want to move to
   *        $direction up or down
   * Output void
   */

  public function requestFloor($level, $direction) {
    if ($this->isMaintenanceFloor($level)) {
      LogUtils::write("F" . $level . " is maintenance.");
      return;
    }
    $floor = new RequestedFloor();
    $floor->setLevel($level);
    $floor->setDirection($direction);
    $this->addRequestedFloors($floor);
  }

  /*
   * Add floor you want to move to requested Floors
   * Input  $level floor level you want to move to
   *        $direction up or down
   * Output void
   */

  public function moveToFloor($level, $direction) {
//    $floor = new RequestedFloor();
//    $floor->setLevel($level);
//    $floor->setDirection($direction);
//    $this->addRequestedFloors($floor);

    $this->requestFloor($level, $direction);
  }

  /*
   * Transport from this floor to another floor
   * Input  $fromLevel
   *        $toLevel
   * Output void
   */

  public function transport($fromLevel, $toLevel) {

    if ($fromLevel < $toLevel) {
      $d = "up";
    } else {
      $d = "down";
    }

    LogUtils::write("Transport from F" . $fromLevel . " " . $d . " to F" . $toLevel);

    $this->requestFloor($fromLevel, $d);
    $this->moveToFloor($toLevel, $d);
  }

  /*
   * Get current floor
   * Output $currentFloor
   */

  public function getCurrentFloor() {
    return $this->currentFloor;
  }

  /*
   * Get total floors in elevator
   * Output $totalFloors
   */

  public function getTotalFloors() {

    return $this->totalFloors;
  }

  /*
   * Check requested floor existed or not
   * Input $requestedFloor
   * Output true/false
   */

  public function existedRequestedFloor($requestedFloor) {
    foreach ($this->requestedFloors as $floor) {
      if ($floor->direction == $requestedFloor->direction && $floor->level == $requestedFloor->level) {
        return true;
      }
    }

    return false;
  }
  
  /*
   * Get requested floors
   * Output $requestedFloors
   */

  public function getRequestedFloors() {
    
    return $this->requestedFloors;
  }
  
  /*
   * Get maintenance floors
   * Output $requestedFloors
   */

  public function getMaintenanceFloors() {
    
    return $this->maintenanceFloors;
  }

  /*
   * Add requested floor
   * Input $requestedFloor
   * Output void
   */

  public function addRequestedFloors($requestedFloor) {
    if (!$this->existedRequestedFloor($requestedFloor)) {
      $this->requestedFloors[] = $requestedFloor;
      $this->sortRequestedFloors();
      $this->buildCost();
    }
  }

  /*
   * Remove requested floor
   * Input $requestedFloor
   * Output void
   */

  public function removeRequestedFloors($requestedFloor) {
    $floors = [];
    $total = $this->totalRequestedFloors();
    for ($i = 0; $i < $total; $i++) {
      $floor = $this->requestedFloors[$i];
      if ($floor->direction == $requestedFloor->direction && $floor->level == $requestedFloor->level) {
        unset($this->requestedFloors[$i]);
      }
    }
  }

  /*
   * Get total requested floors
   * Output totalRequestedFloors
   */

  public function totalRequestedFloors() {
    return count($this->requestedFloors);
  }

  /*
   * Check Elevator has request floors or not
   * Output true/false
   */

  public function hasRequestedFloors() {

    return $this->totalRequestedFloors() > 0;
  }

  /*
   * Elevator is change direction from up to down or down to up
   */

  public function switchDirection() {
    if ($this->totalRequestedFloors() > 0) {
      LogUtils::write("Switch direction from " . $this->direction . " to ");
      $this->setDirection($this->getDirection() == "up" ? "down" : "up");
    } else {
      $this->isMoving = false;
      $this->direction = "stand";
    }
  }

  /*
   * Auto swicth direction if elevator is at first floor or last floor
   */

  public function autoDetectSwitchDirection() {
    if ($this->currentFloor == 1) {
      $this->direction = "up";
    } else if ($this->currentFloor == $this->totalFloors) {
      $this->direction = "down";
    }
  }

  /*
   * Check Elevator is moving up or not
   */

  public function isUp() {
    return $this->getDirection() == "up";
  }

  /*
   * Check Elevator is moving down or not
   */

  public function isDown() {
    return $this->getDirection() == "down";
  }

  /*
   * Check Elevator is stand or moving
   */

  public function isStand() {
    if ($this->direction == "stand" && $this->totalRequestedFloors() == 0) {

      return true;
    }

    return false;
  }

  /*
   * Open door
   */

  public function openDoor() {
    if (!$this->isMaintenanceFloor($this->currentFloor)) {
      LogUtils::write("Open door at F" . $this->currentFloor);
    } else {
      LogUtils::write("This floor is maintenance. Can not open door at Floor " . $this->currentFloor);
    }
  }

  /*
   * Close door
   */

  public function closeDoor() {
    if (!$this->isMaintenanceFloor($this->currentFloor)) {
      LogUtils::write("Close door at F" . $this->currentFloor);
    }
  }

  /*
   * Process with press alart button
   */

  public function alarm() {
    
  }

  /*
   * Check floor is maintenance or not
   * Input  $floor is floor to check
   * Output true/false
   */

  public function isMaintenanceFloor($floor) {

    return in_array($floor, $this->maintenanceFloors);
  }

  /*
   * E elevator will process when current floor is at requested floor
   * Input  $floor is requestedFloor
   * Output void
   */

  public function processAtRequestedFloor($floor) {
    if ($this->currentFloor == $floor->level) {
      $this->openDoor();
      $this->closeDoor();
      $this->removeRequestedFloors($floor);
      $this->buildCost();
    }

    $this->isMoving = true;
    $this->direction = $floor->direction;
    $maxFloor = $this->getMaxRequestFloorLevelByDirection($this->direction);
    if ($maxFloor == null) {
      $this->switchDirection();
    } else {
      $this->autoDetectSwitchDirection();
    }
    if ($this->isUp()) {
      $this->currentFloor += 1;
    } else if ($this->isDown()) {
      $this->currentFloor -= 1;
    }

    if ($this->totalRequestedFloors() > 0) {
      LogUtils::write("Move " . $this->getDirection() . " F" . $this->getCurrentFloor() . "<br />==========");
    }
  }

  /*
   * Run elevator
   */

  public function run() {
    if ($this->isStand()) {
      $this->isMoving = false;
      $this->direction = "stand";
      LogUtils::write("Elevator " . $this->getDirection() . " at F" . $this->getCurrentFloor() . "<br />==========");
      return;
    }
    LogUtils::write("In F" . $this->getCurrentFloor());
    $floor = $this->getMinCost();
    if ($floor == null) {
      return;
    }

    $this->processAtRequestedFloor($floor);

    $this->run();
  }

  /*
   * Get requested min cost of level to move elevator to this floor
   */

  public function getMinCost() {
    if ($this->currentFloor == 1 && $this->totalRequestedFloors() == 0) {
      return null;
    }
    $this->buildCost();
    $min = $this->totalFloors;
    $minFloor = null;
    foreach ($this->requestedFloors as $floor) {
      if ($floor->cost <= $min) {
        $min = $floor->cost;
        $minFloor = $floor;
      }
    }
    return $minFloor;
  }

  /*
   * Get requested last level to switch direction;
   * Input  $d is direction
   * Output object last floor to switch direction
   */

  public function getMaxRequestFloorLevelByDirection($d) {
    if ($d == "up") {
      return $this->getRequestedMaxLevel($d);
    }

    if ($d == "down") {
      return $this->getRequestedMinLevel($d);
    }
  }

  /*
   * Get requested farthest level to move elevator to this floor;
   * Input  $d is direction
   * Output object maxFloor
   */

  public function getRequestedMaxLevel($d) {
    $max = 1;
    $maxFloor = null;
    foreach ($this->requestedFloors as $floor) {
      if ($floor->direction == $d && $floor->level > $max) {
        $max = $floor->level;
        $maxFloor = $floor;
      }
    }

    return $maxFloor;
  }

  /*
   * Get requested nearest level to move elevator to this floor;
   * Input  $d is direction
   * Output object minFloor
   */

  public function getRequestedMinLevel($d) {
    $min = $this->totalFloors;
    $minFloor = null;
    foreach ($this->requestedFloors as $floor) {
      if ($floor->direction == $d && $floor->level <= $min) {
        $min = $floor->level;
        $minFloor = $floor;
      }
    }

    return $minFloor;
  }

  /*
   * Build cost in requested floors
   * 
   */

  public function buildCost() {
    $total = $this->totalFloors;
    $floors = [];
    foreach ($this->requestedFloors as $floor) {
      $floor->cost = $floor->level - $this->currentFloor;
      $floor->cost = $floor->cost < 0 ? -$floor->cost : $floor->cost;
      if ($this->isMoving && $this->direction != $floor->direction) {
        $floor->cost += $total;
      }

      $floors[] = $floor;
    }
    $this->requestedFloors = $floors;
  }

  /*
   * Sort request floors by direction
   * 
   */

  public function sortRequestedFloors() {
    $args = ["direction", "level"];
    usort($this->requestedFloors, function($a, $b) use($args) {
      $i = 0;
      $c = count($args);
      $cmp = 0;
      while ($cmp == 0 && $i < $c) {
        $cmp = strcmp($a->$args[$i], $b->$args[$i]);
        $i++;
      }

      return $cmp;
    });
  }

}
