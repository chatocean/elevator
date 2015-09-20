<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api
 *
 * @author chatocean
 */
class Api {

  private $elevator;

  public function __construct() {
    $this->elevator = new Elevator();
  }

  public function request() {
    $level = $_GET['level'];
    $direction = $_GET['direction'];
    $this->elevator->requestFloor($level, $direction);
    LogUtils::write("Reeust F{$level} move {$direction}", false);
    echo json_encode(['status' => "Ok", "message" => "Request floor added."]);
  }

  public function send() {
    $level = $_GET['level'];
    $direction = $_GET['direction'];
    $this->elevator->moveToFloor($level, $direction);
    LogUtils::write("Move {$direction} to F{$level}", false);
    echo json_encode(['status' => "Ok", "message" => "Move floor added."]);
  }

  public function openDoor() {
    $this->elevator->openDoor();
    LogUtils::write("Open door.", false);
    echo json_encode(['status' => "Ok", "message" => "Door opened."]);
  }

  public function closeDoor() {
    $this->elevator->closeDoor();
    LogUtils::write("Close door.", false);
    echo json_encode(['status' => "Ok", "message" => "Close opened."]);
  }

  public function alarm() {
    $this->elevator->alarm();
    LogUtils::write("Alarm.", false);
    echo json_encode(['status' => "Ok", "message" => "Alarm."]);
  }

}
