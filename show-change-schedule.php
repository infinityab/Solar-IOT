
<?php
foreach( $devices as $deviceName => $devicePin ) {
    $postPar = $deviceName . 'Action';
    $postPar = str_replace( ' ', '_', $postPar );
    if( isset( $_GET[$postPar])  && $_GET[$postPar] == 'Change schedule' )
 {
        $foundDeviceName = $deviceName;
        $foundDevicePin  = $devicePin;
        break;
    }
}

if( !isset( $foundDeviceName )) {
    print( "<p class='error'>Cannot find this device.</p>" );
} else {
    $schedule = readCrontab();		// read in current schedule to populate Change Schedule
?>

<?php
if( isset( $_GET[$postPar]) ) {
    print("<br><br>");
?>
    <br><h2>Change Schedule for <?php print( $foundDeviceName )?></h2>

    <form method="POST" class="change-schedule">
     <p>
      <input type="hidden" name="deviceName" value="<?php print( $foundDeviceName ) ?>"/>
      <input type="radio" name="scheduled" value="yes"<?php if( isset( $schedule[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Run regularly, or
      <input type="radio" name="scheduled" value="no"<?php if( !isset( $schedule[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>do not run regularly

   for
      <select name="<?php print( $schedulenums ) ?>-Schedule">
       <option value="1" selected="selected">Schedule 1</option>
       <option value="2">Schedule 2</option>
       <option value="3">Schedule 3</option>
       <option value="4">Schedule 4</option>
       <option value="5">Schedule 5</option>
      </select> <font color='blue'><b> <<< Select Schedule</b></font> 
   </p>
     <p>When run, run at
      <input type="text" name="timeOnHour" value="<?php printf( "%02d", isset( $schedule[$foundDeviceName]['timeOn']['hour'] ) ?
$schedule[$foundDeviceName]['timeOn']['hour'] : 7 );?>" maxlength="2"/>
      :
      <input type="text" name="timeOnMin" value="<?php printf( "%02d", isset( $schedule[$foundDeviceName]['timeOn']['min'] ) ?
$schedule[$foundDeviceName]['timeOn']['min'] : 0 );?>" maxlength="2"/>
      for
      <input type="text" name="durationHour" value="<?php printf( "%02d", isset( $schedule[$foundDeviceName]['duration']['hour'] ) ?
$schedule[$foundDeviceName]['duration']['hour'] : 1 );?>" maxlength="2"/>
      :
      <input type="text" name="durationMin" value="<?php printf( "%02d", isset( $schedule[$foundDeviceName]['duration']['min'] ) ?
$schedule[$foundDeviceName]['duration']['min'] : 0 );?>" maxlength="2"/>.
 </p>
<p>
<?php
	require( 'emit-current-time.php' );       // added for convenience
?>
</p>
     <p>
      <input type="submit" name="change-schedule" value="Save"/>

      <a href="<?php print( $baseUrl ) ?>/">Cancel</a>
     </p>
    </form>
 <?php

  }   else {
	    if ($_GET[$postPar] == '+Bump')
		$schedule[$deviceName]['timeOn']['min'] = $schedule[$deviceName]['timeOn']['min'] + 15;  // +15 mins
			  else
		 		$schedule[$deviceName]['timeOn']['min'] = $schedule[$deviceName]['timeOn']['min'] - 15;  // -15 mins

function rangeChecki( $val, $min, $max ) {	    // +bump increment
    if( $val < $min ) {
        $val = $min;
    } elseif ( $val > $max ) {
        $val = $min;
    }
    return $val;
}

function rangeCheckd( $val, $min, $max, $dec ) {	// -bump decrement
    if( $val > $max ) {
        $val = $min;
    } elseif ( $val < $min ) {
        $val = $dec;
    }
    return $val;
}

   if ($_GET[$postPar] == '+Bump') {
		$schedule[$deviceName]['timeOn']['min'] = rangeChecki( $schedule[$deviceName]['timeOn']['min'], 0, 59 );
		if ( $schedule[$deviceName]['timeOn']['min'] == 0)
			 $schedule[$deviceName]['timeOn']['hour'] = rangeChecki(++$schedule[$deviceName]['timeOn']['hour'], 0, 23 );
		}  else {
		$schedule[$deviceName]['timeOn']['min'] = rangeCheckd( $schedule[$deviceName]['timeOn']['min'], 0, 59, 45 );    // rounded to 15 min steps
                if ( $schedule[$deviceName]['timeOn']['min'] == 45)
        			 $schedule[$deviceName]['timeOn']['hour'] = rangeCheckd(--$schedule[$deviceName]['timeOn']['hour'], 0, 23, 23 );
	 	}
         writeCrontab( $schedule );                // update the current schedule
         header( "Location: $baseUrl/" );
         exit( 0 ); }                           //   ends bump
}
?>
