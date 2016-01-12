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
      <th>Cloud</th>
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
    reset($devices);
    $firstKey = key($devices);              // get first element so we only print 'schedule' once
    foreach( $devices as $deviceName => $devicePin ) {
?>
     <th align="left"><?php print( $deviceName ) ?></th>
     <td><?php print( $devicePin[0] ) ?> </th>
<?
        $deviceStatus = exec( "/usr/local/bin/gpio read $devicePin[0]");
?>
     <td>
<?
        print( $deviceStatus ? "<font color='red'>On</font>" : "<font color='blue'>Off</font>" );
?>
     </td>
<?
        if ( $devices[$firstKey][0] == $devicePin[0]) {
?>
<td>
	 for
        <select name="<?php print($devicePin[0]) ?>-ScheduleConf" onChange="this.form.submit()">
            <option value="0" <?= $devicePin[2]==0 ? "selected":""?>>Schedule 1</option>
            <option value="1" <?= $devicePin[2]==1 ? "selected":""?>>Schedule 2</option>
            <option value="2" <?= $devicePin[2]==2 ? "selected":""?>>Schedule 3</option>
	        <option value="3" <?= $devicePin[2]==3 ? "selected":""?>>Schedule 4</option>
      </select>
     </td>
<?php   } else {
?>
<td></td>
<?php
 }
?>
    <td>
     <input type="text" size="4" maxlength="4" max="4000" name="<?php print( $devicePin[0] ) ?>-Power" value="<?        // set power target
         printf(isset ($devicePin[3 +($devicePin[2] * 10)]) ? $devicePin[3 +($devicePin[2] * 10)] : 0);?>" />
    </td><td>
     <input type="text" size="1" maxlength="1" max="3" name="<?php print( $devicePin[0] ) ?>-Auto" value="<?        // set Auto power mgmnt  priority
         printf( "%1d",isset ($devicePin[5+($devicePin[2] * 10)]) ? $devicePin[5+($devicePin[2] * 10)] : 0 );?>" />
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
      <input type="submit" name="<?php print( $devicePin[0] ) ?>-Config" value="Submit Config"/>
      <a href="">Cancel</a>
</td>
</tr>
   </table>
<p>
<?php
    require( 'emit-current-time.php' );
    $poweravailable = getSmaPower();
?>
    <h3>Solar Power Available : <? print $poweravailable."kWs" ?> </h3>
    Enter Power Reserve : <input type="text" size="4" maxlength="4" name="powerreserve" 
        value="<?php print(  $powerReserve ) ?>"/> Watts
<?  checkPowerTargets($poweravailable*1000); ?>
    <h3>Current Schedule : <? print ($devicePin[2]+1)?></h3>

  </form>

