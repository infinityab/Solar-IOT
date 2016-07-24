<?php
  startPhp(); // check for first start and reset all devices to OFF
  include_once ('config.php');
  include_once ('config2.php');

//   $j = strip_tags(file_get_contents($wifiget."4"));   // use for testing, GET http data from meter
//   $a=checkPowerTargets($j);
//   var_dump($a);  // for debug
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
  },60000);
</script>
<?php
  $day = date("N");
  $timeNow = (date("H") * 60) + date("i");
  foreach($schedules as $scheduleNums => $scheduleKey) { // populate Schedules
    foreach($scheduleKey as $deviceNames => $devicePins) {
    }
  }
  $schedule = readCrontab(); // read in active schedule
  $Schedule = checkSchedules($schedule); // check and bump schedules if necessary
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
      <th align="left"><font color='grey'>Schedule <?php
        print (($devices[$deviceNames][2]) + 1) ?></th>
      <th><font color='grey'>Mon</th>
      <th><font color='grey'>Tue</th>
      <th><font color='grey'>Wed</th>
      <th><font color='grey'>Thu</th>
      <th align="left"><font color='grey'>Fri</th>
      <th align="left"><font color='grey'>Sat</th>
      <th align="left"><font color='grey'>Sun</th>
    </tr>
    <tr>
      <?php
        reset($devices);
        foreach($devices as $deviceName => $devicePin) {
            if ($deviceName <> "Cntl Off-Peak") { // we don't want to print Off-Peak its not a device
        ?>
      <th align="left"><?php
        print ($deviceName) ?></th>
      <td><?php
        print ($devicePin[0]) ?></th><?php
        $deviceStatus = exec("/usr/local/bin/gpio read $devicePin[0]"); ?>
      <td><?php
        print ($deviceStatus ? "<font color='red'>On</font>" : "<font color='blue'>Off</font>"); ?>
      </td>
      <td>
        <?php
          if (isset($schedule[$deviceName]['timeOn'])) {
            printf("%02d:%02d for %02d:%02d", $schedule[$deviceName]['timeOn']['hour'], $schedule[$deviceName]['timeOn']['min'], 
                $schedule[$deviceName]['duration']['hour'], $schedule[$deviceName]['duration']['min']);
          }
          else {
            print "not scheduled";
          }
          ?>
      </td>
      <td>
        <input type="text" size="4" maxlength="4" name="<?php
          print ($devicePin[0]) ?>-Trigger" value="<?php // set power target
          printf(isset($devicePin[3]) ? $devicePin[3] : 0); ?>" />
      </td>
      <td>
        <input type="text" size="4" maxlength="4" name="<?php
          print ($devicePin[0]) ?>-Power" value="<?php // set power $
          printf(isset($devicePin[5]) ? $devicePin[5] : 0); ?>" />
      </td>
      <td>
        <input type="text" size="1" maxlength="1" pattern="[0-9'A']{1}" name="<?php
          print ($devicePin[0]) ?>-Auto" value="<?php // set Auto power mgmnt  priority
          printf("%1s", isset($devicePin[1]) ? $devicePin[1] : 0); ?>"/>
      </td>
      <td>
        <input type="checkbox" name="<?php
          print ($devicePin[0]) ?>-Suspend" <?php echo $devicePin[4 + ($devicePin[2] * 10) ] == 1 ? "checked" : "" ?> />
      </td>
      <td>
        <?php
          if ($schedules["Schedule-" . ($devicePin[2] + 1) ][$deviceName][2] != 0) {
            if ($devicePin[5 + $day + ($devicePin[2] * 10) ] && !$devicePin[4]) {
                print "<font color='blue'>";
            }
            else {
                print "<font color='black'>";
            }
            printf("%02d:%02d for %02d:%02d",$schedules["Schedule-" . ($devicePin[2] + 1)][$deviceName][3],$schedules["Schedule-" . 
                ($devicePin[2] + 1) ][$deviceName][4], $schedules["Schedule-" . ($devicePin[2] + 1) ][$deviceName][5], 
                    $schedules["Schedule-" . ($devicePin[2] + 1) ][$deviceName][6]);
            print "</font>";
          }
          else {
            print "<font color='black'>";
            print "not scheduled";
            print "</font>";
          }
          ?>
      </td>
      <td>
        <input type="checkbox" name="<?php
          print ($devicePin[0]) ?>-DowMon" <?php echo $devicePin[6 + ($devicePin[2] * 10) ] == 1 ? "checked" : "" ?> />
      </td>
      <td>
        <input type="checkbox" name="<?php
          print ($devicePin[0]) ?>-DowTue" <?php echo $devicePin[7 + ($devicePin[2] * 10) ] == 1 ? "checked" : "" ?> />
      </td>
      <td>
        <input type="checkbox" name="<?php
          print ($devicePin[0]) ?>-DowWed" <?php echo $devicePin[8 + ($devicePin[2] * 10) ] == 1 ? "checked" : "" ?> />
      </td>
      <td>
        <input type="checkbox" name="<?php
          print ($devicePin[0]) ?>-DowThu" <?php echo $devicePin[9 + ($devicePin[2] * 10) ] == 1 ? "checked" : "" ?> />
      </td>
      <td>
        <input type="checkbox" name="<?php
          print ($devicePin[0]) ?>-DowFri" <?php echo $devicePin[10 + ($devicePin[2] * 10) ] == 1 ? "checked" : "" ?> />
      </td>
      <td>
        <input type="checkbox" name="<?php
          print ($devicePin[0]) ?>-DowSat" <?php echo $devicePin[11 + ($devicePin[2] * 10) ] == 1 ? "checked" : "" ?> />
      </td>
      <td>
        <input type="checkbox" name="<?php
          print ($devicePin[0]) ?>-DowSun" <?php echo $devicePin[12 + ($devicePin[2] * 10) ] == 1 ? "checked" : "" ?> />
      </td>
    </tr>
    <?php
      }
      }
      ?>
    <tr>
      <td colspan="4"></td>
    <tr>
    <tr>
    <tr>
      <td>
        <!-- <input onkeyup="resetTimer = true"> -->
        <div id="status">
        </div>
        <input type="submit" text="Submit" name="<?php
          print ($devicePin[0]) ?>-Config" value="Submit Config"
          onclick="clearInterval(timer);document.getElementById('status').innerText = 'Submitted';"/>
      <td><a href="">Cancel</a>
      </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>View</td>
      <td>
        <select name="<?php
          print ($devicePin[0]) ?>-ScheduleConf" onChange="this.form.submit()">
          <option value="0" <?php echo $devicePin[2] == 0 ? "selected" : "" ?>>Schedule 1</option>
          <option value="1" <?php echo $devicePin[2] == 1 ? "selected" : "" ?>>Schedule 2</option>
          <option value="2" <?php echo $devicePin[2] == 2 ? "selected" : "" ?>>Schedule 3</option>
          <option value="3" <?php echo $devicePin[2] == 3 ? "selected" : "" ?>>Schedule 4</option>
          <option value="4" <?php echo $devicePin[2] == 4 ? "selected" : "" ?>>Schedule 5</option>
        </select>
      </td>
    </tr>
  </table>
  <table class="status" width="100" border="0" align="left" cellpadding="0" cellspacing="0"; >
    </tr>
  </table>
  <p>

<?php   // test PVoutput first before grabbing graphs otherwise page will jam
    $url = 'http://pvoutput.org';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.4");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT,10);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

  if( $httpcode  == '200' ) { ?>

      <script src="http://pvoutput.org/widget/inc.jsp"></script>
  <table class="status">
    <td>
      <script src="http://pvoutput.org/widget/graph.jsp?sid=40003&w=430&h=100&t=1&c=1"></script>
    </td>
    <td>
      <script src="http://pvoutput.org/widget/graph.jsp?sid=40003&t=1&e=1&w=430&h=100&consumption=1"></script>
    </td>
    <td>
      <script src="http://pvoutput.org/widget/outputs.jsp?sid=40003&h=100&barwidth=11&barspacing=2&c=2&n=1"></script>
    </td>
  </table>
  <p>
  <table class="status" width="300" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-right:10px";>
    <td>
      <script src="http://pvoutput.org/portlet/r1/getstatus.jsp?sid=40003"></script>
    </td>
    </tr>
  </table>
<? } // ends conditional PVoutput test to prevent page jam
?>

  <table class="status" width="900" border="0" align="left" cellpadding="0" cellspacing="0"; >
      <?php
      set_time_limit(6);
      $j = strip_tags(file_get_contents($wifiget . "4")); // get the solar export/import
      $poweravailable = getSmaPower();
      ?>
    <td><b><?php
      print "Solar Surplus : " . $j . " Watts" . $res; ?></b>
    <td><b>Auto On &nbsp;&nbsp; : <input type="text" name="autoOnhr"
      value="<?php
        printf("%02d", $autoOnhr); ?>" size="2" maxlength="2"/>
      :  <input type="text" name="autoOnmin"
        value="<?php
          printf("%02d", $autoOnmin); ?>" size="2" maxlength="2"/> Start Time</b>
      <b>
    <td>
      <?php
        print ("<b>Auto Time : "); // check if in Auto Time range -1
        print (($timeNow > (($autoOnhr * 60) + $autoOnmin) && $timeNow < (($autoOffhr * 60) + $autoOffmin)) ? 
            "<font color='red'>is On</font>" : "<font color='blue'>is Off</font>");
        ?>
    <td></td>
    <tr>
      <td><b>Solar Power : <?php
        print ($poweravailable * 1000) . " Watts" ?></b>
      <td><b>Auto Off &nbsp; &nbsp;: <input type="text" name="autoOffhr"
        value="<?php
          printf("%02d", $autoOffhr); ?>" size="2" maxlength="2"/>
        :  <input type="text" name="autoOffmin"
          value="<?php
            printf("%02d", $autoOffmin); ?>" size="2" maxlength="2"/> Finish</b>
      <td></td>
    <tr>
      <td><b>Power Lag : <input type="text" size="4" maxlength="4" name="powerreserve"
        value="<?php
          print ($powerReserve) ?>"/> Watts</b>
      <td><b>HWS Auto : <input type="text" name="hwsautoOffhr"
        value="<?php
          printf("%02d", $hwsautoOffhr); ?>" size="2" maxlength="2"/>
        :  <input type="text" name="hwsautoOffmin"
          value="<?php
            printf("%02d", $hwsautoOffmin); ?>" size="2" maxlength="2"/>
               <?  print (($timeNow < (($hwsautoOffhr * 60) + $hwsautoOffmin) && $timeNow > (($autoOnhr * 60) + $autoOnmin)) ?
            "<font color='red'>is On</font>" : "<font color='blue'>is Off</font>");
                ?>
    <tr>
      <th align="left">
        <?php
          print "Off-Peak    : ";
          $deviceStatus = exec("/usr/local/bin/gpio read 7");
          print ($deviceStatus ? "<font color='red'>On</font>" : "<font color='blue'>Off</font>"); ?>
        </td>
    </tr>
  </table>
  <br /><br /><br /><br /><br />
</form>
<?php
//   $j = strip_tags(file_get_contents($wifiget."4"));   // GET http data from meter
//   $a=checkPowerTargets($j);
//   var_dump($devices);  // for debug
  ?>
