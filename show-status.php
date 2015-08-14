  <meta http-equiv="refresh" content="10" >
  <h2>Current status:</h2>
  <form method="POST">
   <table class="status">

<tr> <td> </td> <td> </td> <td> </td> <td> </td>
     <th>Schedule 1</th>
     <th>Schedule 2</th>
     <th>Schedule 3</th>
     <th>Schedule 4</th>
<?php

    foreach( $devices as $deviceName => $devicePin ) {
        $deviceStatus = runGpio( "read", $devicePin[0] );
?>
     <tr>
     <th><?php print( $deviceName ) ?> is:</th>
     <td>
<?php
        print( $deviceStatus ? "on" : "off" );
?>
     </td>
     <td>
      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="<?php print( $deviceStatus ? "Turn off" : "Turn on" ) ?>"/>
     </td>
     <td>
<?php
    if    ( !$deviceStatus ) {
?>
      for
      <select name="<?php print( $deviceName ) ?>Duration">
       <option value="0">Until I turn it off</option>
       <option value="5">5 min</option>
       <option value="15">15 min</option>
       <option value="30">30 min</option>
       <option value="60" selected="selected">1 hour</option>
       <option value="120">2 hours</option>
       <option value="240">4 hours</option>
       <option value="480">8 hours</option>
      </select>
<?php
        }
?>
     </td>

<?php
     foreach( $schedules as $scheduleNums => $scheduleKey ) {
?><td><?php
        foreach( $scheduleKey as $deviceNames => $devicePins ) {
         if( $deviceName == $deviceNames ) {
           if( $devicePins[2] != 0 ) {
              printf( "%02d:%02d:00 for %02d:%02d:00",
                $devicePins[3],
                $devicePins[4],
                $devicePins[5],
                $devicePins[6]);
        } else {
            print "not scheduled";
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
?>
   </table>
  </form>
