
<?php
require( 'functions.php' );
require( 'config.php' );
$j = strip_tags(file_get_contents($wifiget."4"));   // ie http://192.168.0.116/gpio/4 - is current signed consumption in watts
$res = checkPowerTargets($j);   // $res only for testing, $J is raw +watts (export) or -watts (import)
?>

