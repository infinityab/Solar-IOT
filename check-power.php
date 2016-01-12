
<?php
require( 'functions.php' );
require( 'config.php' );
$j = strip_tags(file_get_contents($wifiget."4"));   // GET http data from meter
$res = checkPowerTargets($j);   // to reverse the sign x -1
?>

