  <h2>Current Devices:</h2>

  <form method="POST">
   <table class="status">
    <tr>
      <th align="left">Name</th>
      <th>Pin</th>
      <th>Schedule Num</th>
      <th>Exclusive</th>
      <th>Suspend</th>
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
     <td><?php print( $devicePin[0] ) ?></td>
<?php
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
        <input type="checkbox" name="<?php print($devicePin[0]) ?>-Exclude" <?= $devicePin[1]==1 ? "checked":""?> onclick="this.form.submit()">
     </td>
<td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-Suspend" <?= $devicePin[4+($devicePin[2] * 10)]==1 ? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-Cloud" <?= $devicePin[5+($devicePin[2] * 10)]==1 ? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowMon" <?= $devicePin[6+($devicePin[2] * 10)]==1? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowTue" <?= $devicePin[7+($devicePin[2] * 10)]==1 ? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowWed" <?= $devicePin[8+($devicePin[2] * 10)]==1 ? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowThu" <?= $devicePin[9+($devicePin[2] * 10)]==1 ? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowFri" <?= $devicePin[10+($devicePin[2] * 10)]==1 ? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowSat" <?= $devicePin[11+($devicePin[2] * 10)]==1 ? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowSun" <?= $devicePin[12+($devicePin[2] * 10)]==1 ? "checked":""?> /> <!-- onclick="this.form.submit()"/> -->
     </td>
</tr>
<?php
}
?>
<tr>
 <td colspan="4">

</td><tr><tr><tr><td>
      <input type="submit" name="<?php print( $devicePin[0] ) ?>-Config" value="Submit Config" />
</td>
</tr>
   </table>
<?php
require( 'emit-current-time.php' );
?>
  </form>

