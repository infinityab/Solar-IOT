<meta http-equiv="refresh" content="45"> <?php
    startPhp(); // check for first start
    $space = ""; // dummy
    $poweravailable = getSmaPower();
    if ( !$poweravailable )
        $poweravailable = getSmaPower(); // try again if zero or null
    
?> <form method="GET">
  <table class="schedule" width="1200";>
    <?php
    $schedule = readCrontab();
    $Schedule = checkSchedules( $schedule ); // check and bump schedules if necessary
    writeCrontab( $Schedule );
    $pass = 1;
    set_time_limit( 3 );
    $j = strip_tags( file_get_contents( $wifiget . "4" ) ); // eg 192.168.x.x/gpio/0" defined in config from meter server
    // $res = checkPowerTargets($j); // check for any power changes and action
    reset( $devices );
    $firstKey = key( $devices ); // get first element so we only print 'schedule' once
    foreach ( $devices as $deviceName => $devicePin ) {
        if ( $deviceName <> "Cntl Off-Peak" ) { // we don't want to print Off-Peak its only used for graphics ?>
    <tr>
      <td><b><?php
            print( $deviceName ); ?></b><font color='grey'> live schedule :</font></td>
      <td>
        <?php
            if ( isset( $schedule[$deviceName]['timeOn'] ) ) {
                printf( "%02d:%02d for %02d:%02d", $schedule[$deviceName]['timeOn']['hour'], $schedule[$deviceName]['timeOn']['min'], 
                    $schedule[$deviceName]['duration']['hour'], $schedule[$deviceName]['duration']['min'] 
);
            } else {
                print "not scheduled";
            }
?>
      </td>
      <td>
        <input type="submit" name="<?php
            print( $deviceName ); ?>Action" value="Change schedule" />
      </td>
      <td>
        <p style="font-size: 1.2em"><b>
          <?
            if ( $pass == 1 ) { // add in any extra required data below here
                print "Solar Surplus : " . $j . " Watts " . $res;
            } elseif ( $pass == 2 ) {
                print "Solar Power : " . ( $poweravailable * 1000 ) . " Watts";
            } elseif ( $pass == 3 ) {
                print "Power Lag : " . $powerReserve . " Watts";
            }
            /* elseif ( $pass == 4) {
            set_time_limit(2);
            $j = strip_tags(file_get_contents($wifigetw."6"));
            print $j;
            } elseif ( $pass == 5) {
            set_time_limit(2);
            $j = strip_tags(file_get_contents($wifigetw."7"));
            print $j;
            } elseif ( $pass == 6) {
            set_time_limit(2);
            $j = strip_tags(file_get_contents($wifigetw."8"));
            print $j;
            
            } */
            ++$pass;
        }
    }
?>
    </tr>
  </table>
</form>
