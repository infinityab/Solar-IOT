
<?php
  startPhp();     // check for first start
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

<!-- <h2>Current Devices:</h2> -->

  <form method="POST">
   <table class="status">
    <tr>
      <th align="left"><font color='grey'>Appliances</th>
      <th><font color='grey'>Pin</th>
      <th><font color='grey'>Status</th>
      <th><font color='grey'>Schedule Num</th>
      <th><font color='grey'>Power</th>
      <th><font color='grey'>Auto</th>
      <th><font color='grey'>Susp</th>
<!--  <th><font color='grey'>Light</th> -->
      <th><font color='grey'>Mon</th>
      <th><font color='grey'>Tue</th>
      <th><font color='grey'>Wed</th>
      <th><font color='grey'>Thu</th>
      <th><font color='grey'>Fri</th>
      <th><font color='grey'>Sat</th>
      <th><font color='grey'>Sun</th>
   </tr>
<tr>
<?php
//    exec('curl -d "d=20160321" -d "t=19:05" -d "v4=110" -d "v5=21.3" -H "X-Pvoutput-Apikey: b48740f4f30a7be6b44ca821f75554b2c28eea37" -H "X-Pvoutput-SystemId: 40003" "http://pvoutput.org/service/r2/addstatus.jsp" -0',$result);
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
<!-- input type="checkbox" name="<?php print($devicePin[0]) ?>-Cloud" <?= $devicePin[1]==1 ? "checked":""?> />
     </td><td> -->
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

<? /* <input type="submit" name="<?php print( $devicePin[0] ) ?>-Config" value="Submit Config"/>*/ ?> <a href="">Cancel</a>
</td>
</tr>
   </table>
<p>
<script src="http://pvoutput.org/widget/inc.jsp"></script>

<table class="status">
<td><script src="http://pvoutput.org/widget/graph.jsp?sid=40003&w=400&h=100&t=1&c=1"></script></td>
<td><script src="http://pvoutput.org/widget/graph.jsp?sid=40003&w=400&h=100&t=1&consumption=1&e=1"></script></td>
<td><script src="http://pvoutput.org/widget/outputs.jsp?sid=40003&h=100&barwidth=10&barspacing=2&c=2&n=1"></script> </td>
<tr>

</tr></table><p> <!-- <table class="status"> -->
<!-- <div style="width:1110px;" --> <!-- height:auto;position:relative;"> -->

<table class="status" width="300" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-right:10px";>
<td><script src="http://pvoutput.org/portlet/r1/getstatus.jsp?sid=40003"></script></td>
</tr></table>

<table class="status" width="800" border="0" align="left" cellpadding="0" cellspacing="0"; >
<?php
  $poweravailable = getSmaPower();
  //    $j = strip_tags(file_get_contents($wifigridpwr));    //  eg 192.168.x.x/gpio/0" defined in config from meter server
  //    $res=checkPowerTargets($j);
?>
   <td><b><? print "Solar Surplus : ".$j." Watts".$res;?></b><td>
       <? $j = strip_tags(file_get_contents($wifigetw."6")); // temperature
          print "Temperature ".$j; ?>
<td></td>
<tr>
    <td><b>Solar Power : <? print ($poweravailable*1000)." Watts" ?></b><td>
       <? $j = strip_tags(file_get_contents($wifigetw."7")); // barometric pressure
          print "Pressure ".$j;  ?>
<td></td>
<tr>
    <td><b>Power Lag : <input type="text" size="4" maxlength="4" name="powerreserve"
        value="<?php print(  $powerReserve ) ?>"/> Watts</b><td>
        <?  $j = strip_tags(file_get_contents($wifigetw."8"));   // humdity
            print "Humidity ".$j;  ?>
    </td>
</tr></table><br><br><br><br>
</form>
 <? // var_dump($GLOBALS);  // for debug
 ?>
