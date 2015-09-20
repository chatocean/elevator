$(document).ready(function() {
  process();
  
});

function process() {
  $.getJSON("process.php", function(data) {
    $(".door").removeClass("current").removeClass("active");
    $("#floor_" + data.current_floor).addClass("current");
    if(data.is_open) {
      $("#floor_" + data.current_floor).addClass("active");
    }
    
    setTimeout("process()", 3000);
  });
}