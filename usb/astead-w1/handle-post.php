

<?php
// run now or stop now
    foreach( $devices as $deviceName => $devicePin ) {
        $actionPar   = $deviceName . 'Action';
        $durationPar = $deviceName . 'Duration';
        $actionPar   = str_replace( ' ', '_', $actionPar ); // we love PHP
        $durationPar = str_replace( ' ', '_', $durationPar ); // we love PHP

        if( isset( $_POST[$actionPar] )) {
            $turnOn = $_POST[$actionPar] == 'Turn on';
            runGpio( "write", $devicePin[0], $turnOn ? "1" : "0" );

            if( isset( $_POST[$durationPar] ) && $_POST[$durationPar] ) { # something other than 0
                issueAt( $deviceName, $_POST[$durationPar], $turnOn ? "0" : "1" );
            }
        }
	$IntervalPar = $devicePin[0] . '-Interval';
//	$DowPar = $devicePin[0] . '-Dow1';

	if( isset( $_POST[$IntervalPar] )) {   // || isset( $_POST[$DowPar]) ) {
		$rewrite_config = True;
	}
    }
    if ($rewrite_config) {
	$source = "config.php";

	// I have a setup where I run on a read-only filesystem.
	// /tmp is mounted on a ramdrive so it is writable.
	// I then have a small program running which watches for
	// the creation of the /tmp/config.php file, and if it sees
	// it is remounts the filesystem as writable, copies over the
	// config.php file and then remounts the filesystem as read
	// only again.  If you are using a writable file system you
	// can simply move the new file over to the old one after
	// re-writing the config.
	$target = "/tmp/config.php";
	$handle = fopen($source, 'r');
	$handle_out = fopen($target, 'w');

	if ($handle) {
	    while (($line = fgets($handle)) !== false) {
	        if (substr($line,0,8) == '$devices') {
	    		fwrite($handle_out, $line);

			while (($line = fgets($handle)) !== false) {
	        		if (substr($line,0,2) == ");") {
					break;
				}
			}
			foreach( $devices as $deviceName => $devicePin ) {
			   $dummy = 0;
			   $IntervalPar = $devicePin[0] . '-Interval';
			   $WindPar = $devicePin[0] . '-Wind';
                           $SuspendPar = $devicePin[0] . '-Suspend';
                           $CloudPar = $devicePin[0] . '-Cloud';
                           $DowMon = $devicePin[0] . '-DowMon';
                           $DowTue = $devicePin[0] . '-DowTue';
                           $DowWed = $devicePin[0] . '-DowWed';
                           $DowThu = $devicePin[0] . '-DowThu';
                           $DowFri = $devicePin[0] . '-DowFri';
                           $DowSat = $devicePin[0] . '-DowSat';
                           $DowSun = $devicePin[0] . '-DowSun';
//			   $DowPar = $devicePin[0] . '-Dow' . $n;	# these -Par's have to be present  here
//			   $x = $devicePin[6];
			   fwrite($handle_out, "    \"" . 
		           $deviceName . "\" => array(" . 
					$devicePin[0].",".
					$devicePin[1].",");
//			   if( isset( $_POST[$IntervalPar] ) && $_POST[$IntervalPar] != $devicePin[2] ) {
//				fwrite($handle_out, $_POST[$IntervalPar].",");
//			   } else {
//				fwrite($handle_out,($dummy).",");
//			   }
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
//                           fwrite($handle_out, $devicePin[2].",");
//			   fwrite($handle_out, ($_POST[$WindPar]=="on"?"1":"0").",");		# Wind
			   fwrite($handle_out, ($_POST[$SuspendPar]=="on"?"1":"0").",");	# Suspend
			   fwrite($handle_out, ($_POST[$CloudPar]=="on"?"1":"0").",");		# Cloud
                           fwrite($handle_out, ($_POST[$DowMon]=="on"?"1":"0").",");
                           fwrite($handle_out, ($_POST[$DowTue]=="on"?"1":"0").",");
                           fwrite($handle_out, ($_POST[$DowWed]=="on"?"1":"0").",");
                           fwrite($handle_out, ($_POST[$DowThu]=="on"?"1":"0").",");
                           fwrite($handle_out, ($_POST[$DowFri]=="on"?"1":"0").",");
                           fwrite($handle_out, ($_POST[$DowSat]=="on"?"1":"0").",");
                           fwrite($handle_out, ($_POST[$DowSun]=="on"?"1":"0").",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy).",");
                           fwrite($handle_out,($dummy)."),");

//	                   fwrite($handle_out,($x)."),");		# test in last day byte

			   fwrite($handle_out, "\n");
			}
			fwrite($handle_out, $line);

		} else {
			fwrite($handle_out, $line);
		}
	    }
	} else {
	    // error opening the file.
	}
	fclose($handle);
	unlink($source);
	fclose($handle_out);

	// TODO: Lets sleep for a bit to allow our program to update
	// the config file.  This would be better done some
	// other way, but this is working right now.
//	sleep(1);
	$file = '/tmp/config.php';			# Added file save to update changes - DRC
        $newfile = '/var/www/rasptimer/config.php';
//	sleep(2);
        if (!copy($file, $newfile)) {
            echo "failed to copy $file...\n";
        }
//        sleep(1);
        header( "Location: $baseUrl/configure.php" );
	exit( 0 );
}

// schedule
    if( isset( $_POST['change-schedule'] ) && $_POST['change-schedule'] == 'Save' ) {
        $schedule = readCrontab();
        $deviceName = $_POST['deviceName'];
        if( isset( $devices[$deviceName] )) {
            if( $_POST['scheduled'] == 'yes' ) {
function rangeCheck( $val, $min, $max ) {
    $val = intval( $val );
    if( $val < $min ) {
        $val = $min;
    } else if( $val > $max ) {
        $val = $max;
    }
    return $val;
}
                $schedule[$deviceName]['timeOn']['hour']   = rangeCheck( $_POST['timeOnHour'], 0, 23 );
                $schedule[$deviceName]['timeOn']['min']    = rangeCheck( $_POST['timeOnMin'], 0, 59 );
                $schedule[$deviceName]['duration']['hour'] = rangeCheck( $_POST['durationHour'], 0, 23 );
                $schedule[$deviceName]['duration']['min']  = rangeCheck( $_POST['durationMin'], 0, 59 );

            } else {
                $schedule[$deviceName] = NULL;
            }
            writeCrontab( $schedule );
        }
    }

    header( "Location: $baseUrl/" );
    exit( 0 );

