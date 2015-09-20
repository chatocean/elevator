<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cookie
 *
 * @author chatocean
 */
class Cookie {

  public static function setCookie($name, $value) {
    setcookie($name, $value, time() + 3600);
  }

  public static function getCookie($name) {
    return $_COOKIE[$name];
  }

}
