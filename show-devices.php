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
}, 30000);
</script>

<h2>Current Devices:</h2>

  <form method="POST">
   <table class="status">
    <tr>
      <th align="left">Name</th>
      <th>Pin</th>
      <th>Status</th>
      <th>Schedule Num</th>
      <th>Power<br>Target</th>
      <th>Auto</th>
      <th>Susp</th>
      <th>Light</th>
      <th>Mon</th>
      <th>Tue</th>
      <th>Wed</th>
      <th>Thu</th>
      <th>Fri</th>
      <th>Sat</th>
      <th>Sun</th>
   </tr>
<tr>
<?php
    $j = strip_tags(file_get_contents($wifiget."4"));    //  eg 192.168.x.x/gpio/0" defined in config from meter server
//    $res=checkPowerTargets($j); // check for power changes and action
    reset($devices);
    $firstKey = key($devices);              // get first element so we only print 'schedule' once
    foreach( $devices as $deviceName => $devicePin ) {
?>   <th align="left"><?php print( $deviceName ) ?></th>
     <td><?php print( $devicePin[0] )?></th><?
     $deviceStatus = exec( "/usr/local/bin/gpio read $devicePin[0]");?><td><?
     print( $deviceStatus ? "<font color='red'>On</font>" : "<font color='blue'>Off</font>" );?></td><?
     if ( $devices[$firstKey][0] == $devicePin[0]) {  ?>
<td>
	 for
        <select name="<?php print($devicePin[0]) ?>-ScheduleConf" onChange="this.form.submit()">
            <option value="0" <?= $devicePin[2]==0 ? "selected":""?>>Schedule 1</option>
            <option value="1" <?= $devicePin[2]==1 ? "selected":""?>>Schedule 2</option>
            <option value="2" <?= $devicePin[2]==2 ? "selected":""?>>Schedule 3</option>
	        <option value="3" <?= $devicePin[2]==3 ? "selected":""?>>Schedule 4</option>
      </select>
     </td>
<?php
   } else {
?><td></td><?
 }
?>
    <td>
     <input type="text" size="4" maxlength="4" max="4000" name="<?php print( $devicePin[0] ) ?>-Power" value="<?        // set power target
          printf(isset ($devicePin[3]) ? $devicePin[3] : 0);?>" />
<!-- printf(isset ($devicePin[3 +($devicePin[2] * 10)]) ? $devicePin[3 +($devicePin[2] * 10)] : 0);?>"/> for multi-power targets -->
    </td><td>
     <input type="text" size="1" maxlength="1" max="3" name="<?php print( $devicePin[0] ) ?>-Auto" value="<?        // set Auto power mgmnt  priority
     printf( "%1d",isset ($devicePin[5]) ? $devicePin[5] : 0 );?>"/>
<!-- printf( "%1d",isset ($devicePin[5+($devicePin[2] * 10)]) ? $devicePin[5+($devicePin[2] * 10)] : 0 );?>"/> for multi-Auto targets -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-Suspend" <?= $devicePin[4+($devicePin[2] * 10)]==1 ? "checked":""?> />
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-Cloud" <?= $devicePin[1]==1 ? "checked":""?> />
     </td><td>
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
     </td>
</tr>
<?php
}
?>
<tr>
 <td colspan="4">

</td><tr><tr><tr><td>

<!-- <input onkeyup="resetTimer = true"> -->
 <div id="status">
 </div>
<input type="submit" text="Submit" name="<?php print( $devicePin[0] ) ?>-Config" value="Submit Config"
     onclick="clearInterval(timer);document.getElementById('status').innerText = 'Submitted';"/>

<? /*      <input type="submit" name="<?php print( $devicePin[0] ) ?>-Config" value="Submit Config"/>*/ ?>      <a href="">Cancel</a>
</td>
</tr>
   </table>
<p>
<?php
    require( 'emit-current-time.php' );
    $poweravailable = getSmaPower();
//    $j = strip_tags(file_get_contents($wifigridpwr));    //  eg 192.168.x.x/gpio/0" defined in config from meter server
//    $res=checkPowerTargets($j);
?>
<table class="status">
    <td><h3><? print "Solar Surplus : ".$j." Watts".$res;?><td><td><td><td><h4>
       <? $j = strip_tags(file_get_contents($wifiget."6"));
            print $j;?></td><tr>
    <td><h3>Solar Power Available : <? print ($poweravailable*1000)." Watts" ?><td><td><td><td><h4>
       <? $j = strip_tags(file_get_contents($wifiget."7"));
          print $j;?></td><tr>
    <td><h3>Enter Power Lag : <input type="text" size="4" maxlength="4" name="powerreserve"
        value="<?php print(  $powerReserve ) ?>"/> Watts<td><td><td><td><h4>
        <?  $j = strip_tags(file_get_contents($wifiget."8"));
            print $j;?></h4></td>
</table>

<!---    <h3>Current Schedule : <? print ($devicePin[2]+1)?></h3> -->

 </form>

