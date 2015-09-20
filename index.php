<?php
require("config/config.php");
?>
<html>
  <head>
    <style>
      .door {
         background-color: #7e8b8b;
         height: 75px;
         width: 40px;
         padding: 2px;
      }
      .current, .active {
        background-color: yellow;
      }
      .door div.left_door {
        float: left;
        width: 48%;
        height: 100%;
        background-color: #c0c0c0;
      }
      .door div.right_door {
        float: right;
        width: 48%;
        height: 100%;
        background-color: #c0c0c0;
      }
      .active div.left_door {
        float: left;
        width: 20%;
        height: 100%;
        background-color: #c0c0c0;
      }
      .active div.right_door {
        float: right;
        width: 20%;
        height: 100%;
        background-color: #c0c0c0;
      }
      .button {
        width: 50px;
      }
    </style>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/elevator.js"></script>
  </head>
  <body>
    <h1>Elevator System</h1>
    <table>
      <?php for($i = $config['total_floors']; $i >= 1; $i--) { ?>
      <tr class="floor">
        <td class="door" id="floor_<?= $i ?>">
          <div class="left_door"><?= $i ?></div>
          <div class="right_door"></div>
        </td>
        <td>
          <div><input data="<?= $i ?>" class="button" type="button" value="Up" name="Up" /></div>
          <div><input data="<?= $i ?>" class="button" type="button" value="Down" name="Down" /></div>
        </td>
      </tr>
      <?php } ?>
    </table>
  </body>
</html>
