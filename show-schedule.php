
<meta http-equiv="refresh" content="60">
<p style="font-size:20px">

<?php
    startPhp();     // check for first start
    $space="";      // dummy
    $poweravailable = getSmaPower();
    if(!$poweravailable) $poweravailable = getSmaPower();      // try again if zero or null
    print "<b>Next Schedule </b>below".$space; //- <b>Solar Power : " . $poweravailable." Kws </b> ~  Power Reserve : " . $powerReserve . " Watts";
    print (" | " ); require( 'emit-current-time.php' ); ?><p></p>

  <form method="GET">
  <table class="schedule">
<?php
    $schedule = readCrontab();
//    $timeOut = (date("H")*60) + date("i");
//    if(!( $timeOut ) ) {                 // i.e midnight time rollover
        $Schedule = checkSchedules( $schedule );
        writeCrontab($Schedule);
//    }
    $pass = 1;
    $j = strip_tags(file_get_contents($wifiget."4"));    //  eg 192.168.x.x/gpio/0" defined in config from meter server
//    $res = checkPowerTargets($j);   // check for any power changes and action
    reset($devices);
    $firstKey = key($devices);              // get first element so we only print 'schedule' once
    foreach( $devices as $deviceName => $devicePin ) {
?>
     <tr>
     <th><?php print( $deviceName ) ?> daily at:</th>
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
      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="+Bump" />
     </td><td>
      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="-Bump" />
    </td><td>

       <p style="font-size:22px"><b>
<?
        if ( $pass == 1) {      // add in any extra required data below here
            print "Solar Surplus : ".$j." Watts ".$res;
        } elseif ( $pass == 2) {
            print "Solar Power : ".($poweravailable * 1000)." Watts";
        } elseif ( $pass == 3) {
            print "Power Lag : ".$powerReserve." Watts";
        } elseif ( $pass == 4) {
        $j = strip_tags(file_get_contents($wifiget."6"));
            print $j;
        } elseif ( $pass == 5) {
        $j = strip_tags(file_get_contents($wifiget."7"));
            print $j;
        } elseif ( $pass == 6) {
        $j = strip_tags(file_get_contents($wifiget."8"));
            print $j;
//        } elseif ( $pass == 7) {
//        $j = strip_tags(file_get_contents($wifiget."9"));
 //           print $j;
        }
        ++$pass;
    }
/* {
      "id": "pvlog",
      "name": "Photovolatik Energiemonitor",
      "class": "LogWatcher",
      "file": "/home/pi/sbfspot.log",
      "attributes": [
        {
          "name": "acout",
          "type": "number",
          "unit": "kW"
        },
        {
          "name": "actoday",
          "type": "number",
          "unit": "kWh"
        },
        {
          "name": "actotal",
          "type": "number",
          "unit": "kWh"
        },      
      ],
        "lines": [
        {
          "match": "\\s*Total Pac\\s*:\\s*([0-9]+\\.[0-9]+)kW",
          "acout": "$1"
        },
        {
          "match": "\\s*EToday\\s*:\\s*([0-9]+\\.[0-9]+)kWh",
          "actoday": "$1"
        },
        {
          "match": "\\s*ETotal\\s*:\\s*([0-9]+\\.[0-9]+)kWh",
          "actotal": "$1"
        }
     ]
 }, */  
?>
<p style="font-size:18px"></b>

</b></tr>
   </table>

  </form>


