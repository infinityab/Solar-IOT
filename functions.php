

<?php

function startPhp()
{
    if (!file_exists('/tmp/startup')) { // check if first run
        touch('/tmp/startup');
        require ('config.php');

        foreach($devices as $deviceName => $devicePin) {
            exec("/usr/local/bin/gpio mode $devicePin[0] out"); // set up gpio pins
            usleep(200000);
        }
        exec("/usr/local/bin/gpio mode 7 out"); // set up gpio pin for off-peak reading
        exec("/usr/local/bin/gpio mode 2 in"); // set up gpio input pins
    }
}

function wifiCheck($pin, $onoff)
{
    global $wifi1, $wifi2, $wifi3, $wifi4;

    $wdelay = 30; // ms delay inbetween identical wireless transmissions
    include ('config.php');

    if ($pin == $wifi1[0]) { // is it a  wifi appliance
        set_time_limit(3); //        $json_string =    // use if reading return html code string
        file_get_contents($wifi1[1] . "2/0"); // downstairs Aircon
        file_get_contents($wifi3[1].$onoff);   // summer only start and stop external fan for aircon boost
        logEvent($wifi3[0], $onoff);   /// 3 = wireless 1 from main transmitter
    }
    elseif ($pin == $wifi2[0]) { // is it a wifi appliance
        set_time_limit(3);
        file_get_contents($wifi2[1] . "2/0"); // upstairs Aircon
        $json_string = file_get_contents($wifi4[1].$onoff);   // to start and stop external fan for aircon boost
        logEvent($wifi4[0], $onoff);  // was 7 not 4 - same above, 4 = wireless 2
    }
    elseif ($pin == $wifi3[0]) { // wireless socket #1 only transmit 2 times
        for ($wret = 1; $wret <= 2; ++$wret) {
            set_time_limit(3);
            file_get_contents($wifi3[1] . $onoff); // downstairs wireless relay point
            set_time_limit(3);
            file_get_contents($wifi6[1] . $onoff); // upstairs wireless relay point
            //        set_time_limit(3);
            //        file_get_contents($wifi9[1].$onoff);  // meter box wireless relay point
        }
    }
    elseif ($pin == $wifi4[0]) { // wireless socket #2 only transmit 2 times
        for ($wret = 1; $wret <= 2; ++$wret) {
            set_time_limit(3);
            file_get_contents($wifi4[1] . $onoff);
            set_time_limit(3);
            file_get_contents($wifi7[1] . $onoff);
            //        set_time_limit(3);
            //        file_get_contents($wifi10[1].$onoff);  // meter box wireless relay point
        }
    }
    elseif ($pin == $wifi5[0]) { // wireless socket #3 only transmit 2 times
        for ($wret = 1; $wret <= 2; ++$wret) {
            set_time_limit(3);
            file_get_contents($wifi5[1] . $onoff);
            set_time_limit(3);
            file_get_contents($wifi8[1] . $onoff);
            //        set_time_limit(3);
            //        file_get_contents($wifi11[1].$onoff);  // meter box wireless relay point
            // **    } elseif ( $pin == $wifi6[0]) {   // ALL wireless sockets ON or OFF
            // **        $json_string = file_get_contents($wifi4[1].$onoff);
        }
    }
    return;
}

function microtime_float()
{
    //  $start = microtime_float();       // example
    //  while (microtime_float() <= $start + 0.75) {}  // delay
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function setserial($speed)
{
    global $serial;

    if (!isset($_SESSION['first_run'])) { // run once to set up serial port
        $_SESSION['first_run'] = 1;
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        include 'php_serial.class.php';

        $serial = new PhpSerial; // set the class
        $serial->deviceClose();
        $serial->deviceSet("/dev/ttyAMA0");
        $serial->confBaudRate($speed);
        $serial->confParity("none");
        $serial->confCharacterLength(8);
        $serial->confStopBits(1);
        $serial->confFlowControl("none");
    }
    return;
}

function logEvent($pin, $event)
{
    global $logFile;

    if (isset($logFile)) {
        $fh = @fopen($logFile, "a");
        if (isset($fh)) {
            fprintf($fh, "%s\t%s\t%s\n", strftime("%Y-%m-%d %H:%M:%S") , $pin, $event);
            fclose($fh);
        }
    }
}

function arrayCopy(array $array)
{
    $result = array();
    foreach($array as $key => $val) { // used in testing - makes a copy of an existing array
        if (is_array($val)) {
            $result[$key] = arrayCopy($val);
        }
        elseif (is_object($val)) {
            $result[$key] = clone $val;
        }
        else {
            $result[$key] = $val;
        }
    }
    return $result;
}

function getSmaPower()
{
    global $powerNow;

    $source = "/home/pi/sbfspot.log"; // get the current solar power available
    $handle = fopen($source, 'r');
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            if (substr($line, 1, 5) == 'Total') {
                $powerNow = substr($line, 15, -3); // strip out the bits we don't want
                break;
            }
        }
    }
    else {
        // error opening the file.
    }
    fclose($handle);
    if (!$powerNow) { // try one more time
        $handle = fopen($source, 'r');
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (substr($line, 1, 5) == 'Total') {
                    $powerNow = substr($line, 15, -3);
                    break;
                }
            }
        }
        else {
            // error opening the file.
        }
        fclose($handle);
    }
    return $powerNow;
}

function checkPowerTargets($currentpower)
{
    global $devices, $schedules;
    include ('config.php');
    include ('config2.php');

    $timeNow = (date("H") * 60) + date("i"); // get the current time in minutes
    $a = $currentpower . " ";
    if (($timeNow > (($autoOnhr * 60) + $autoOnmin)) && ($timeNow <= (($autoOffhr * 60) + $autoOffmin))) { // in Auto Time Range?
        if ($timeNow >= (($autoOffhr * 60) + $autoOffmin - 3)) $currentpower = - 5000; // if NOT Auto Time-3 switch OFF all auto devs
        $ss = count($schedules);
        $prioritylog = array(); // auto devices log reset
        $devicelog = array(); // normal devices log reset
        $totp = 0;
        $totd = 0;
        $sp = "* * *";
        foreach($devices as $deviceName => $devicePin) { // first calculate power wattage left
            $status = NULL;
            $out = NULL;
            $pin = $devicePin[0];
            exec("/usr/local/bin/gpio read $pin", $out, $status); // check whether device active and NOT auto
             // Auto 1 reserved for HWS, when HWS Auto OFF time-3mins reached HWS Auto mode is OFF (3mins should match crontab chk)
            if ($out[0] && ($devicePin[1] == 1 && ($timeNow >= (($hwsautoOffhr*60)+$hwsautoOffmin-3) &&
                    $timeNow <= (($hwsautoOffhr*60)+$hwsautoOffmin)) ) )  {
                exec("/usr/local/bin/gpio write $pin 0"); // switch off HWS, times up
                logEvent($pin, "0");
            }       // build Non-Auto devices than are ON list

            if ($out[0] && (!$devicePin[1] || ($devicePin[1] == 1 && $timeNow > (($hwsautoOffhr*60)+$hwsautoOffmin)))) {
                for ($x = 1; $x <= $ss; ++$x) {
                    $timenowps = (($schedules["Schedule-" . $x][$deviceName][3]) * 60) + $schedules["Schedule-" . $x][$deviceName][4]; //start time of schedule
                    $timenowpe = $timenowps + (($schedules["Schedule-" . $x][$deviceName][5]) * 60) + $schedules["Schedule-" . $x][$deviceName][6]; // end time of schedule
                    if (($timenowps <= $timeNow && $timeNow <= $timenowpe) && $devices[$deviceName][5 + (date("N")) + (($x - 1) * 10) ] && !$devices[$deviceName][4 + (($x - 1) * 10) ]) { // within time now, indexed DOW and NOT suspend
                        $devicelog[$totd][0] = $devicePin[0]; // Device Wiring Pin number
                        ++$totd;
                        break;
                    }
                }
            }       // Auto 1 is reserved for water heater so if HWS Auto OFF time is reached HWS goes into timer mode
            elseif ($devicePin[1]  && !($devicePin[1] == 1 && $timeNow >= (($hwsautoOffhr*60)+$hwsautoOffmin-3))) {
                for ($x = 1; $x <= $ss; ++$x) {  // Auto - scan for active time slot and build priority auto list
                    $timenowps = (($schedules["Schedule-" . $x][$deviceName][3]) * 60) + $schedules["Schedule-" . $x][$deviceName][4]; //start time of schedule
                    $timenowpe = $timenowps + (($schedules["Schedule-" . $x][$deviceName][5]) * 60) + $schedules["Schedule-" . $x][$deviceName][6]; // end time of schedule
                    if (($timenowps <= $timeNow && $timeNow <= $timenowpe) && $devices[$deviceName][5 + (date("N")) + (($x - 1) * 10) ] && !$devices[$deviceName][4 + (($x - 1) * 10) ]) { // within time now, indexed DOW and suspend
                        $prioritylog[$totp][0] = $devicePin[1]; // Priority setting
                        $prioritylog[$totp][1] = $devicePin[3]; // trigger requirement 1st position only NOT indexed
                        $prioritylog[$totp][2] = $devicePin[0]; // Pin Number
                        $prioritylog[$totp][3] = $devicePin[5]; // power requirement 1st position only NOT indexed
                        ++$totp;
                        break;
                    }
                }
            }
        }
        $y = count($prioritylog);
        if ($y) {
            for ($x = 0; $x < $y; ++$x) { // scan through priorities than are ON and add to currentpower
                $pin = $prioritylog[$x][2];
                if (exec("/usr/local/bin/gpio read $pin")) {
                    $currentpower+= $prioritylog[$x][3]; // power requirement
                    $prioritylog[$x][4] = 1;
                }
                else {
                    $prioritylog[$x][4] = 0; // set ON or OFF bit
                }
            }
        }
        $c = $currentpower . " ";

        // ********* nothing has been switched ON or OFF at this stage ***************************

        if (!count($prioritylog)) return (" No Active Priority set"); // no priority set
        sort($prioritylog); // reorder priorities with highest first
        $y = count($prioritylog);
        if ($y) {
            for ($x = 0; $x < $y; ++$x) { // scan  Auto to see if any appliance can be switched on
                $pin = $prioritylog[$x][2];
                if (!$prioritylog[$x][4]) { // device is OFF
                    if ($currentpower - $prioritylog[$x][1] >= 0) {
                        $currentpower-= $prioritylog[$x][3];
                        $devcount = count($devicelog); // sufficient power so add to device ON list
                        $devicelog[$devcount][0] = $prioritylog[$x][2]; // pin# update $device list with Auto device
                        //                    $devicelog[$devcount][1] = $prioritylog[$x][1];     // pwr
                        exec("/usr/local/bin/gpio write $pin 1"); // switch on device surplus power available
                        wifiCheck($pin, 1);
                        logEvent($pin, "1");
                    }
                }
                else {
                    if ($currentpower + $powerReserve - $prioritylog[$x][3] < 0) { // include Lag/hysteresis to switch off
                        exec("/usr/local/bin/gpio write $pin 0"); // switch off device not enough power
                        wifiCheck($pin, 0); // pulse the aircon off - power is already added in so don't deduct
                        logEvent($pin, "0");
                    }
                    else {
                        $currentpower-= $prioritylog[$x][3]; // staying ON - remove the device power from power pool
                        $devcount = count($devicelog); // device still has enough power so add to device ON list
                        $devicelog[$devcount][0] = $prioritylog[$x][2]; // pin# update $device list withAuto device
                        //                    $devicelog[$devcount][1] = $prioritylog[$x][1];     // pwr - priority required to trigger logevent
                    }
                }
            }
        }
        $d = $currentpower . " ";
        $y = count($devicelog); // all devices on lists have passed suspend, time and day tests
        foreach($devices as $deviceName => $devicePin) { // therefore now scan for devices that are not required
            $deviceOn = 0;
            $pin = $devicePin[0];
            if ($y) {
                for ($x = 0; $x < $y; ++$x) {
                    if ($devicePin[0] == $devicelog[$x][0]) $deviceOn = 1; // check if in device ON list
                }
            }
            if (!$deviceOn) {
                if ($devicePin[1]) { // ONLY check Auto - priority device others may be Manual start
                    if (exec("/usr/local/bin/gpio read $pin")) {
                        exec("/usr/local/bin/gpio write $pin 0"); // switch OFF device
                        wifiCheck($devicePin[0], 0); // pulse the aircon switch
                        logEvent($devicePin[0], "0");
                    }
                }
            }
        }
    }
    // $k = " cr".$b."crp".$c."rm".$d;  // test 
    // return $a;  // return value is fdr testing
    return "1";  // just a dummy value
}

function checkSchedules(array $nextSchedule)
{
    global $schedules, $devices;

    // this function can be called in 3 ways - from - a manual entry to a schedule, cron-run when timer-On or timer-Off,
    // or from zero hour generated by the auto refresh function on the home page but the timer must be on the home page,
    // the scheduler relies on these 3 methods to bump the schedules along although the midnight rollover is an added  bonus.
    // ini_set('display_errors', 'On');  // uncomment for error reporting
    // error_reporting(E_ALL | E_STRICT);
    include ('config2.php');

    include ('config.php');

    $timeNow = (date("H") * 60) + date("i");
    $lastSched = True;
    $sch = 0;
    $datenow = date("N");
    foreach($schedules as $scheduleNums => $scheduleKey) { // nextSchedule holds the current crontab...
        $offset = $sch * 10;
        $sch++;
        foreach($scheduleKey as $deviceNames => $devicePins) {
            $on = false;
            $runOn = $devicePins[2]; // the runOn bit is set to the schedule to indicate Run Regularly
            if ($devices[$deviceNames][$datenow + 5 + $offset] && !$devices[$deviceNames][4 + $offset]) $on = true;
            if (isset($nextSchedule[$deviceNames]['timeOn']) && $runOn) { // check crontab exists, DayOfWeek and Suspend
                $schedTime = ($devicePins[3] * 60) + $devicePins[4]; // get schedule times in minutes
                $nextSched = ($nextSchedule[$deviceNames]['timeOn']['hour'] * 60) + $nextSchedule[$deviceNames]['timeOn']['min'];
                    // schedTime is taken from config file nextSched is from crontab
                if (($schedTime >= $timeNow && $on) || $nextSched >= $timeNow || exec("/usr/local/bin/gpio read $devicePins[0]"))
                     $lastSched = False; // still some schedules left       // vvv look for best time vvv
                if (($schedTime >= $timeNow && $on) && (($schedTime <= $nextSched && $on) || ($nextSched < $timeNow))) {
                    if (!exec("/usr/local/bin/gpio read $devicePins[0]")) { // status check is slow so put here - is device running?
                        $nextSchedule[$deviceNames]['timeOn']['hour'] = strval($devicePins[3]);
                        $nextSchedule[$deviceNames]['timeOn']['min'] = strval($devicePins[4]);
                        $nextSchedule[$deviceNames]['duration']['hour'] = $devicePins[5];
                        $nextSchedule[$deviceNames]['duration']['min'] = $devicePins[6];
                    }
                }
            }
        }
    }
    if ($lastSched) { // no schedules left so bump all schedules for the next day
        $sch = 0;
        $timeNow = 0;
        $day = $datenow + 1; // increment and correct the day
        if ($day == 8) $day = 1;
        foreach($devices as $deviceName => $devicePin) { // add a phantom schedule to ensure proper calculation
            $nextSchedule[$deviceName]['timeOn']['hour'] = "23";
            $nextSchedule[$deviceName]['timeOn']['min'] = "58";
            $nextSchedule[$deviceName]['duration']['hour'] = 0;
            $nextSchedule[$deviceName]['duration']['min'] = 1;
        }
        foreach($schedules as $scheduleNums => $scheduleKey) {
            $offset = $sch * 10;
            $sch++;
            foreach($scheduleKey as $deviceNames => $devicePins) {
                $on = false;
                $runOn = $devicePins[2]; // the runOn bit is set to the schedule to indicate Run Regularly
                if ($devices[$deviceNames][5 + $day + $offset] && !$devices[$deviceNames][4 + $offset]) $on = true;
                if (isset($nextSchedule[$deviceNames]['timeOn']) && $runOn) { // check crontab exists, DayOfWeek and Suspend
                    $schedTime = ($devicePins[3] * 60) + $devicePins[4]; // get schedule times in minutes
                    $nextSched = ($nextSchedule[$deviceNames]['timeOn']['hour'] * 60) + $nextSchedule[$deviceNames]['timeOn']['min'];
                    if (($schedTime > $timeNow && $on) && ($schedTime < $nextSched && $on)) {
                        if (!exec("/usr/local/bin/gpio read $devicePins[0]")) { // status check is slow so put here
                            $nextSchedule[$deviceNames]['timeOn']['hour'] = strval($devicePins[3]);
                            $nextSchedule[$deviceNames]['timeOn']['min'] = strval($devicePins[4]);
                            $nextSchedule[$deviceNames]['duration']['hour'] = $devicePins[5];
                            $nextSchedule[$deviceNames]['duration']['min'] = $devicePins[6];
                        }
                    }
                }
            }
        }
    }
    return $nextSchedule;
}

function runGpio($cmd, $pin, $args = '')
{

    global $devices, $schedules, $schedule;
    include ('config.php');

    $ss = count($schedules);
    $run_today = False;
    $offset = 0;
    $breaknow = False;
    $thisdate = date("N");
    $timeNow = (date("H") * 60) + date("i"); // get current minute value now
    if ($cmd == "write" || $args != 1) {
        $run_today = True;
        if ($cmd == "cron-write") {
            $cmd = "write";
        }
    }
    else {
        foreach($devices as $deviceName => $devicePin) {
            if ($devicePin[0] == $pin) {
                for ($sch = 1; $sch <= $ss; $sch++) {
                    $schedTime = ($schedules["Schedule-" . $sch][$deviceName][3] * 60) + $schedules["Schedule-" . $sch][$deviceName][4];
                        // calculate & find target schedule day
                    if ($schedTime == $timeNow) {
                        $offset = ($sch - 1) * 10; // index into DOW array
                        $run_today = True;
                        $breaknow = True;
                        break;
                    }
                }
                if ($cmd == "cron-write") {
                    $cmd = "write"; // NOT Dow or Suspend NOT Auto outside of Auto hours
                    if (!$devicePin[$thisdate + 5 + $offset] || $devicePin[4 + $offset] || (($devicePin[1] &&
                         ($timeNow > (($autoOnhr * 60) + $autoOnmin)) && ($timeNow <= (($autoOffhr * 60) + $autoOffmin)))
                            && !($devicePin[1] == 1 && $timeNow > (($hwsautoOffhr*60)+$hwsautoOffmin)) ) ) {
                        $run_today = False; // within Auto range OR suspend OR not day of week
                        $breaknow = False;
                    }
                    else {
                        $schedules["Schedule-1"][$deviceName][1] = 1; // set running bit - dont think this is used any more
                        $run_today = True;
                    }
                }
            }
            if ($breaknow) break;
        }
    }
    if ($run_today) {
        if ($cmd == 'write') {
            if (exec("/usr/local/bin/gpio read $pin") xor $args) { // opposites
                wifiCheck($pin, $args); // pulse the aircon switch
                logEvent($pin, $args);
            }
        }
        exec("/usr/local/bin/gpio mode $pin out", $out, $status);
        $status = NULL;
        $out = NULL;
        exec("/usr/local/bin/gpio $cmd $pin $args", $out, $status);
        if ($status) {
            print ("<p class='error'>Failed to execute /usr/local/bin/gpio $cmd $pin $args: Status $status</p>\n");
        }
        /*        if ( $cmd == 'write' && $args == 1 ) {      // set the running bit (used with Auto)
        foreach( $schedules as $scheduleNums => $scheduleKey ) {
        foreach( $scheduleKey as $deviceNames => $devicePins ) {
        if ($devicePins[0] == $pin) {
        $devicePins[1] = 1;
        break;
        }
        }
        }
        }
        */
        if (is_array($out) && count($out) > 0) {
            return $out[0];
        }
        else {
            return NULL;
        }
    }
}

function issueAt($deviceName, $minFromNow, $onOff)
{
    global $devices, $schedules;

    $script = $_SERVER['SCRIPT_FILENAME'];
    $script = substr($script, 0, strrpos($script, "/")) . "/at-run.php";
    $devicePin = $devices[$deviceName];
    exec("echo /usr/bin/php $script $devicePin[0] $onOff | /usr/bin/at 'now + $minFromNow min'");
}

function readCrontab()
{
    global $devices, $schedules;

    exec("/usr/bin/crontab -l", $out, $status);
    // ignore status; it returns 1 if no crontab has been set yet
    $ret = array();
    foreach($out as $line) {
        if (preg_match('!^(\d+) (\d+) .*/cron-run\.php (\d+) ([01])$!', $line, $matches)) {
            foreach($devices as $deviceName => $devicePin) {
                if ($devicePin[0] != $matches[3]) {
                    continue;
                }
                if ($matches[4] == 1) {
                    $ret[$deviceName]['timeOn']['hour'] = $matches[2];
                    $ret[$deviceName]['timeOn']['min'] = $matches[1];
                }
                else {
                    // we write the on's before the off's, so it's here
                    $ret[$deviceName]['duration']['hour'] = $matches[2] - $ret[$deviceName]['timeOn']['hour'];
                    $ret[$deviceName]['duration']['min'] = $matches[1] - $ret[$deviceName]['timeOn']['min'];
                    while ($ret[$deviceName]['duration']['min'] < 0) {
                        $ret[$deviceName]['duration']['min']+= 60;
                        $ret[$deviceName]['duration']['hour']--;
                    }
                    if ($ret[$deviceName]['duration']['hour'] < 0) {
                        $ret[$deviceName]['duration']['hour']+= 24;
                    }
                }
            }
        }
    }
    return $ret;
}

function writeCrontab($data)
{
    global $devices, $schedules;

    $script = $_SERVER['SCRIPT_FILENAME'];
    $script = substr($script, 0, strrpos($script, "/")) . "/cron-run.php";
    $file = <<<END
# Crontab automatically generated by rasptimer.
# Do not make manual changes, they will be overwritten.
# See https://github.com/jernst/rasptimer

END;
    foreach($devices as $deviceName => $devicePin) {
        if (!isset($data[$deviceName])) {
            continue;
        }
        $p = $data[$deviceName];
        if (isset($p['timeOn'])) {
            if (isset($p['timeOn']['hour'])) {
                $hourOn = $p['timeOn']['hour'];
            }
            else {
                $hourOn = 0;
            }
            $minOn = $p['timeOn']['min'];
            if (isset($p['duration'])) {
                if (isset($p['duration']['hour'])) {
                    $hourOff = $hourOn + $p['duration']['hour'];
                }
                else {
                    $hourOff = $hourOn + 1; // 1hr default
                }
                if (isset($p['duration']['min'])) {
                    $minOff = $minOn + $p['duration']['min'];
                }
                else {
                    $minOff = $minOn;
                }
            }
            while ($minOff > 59) {
                $minOff = $minOff - 60;
                $hourOff++;
            }
            $hourOff = $hourOff % 24; // runs daily
            $file.= "$minOn $hourOn * * * /usr/bin/php $script $devicePin[0] 1\n";
            $file.= "$minOff $hourOff * * * /usr/bin/php $script $devicePin[0] 0\n";
        }
    }
    $tmp = tempnam('/tmp', 'rasptimer');
    $tmpHandle = fopen($tmp, "w");
    fwrite($tmpHandle, $file);
    fclose($tmpHandle);
    exec("/usr/bin/crontab $tmp");
    unlink($tmp);
}

function parseLogLine($line)
{
    // 2016-01-13 07:00:01     11      1
    if (preg_match('!^(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+).*\t([^\t]*)\t([^\t]*)$!', $line, $matches)) {
        return $matches;
    }
    else {
        return NULL;
    }
}

function printLogFileLines($url, $page)
{
    global $logFile;
    global $logFilesGlob;
    global $oldLogFilesPattern;

    $logFiles = glob($logFilesGlob);
    if (count($logFiles) > 1) {
        print "<ul class=\"log-files\">\n";
        // for( $i=count($logfiles); $i >= 1; --$i ) {
        for ($i = 0; $i < count($logFiles); ++$i) {
            if ($logFile == $logFiles[$i]) {
                $selected = !isset($page) ? " class=\"selected\"" : "";
                print "<li$selected><a href=\"$url\">Current</a></li>\n";
            }
            elseif (preg_match("#$oldLogFilesPattern#", $logFiles[$i], $matches)) {
                $selected = ($page == $matches[1]) ? " class=\"selected\"" : "";
                print "<li$selected><a href=\"$url?page=$matches[1]\">$matches[1]</a></li>\n";
            }
        }
        print "</ul>\n";
    }
}

