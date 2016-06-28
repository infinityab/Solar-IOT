
  <meta http-equiv="refresh" content="30">
<p style="font-size:20px">
<?php /* print "<b>Current status: </b>"; */ ?>
  <form method="POST">
   <table class="status">
<?php
    $day = date("N");
?>
<tr> <td><font color='grey'><b> Appliance</td> <td><font color='grey'><b>Status</td> <td><b><font color='grey'>Auto</td>
     <td><font color='grey'><b>Pwr</td><td><font color='grey'><b>Manual </td><td><font color='grey'><b> Manual Time </td>
     <th><font color='grey'>Schedule 1</th>
     <th><font color='grey'>Schedule 2</th>
     <th><font color='grey'>Schedule 3</th>
     <th><font color='grey'>Schedule 4</th>
     <th><font color='grey'>Schedule 5</font></th>
<?php

    foreach( $devices as $deviceName => $devicePin ) {
      if ( $deviceName <> "Cntl Off-Peak") {       // we don't want to print Off-Peak its only used for graphics
        $deviceStatus = exec( "/usr/local/bin/gpio read $devicePin[0]");   //  runGpio( "read", $devicePin[0] );
?>
     <tr>
     <td><b><?php print( $deviceName ) ?></b></td>
     <td>
<?php
        print( $deviceStatus ? "<font color='red'>On</font>" : "<font color='blue'>Off</font>" );
?>
     </td><td>
<?
        if (!$devicePin[1]){  print "<font color='blue'>Off</font>"; } else
        print "<b><font color='purple'>".$devicePin[1]."</font>";        // Auto Power priority
?>
     </td><td>
<?
        print $devicePin[3];        // power requirement
?>
    </td><td>
      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="<?php print( $deviceStatus ? "Turn off" : "Turn on" ) ?>"/>
     </td>
     <td>
<?php
    if    ( !$deviceStatus ) {
?>
      for
      <select name="<?php print( $deviceName ) ?>Duration">
       <option value="0" selected="selected">Manual</option>
       <option value="1">1 min</option>
       <option value="5">5 min</option>
       <option value="15">15 min</option>
       <option value="30">30 min</option>
       <option value="60">1 hour</option>
       <option value="120">2 hours</option>
       <option value="240">4 hours</option>
       <option value="600">6 hours</option>
       <option value="480">8 hours</option>
      </select>
<?php
        }
?></td><?
     $offset = 0;
     foreach( $schedules as $scheduleNums => $scheduleKey ) {
        $offset++;
?><td><?php
        foreach( $scheduleKey as $deviceNames => $devicePins ) {
         if( $deviceName == $deviceNames ) {
           if( $devicePins[2] != 0 ) {
               if ($devicePin[5+$day+(($offset-1)*10)] && !$devicePin[4]) {
                    print "<font color='blue'>";
                    }
                        else
                    {
                    print "<font color='black'>";
                    }
                printf( "%02d:%02d for %02d:%02d",
                $devicePins[3],
                $devicePins[4],
                $devicePins[5],
                $devicePins[6]);
                print "</font>";
            } else {
                print "<font color='black'>";
                print "not scheduled";
                print "</font>";
            }
?>
</td>
<?php
      }
  }
}
?>
    </tr>
<?php
  }
}
?>
   </table>
  </form>
