<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogUtils
 *
 * @author chatocean
 */
class LogUtils {

  public static function write($message, $printToScreen = true) {
    $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
    if ($printToScreen && $script_name != "api") {
      echo $message . "<br />";
    }

    $message = self::convertBrToBreakLine($message);
    $file = "logs/application.log";
    $time = @date('[d/M/Y:H:i:s]');

    file_put_contents($file, "$time ($script_name) $message\r\n", FILE_APPEND);
    usleep(10);
  }

  public static function convertBrToBreakLine($message) {
    return str_replace("<br />", "\r\n", $message);
  }

}
