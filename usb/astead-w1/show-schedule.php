  <h2>Schedules :</h2>
<?php
require( 'emit-current-time.php' );
?>
  <form method="GET">
   <table class="schedule">
<?php
//    $scheduleB = readCrontab();
    $schedule = readCrontab();
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
     </td>
     <td>
      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="Change schedule" />
     </td>
     <td>
      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="+Bump" />
     </td>
     <td>
      <input type="submit" name="<?php print( $deviceName ) ?>Action" value="-Bump" />
     </td>

<!--  new schedule B added here ***  sorted yet  -->
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
</td>
<!--  ends schedule B -->

</tr>
<?php
    }
?>
   </table>
  </form>


