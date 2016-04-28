
<meta http-equiv="refresh" content="45">
<p style="font-size:20px">

<?php
    startPhp();     // check for first start
    $space="";      // dummy
    $poweravailable = getSmaPower();
    if(!$poweravailable) $poweravailable = getSmaPower();      // try again if zero or null
?>
    <form method="GET">
    <table class="schedule">
<?php
    $schedule = readCrontab();
    $Schedule = checkSchedules( $schedule );  // check and bump schedules if necessary
    writeCrontab($Schedule);
    $pass = 1;
    $j = strip_tags(file_get_contents($wifiget."4"));    //  eg 192.168.x.x/gpio/0" defined in config from meter server
//    $res = checkPowerTargets($j);   // check for any power changes and action
    reset($devices);
    $firstKey = key($devices);              // get first element so we only print 'schedule' once
    foreach( $devices as $deviceName => $devicePin ) {
?>
     <tr>
     <td><b><?php print( $deviceName ) ?></b><font color='grey'> active schedule:</font></td>
     <td>
<?php
        if( isset( $schedule[$deviceName]['timeOn'] )) {
            printf( "%02d:%02d:00 for %02d:%02d:00",
                    $schedule[$deviceName]['timeOn']['hour'],
                    $schedule[$deviceName]['timeOn']['min'],
                    $schedule[$deviceName]['duration']['hour'],
                    $schedule[$deviceName]['duration']['min'] );
        } else {
            print "not scheduled";
        }
?>
     </td><td>
      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="Change schedule" />
     </td><td>
<!--      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="+Bump" /> -->
     </td><td>
<!--      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="-Bump" />  wont work with multi schedules -->
    </td><td>

       <p style="font-size:22px"><b>
<?
        if ( $pass == 1) {      // add in any extra required data below here
            print "Solar Surplus : ".$j." Watts ".$res;
        } elseif ( $pass == 2) {
            print "Solar Power : ".($poweravailable * 1000)." Watts";
        } elseif ( $pass == 3) {
            print "Power Lag : ".$powerReserve." Watts";
        }  elseif ( $pass == 4) {
        $j = strip_tags(file_get_contents($wifigetw."6"));
            print $j;
        } elseif ( $pass == 5) {
        $j = strip_tags(file_get_contents($wifigetw."7"));
            print $j;
        } elseif ( $pass == 6) {
        $j = strip_tags(file_get_contents($wifigetw."8"));
            print $j;
        }
        ++$pass;
    }
?>
<p style="font-size:18px"></b>

</b></tr>
   </table>

  </form>


