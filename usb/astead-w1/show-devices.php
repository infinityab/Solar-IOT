  <h2>Current Devices:</h2>

  <form method="POST">
   <table class="status">
    <tr>
       <td>Name</td>
       <td>Pin</td>
       <td>Exclusive</td>
       <td>Day </td>
       <td>Wind )</td>
    </tr>
<?php
    foreach( $devices as $deviceName => $devicePin ) {
?>  
    <tr>
     <th align="left"><?php print( $deviceName ) ?></th>
     <td><?php print( $devicePin[0] ) ?></td>
     <td>
	<?php print( $devicePin[1] ) ?>
     </td>
    <td>
	<select name="<?php print($devicePin[0]) ?>-Interval" onChange="this.form.submit()">
	       <option value="1" <?= $devicePin[2]==1 ? "selected":""?>>Every day</option>
	       <option value="2" <?= $devicePin[2]==2 ? "selected":""?>>Every other day</option>
	       <option value="3" <?= $devicePin[2]==3 ? "selected":""?>>Every 3rd day</option>
	       <option value="4" <?= $devicePin[2]==4 ? "selected":""?>>Every 4th day</option>
	       <option value="5" <?= $devicePin[2]==5 ? "selected":""?>>Every 5th day</option>
	       <option value="6" <?= $devicePin[2]==6 ? "selected":""?>>Every 6th day</option>
	       <option value="7" <?= $devicePin[2]==7 ? "selected":""?>>Every 7th day</option>
	       <option value="8" <?= $devicePin[2]==8 ? "selected":""?>>Every 8th day</option>
	       <option value="9" <?= $devicePin[2]==9 ? "selected":""?>>Every 9th day</option>
	       <option value="10" <?= $devicePin[2]==10 ? "selected":""?>>Every 10th day</option>
	       <option value="15" <?= $devicePin[2]==15 ? "selected":""?>>Every 15th day</option>
	       <option value="20" <?= $devicePin[2]==20 ? "selected":""?>>Every 20th day</option>
      </select>
     </td>
     <td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-Suspend" <?= $devicePin[4]==1 ? "checked":""?> onclick="this.form.submit()"/>Suspend
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-Cloud" <?= $devicePin[5]==1 ? "checked":""?> onclick="this.form.submit()"/>Cloud
</td><td>
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowMon" <?= $devicePin[6]==1? "checked":""?> onclick="this.form.submit()"/>Mon
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowTue" <?= $devicePin[7]==1 ? "checked":""?> onclick="this.form.submit()"/>Tue
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowWed" <?= $devicePin[8]==1 ? "checked":""?> onclick="this.form.submit()"/>Wed
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowThu" <?= $devicePin[9]==1 ? "checked":""?> onclick="this.form.submit()"/>Thu
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowFri" <?= $devicePin[10]==1 ? "checked":""?> onclick="this.form.submit()"/>Fri
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowSat" <?= $devicePin[11]==1 ? "checked":""?> onclick="this.form.submit()"/>Sat
	<input type="checkbox" name="<?php print($devicePin[0]) ?>-DowSun" <?= $devicePin[12]==1 ? "checked":""?> onclick="this.form.submit()"/>Sun
	</td>
 	<td>
        <input type="checkbox" name="<?php print($devicePin[0]) ?>-Wind" <?= $devicePin[3]==1 ? "checked":""?> onclick="this.form.submit()"/>Wind
     </td>
   </tr>
<?php
    }
?>
<tr>
 <td colspan="4">
<?php
 /*
  $filename = "weather_data.json";
  $data = file_get_contents($filename);
  $parsed_json = json_decode($data);

  $date_captured = $parsed_json->{'current_observation'}->{'observation_epoch'};
  if ((time() - (60*60*24)) > $date_captured) {
    $json_string = file_get_contents(
	"http://api.wunderground.com/api/".
	$wunderground_key."/geolookup/conditions/q/".
	$wunderground_location.".json");
    file_put_contents('/tmp/weather_data.json', $json_string);
    $parsed_json = json_decode($json_string);
  }

  $location = $parsed_json->{'location'}->{'city'};
  $temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
  $relative_humidity = $parsed_json->{'current_observation'}->{'relative_humidity'};
  $wind_mph = $parsed_json->{'current_observation'}->{'wind_mph'};
  $precip_today_in = $parsed_json->{'current_observation'}->{'precip_today_in'};

  echo "Temperature: ${temp_f}&deg;F<br/>";
  echo "Humidity: ${relative_humidity}<br/>";
  echo "Wind: ${wind_mph} mph<br/>";
  echo "Precipitation: ${precip_today_in} in<br/>";
*/
?>
</td>
</tr>
   </table>
<?php
require( 'emit-current-time.php' );
?>
  </form>
