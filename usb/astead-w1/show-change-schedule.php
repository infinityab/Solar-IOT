<?php

foreach( $devices as $deviceName => $devicePin ) {
    $postPar = $deviceName . 'Action';
    $postPar = str_replace( ' ', '_', $postPar ); // we love PHP
    if( (isset( $_GET[$postPar] ) && $_GET[$postPar] == 'Change schedule') || (isset( $_GET[$postPar]) && ($_GET[$postPar] == '+Bump' || $_GET[$postPar] == '-Bump')))
 {
        $foundDeviceName = $deviceName;
        $foundDevicePin  = $devicePin;
        break;
    }
}

if( !isset( $foundDeviceName )) {
    print( "<p class='error'>Cannot find this device.</p>" );
} else {
    $schedule = readCrontab();
?>

<?php
      if( isset( $_GET[$postPar]) && $_GET[$postPar] != '+Bump' && $_GET[$postPar] != '-Bump') {  # bump ?
?>

    <h2>Change Schedule for <?php print( $foundDeviceName )?></h2>

    <form method="POST" class="change-schedule">
     <p>
      <input type="hidden" name="deviceName" value="<?php print( $foundDeviceName ) ?>"/>
      <input type="radio" name="scheduled" value="yes"<?php if( isset( $schedule[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Run regularly, or
      <input type="radio" name="scheduled" value="no"<?php if( !isset( $schedule[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>do not run
regularly  

 <select name="<?php print($devicePin[0]) ?>-schedulex" onChange="this.form.submit()">
               <option value="1" <?= $devicePin[4]==1 ? "selected":""?>>Schedule 1</option>
               <option value="2" <?= $devicePin[4]==2 ? "selected":""?>>Schedule 2</option>
               <option value="3" <?= $devicePin[4]==3 ? "selected":""?>>Schedule 3</option>
               <option value="4" <?= $devicePin[4]==4 ? "selected":""?>>Schedule 4</option>
               <option value="5" <?= $devicePin[4]==5 ? "selected":""?>>Schedule 5</option>
      </select>
<!--
//      <input type="radio" name="scheduledB" value="yes"<?php if( isset( $scheduleB[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Set Schedule-A
//    <input type="radio" name="scheduledB" value="no"<?php if( !isset( $scheduleB[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Set Schedule-B
//      <input type="radio" name="scheduledB" value="no"<?php if( !isset( $scheduleB[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Set Schedule-B
//      <input type="radio" name="scheduledB" value="no"<?php if( !isset( $scheduleB[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Set Schedule-B
-->

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

<?php /*
<!-- <input type="checkbox" name="suspend" value="yes" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Off -->

 <input type="checkbox" value="0" id="suspend" name="<?php print($devicePin[0]) ?>-suspend" <?= $devicePin[4]==1 ? "checked":""?>onclick="this.form.submit()"/>OFF 

<input type="checkbox" name="cloud" value="yes" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Cloud
 <input type="checkbox" name="day1" value="1" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Mon
 <input type="checkbox" name="day2" value="2" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Tus
 <input type="checkbox" name="day3" value="4" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Wed
 <input type="checkbox" name="day4" value="8" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Thu
 <input type="checkbox" name="day5" value="16" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Fri
 <input type="checkbox" name="day6" value="32" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Sat
 <input type="checkbox" name="day7" value="64" <?php if( !isset( $scheduleA[$foundDeviceName] )) { print( " checked='checked'" ); }?>/>Sun
 <input type="checkbox" name="all" value="yes">All
*/ ?>  
 </p>
<p>

<?php
	require( 'emit-current-time.php' );       # added for convenience
?>
</p>
     <p>
      <input type="submit" name="change-schedule" value="Save"/>
<?php /*
// echo "  " . $devicePin[4];

//?>
//<?php
//$sus = $_POST['suspend'];


// $suspend = $_POST['suspend'];
//if ($sus != 'Yes') {
//   echo  $sus;
//    $sus = 'No';
//	sleep(3);
//}
//else echo "66";
// if (isset!($_POST['suspend'])) echo "51"; #  else echo "60";
// if (suspend) echo " 1  "  else echo " 0    ";
// if( $suspend != "yes") 
// if( $_POST['suspend'] == 'yes' ){ runGpio( "write", "6", 0 );
//        sleep(2);
//        runGpio( "write", "6", 0 );
//     sleep(2);
*/
?>

      <a href="<?php print( $baseUrl ) ?>/">Cancel</a>
     </p>
    </form>
 <?php

  }   else {
	    if ($_GET[$postPar] == '+Bump')
		$schedule[$deviceName]['timeOn']['min'] = $schedule[$deviceName]['timeOn']['min'] + 15;  # +15 mins
			  else
		 		$schedule[$deviceName]['timeOn']['min'] = $schedule[$deviceName]['timeOn']['min'] - 15;  # -15 mins

function rangeChecki( $val, $min, $max ) {	# +bump increment
    if( $val < $min ) {
        $val = $min;
    } elseif ( $val > $max ) {
        $val = $min;
    }
    return $val;
}

function rangeCheckd( $val, $min, $max, $dec ) {	# -bump decrement
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
		$schedule[$deviceName]['timeOn']['min'] = rangeCheckd( $schedule[$deviceName]['timeOn']['min'], 0, 59, 45 );
                if ( $schedule[$deviceName]['timeOn']['min'] == 45)
			 $schedule[$deviceName]['timeOn']['hour'] = rangeCheckd(--$schedule[$deviceName]['timeOn']['hour'], 0, 23, 23 );
	 	} 

         writeCrontab( $schedule );
         header( "Location: $baseUrl/" );
         exit( 0 ); }                           #   ends bump

}
?>
