
<?php
  startPhp();     // check for first start and reset all devices to OFF
  include_once( 'config.php' );
  include_once( 'config2.php' );
?>
<script>
resetTimer = false;
timer = setInterval(function() {
    if(!resetTimer) {
        document.getElementById('status').innerText = 'Refreshing';
        location.reload();
    }
    else {
        document.getElementById('status').innerText = 'Skip Refresh';
    }
    resetTimer = false;
},300000);
</script>
<?php
    $day = date("N");
    foreach( $schedules as $scheduleNums => $scheduleKey ) {  // populate Schedules
       foreach( $scheduleKey as $deviceNames => $devicePins ) {
       }
    }
    $schedule = readCrontab(); // read in active schedule
    $Schedule = checkSchedules( $schedule );  // check and bump schedules if necessary
    writeCrontab($Schedule);
?>
  <form method="POST">
   <table class="status">
    <tr>
      <th align="left"><font color='grey'>Appliances</th>
      <th align="left"><font color='grey'>Pin</th>
      <th><font color='grey'>Status</th>
      <th><font color='grey'>Scheduled For</th>
      <th><font color='grey'>Trigger</th>
      <th><font color='grey'>Power</th>
      <th><font color='grey'>Auto</th>
      <th><font color='grey'>Susp</th>
      <th align="left"><font color='grey'>Schedule <? print (($devices[$deviceNames][2])+1)?></th>
      <th><font color='grey'>Mon</th>
      <th><font color='grey'>Tue</th>
      <th><font color='grey'>Wed</th>
      <th><font color='grey'>Thu</th>
      <th align="left"><font color='grey'>Fri</th>
      <th align="left"><font color='grey'>Sat</th>
      <th align="left"><font color='grey'>Sun</th>
  </tr><tr>
<?php
    reset($devices);
    foreach( $devices as $deviceName => $devicePin ) {
    if ( $deviceName <> "Cntl Off-Peak") {       // we don't want to print Off-Peak its not a device
?>        <th align="left"><?php print( $deviceName ) ?></th>
        <td><?php print( $devicePin[0] )?></th><?
        $deviceStatus = exec( "/usr/local/bin/gpio read $devicePin[0]");?><td><?
        print( $deviceStatus ? "<font color='red'>On</font>" : "<font color='blue'>Off</font>" );?>
        </td><td>
<?
            if( isset( $schedule[$deviceName]['timeOn'] )) {
            printf( "%02d:%02d for %02d:%02d",
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
     <input type="text" size="4" maxlength="4" max="4000" name="<?php print( $devicePin[0] ) ?>-Trigger" value="<?        // set power target
          printf(isset ($devicePin[3]) ? $devicePin[3] : 0);?>" />
    </td><td>

     <input type="text" size="4" maxlength="4" max="4000" name="<?php print( $devicePin[0] ) ?>-Power" value="<?        // set power $
          printf(isset ($devicePin[5]) ? $devicePin[5] : 0);?>" />
    </td><td>
     <input type="text" size="1" maxlength="1" max="3" name="<?php print( $devicePin[0] ) ?>-Auto" value="<?        // set Auto power mgmnt  priority
     printf( "%1d",isset ($devicePin[1]) ? $devicePin[1] : 0 );?>"/>
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-Suspend" <?= $devicePin[4+($devicePin[2] * 10)]==1 ? "checked":""?> />
     </td><td>

<?php
           if( $schedules["Schedule-".($devicePin[2]+1)][$deviceName][2] != 0 ) {
               if ($devicePin[5+$day+($devicePin[2]*10)] && !$devicePin[4]) {
                    print "<font color='blue'>";
                    }
                        else
                    {
                    print "<font color='black'>";
                    }
                printf( "%02d:%02d for %02d:%02d",
                $schedules["Schedule-".($devicePin[2]+1)][$deviceName][3],
                $schedules["Schedule-".($devicePin[2]+1)][$deviceName][4],
                $schedules["Schedule-".($devicePin[2]+1)][$deviceName][5],
                $schedules["Schedule-".($devicePin[2]+1)][$deviceName][6]);
                print "</font>";
            } else {
                print "<font color='black'>";
                print "not scheduled";
                print "</font>";
           }
?></td><td>

	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowMon" <?= $devicePin[6+($devicePin[2] * 10)]==1? "checked":""?> />
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowTue" <?= $devicePin[7+($devicePin[2] * 10)]==1 ? "checked":""?> />
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowWed" <?= $devicePin[8+($devicePin[2] * 10)]==1 ? "checked":""?> />
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowThu" <?= $devicePin[9+($devicePin[2] * 10)]==1 ? "checked":""?> />
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowFri" <?= $devicePin[10+($devicePin[2] * 10)]==1 ? "checked":""?> />
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowSat" <?= $devicePin[11+($devicePin[2] * 10)]==1 ? "checked":""?> />
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowSun" <?= $devicePin[12+($devicePin[2] * 10)]==1 ? "checked":""?> />
     </td></tr>
<?
  }
}
?>
<tr>
 <td colspan="4">
</td><tr><tr><tr><td>

<!-- <input onkeyup="resetTimer = true"> -->
 <div id="status">
 </div>
<input type="submit" text="Submit" name="<?php print( $devicePin[0] ) ?>-Config" value="Submit Config"
     onclick="clearInterval(timer);document.getElementById('status').innerText = 'Submitted';"/><td><a href="">Cancel</a>

</td>
<td></td><td></td><td></td><td></td><td></td>
            <td>View</td>
            <td>
            <select name="<?php print($devicePin[0]) ?>-ScheduleConf" onChange="this.form.submit()">
            <option value="0" <?= $devicePin[2]==0 ? "selected":""?>>Schedule 1</option>
            <option value="1" <?= $devicePin[2]==1 ? "selected":""?>>Schedule 2</option>
            <option value="2" <?= $devicePin[2]==2 ? "selected":""?>>Schedule 3</option>
            <option value="3" <?= $devicePin[2]==3 ? "selected":""?>>Schedule 4</option>
            <option value="4" <?= $devicePin[2]==4 ? "selected":""?>>Schedule 5</option>
            </select>
        </td>
</tr>
    </table>
        <table class="status" width="100" border="0" align="left" cellpadding="0" cellspacing="0"; >
    </tr></table>
<p>

 <?  set_time_limit(10); ?>
    <script src="http://pvoutput.org/widget/inc.jsp"></script>

<table class="status">
 <?  set_time_limit(10); ?>
<td><script src="http://pvoutput.org/widget/graph.jsp?sid=40003&w=430&h=100&t=1&c=1"></script></td>
 <?  set_time_limit(10); ?>
<td><script src="http://pvoutput.org/widget/graph.jsp?sid=40003&t=1&e=1&w=430&h=100&consumption=1"></script></td>
 <?  set_time_limit(10); ?>
<td><script src="http://pvoutput.org/widget/outputs.jsp?sid=40003&h=100&barwidth=11&barspacing=2&c=2&n=1"></script> </td>
</table><p>

<table class="status" width="300" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-right:10px";>
 <?  set_time_limit(15); ?>
    <td><script src="http://pvoutput.org/portlet/r1/getstatus.jsp?sid=40003"></script></td>
</tr></table>

<table class="status" width="800" border="0" align="left" cellpadding="0" cellspacing="0"; >
<?php
        set_time_limit(6);
        $j = strip_tags(file_get_contents($wifiget."4"));  // get the solar export/import
        $poweravailable = getSmaPower();
?>

   <td><b><? print "Solar Surplus : ".$j." Watts".$res;?></b>
    <td><b>Auto On : <input type="text" size="2" maxlength="2" name="autoOn"
            value="<?php print(  $autoOn ) ?>"/> Start time</b>

<?/*      set_time_limit(6);
        $j = strip_tags(file_get_contents($wifigetw."6")); // weather station if used
        print "Temperature : ".$j; */ ?>
<td></td>
<tr>
    <td><b>Solar Power : <? print ($poweravailable*1000)." Watts" ?></b>
       <td><b>Auto Off : <input type="text" size="2" maxlength="2" name="autoOff"
            value="<?php print(  $autoOff ) ?>"/> Finish</b>

<!--    <b><? print 'Auto ignored outside of the above hours';?></b> -->
<?    /*  set_time_limit(6);
        $j = strip_tags(file_get_contents($wifigetw."7")); // barometric pressure
        print "Pressure : ".$j;  */ ?>
<td></td>
<tr>
    <td><b>Power Lag : <input type="text" size="4" maxlength="4" name="powerreserve"
            value="<?php print(  $powerReserve ) ?>"/> Watts</b>
    <td><b><?  print ('Auto Time : '.$autoOn.":00 to ".$autoOff.":00");?></b>

<? /*     set_time_limit(6);
        $j = strip_tags(file_get_contents($wifigetw."8"));   // humdity
        print "Humidity : ".$j; */  ?>
    </td>
       <tr><th align="left">
<?     print "Off-Peak    : ";
       $deviceStatus = exec( "/usr/local/bin/gpio read 7");
       print( $deviceStatus ? "<font color='red'>On</font>" : "<font color='blue'>Off</font>" ); ?>
       </td><td>
</tr></table><br><br><br><br>
</form>
<?
//  var_dump($GLOBALS);  // for debug
?>
