<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RequestedFloor
 *
 * @author chatocean
 */
class RequestedFloor {

  public $level;
  public $direction;
  public $cost = -1;

  public function setLevel($f) {
    $this->level = $f;
  }

  public function getLevel() {
    return $this->level;
  }

  public function setDirection($d) {
    $this->direction = $d;
  }

  public function getDirection() {
    return $this->direction;
  }

}
