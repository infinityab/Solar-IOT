
<?php
require( 'functions.php' );
$powerAvailable = getSmaPower();                // get the current solar power available
if( !$powerAvailable) $powerAvailable = getSmaPower();
checkPowerTargets($powerAvailable*1000);        // check there is still enough spare power
?>

