<?php
require_once( 'functions.php' );
$poweravailable = getSmaPower();
checkPowerTargets($poweravailable*1000); 

