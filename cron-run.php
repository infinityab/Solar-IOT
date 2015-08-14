<?php
require_once( 'config.php' );
require_once( 'config2.php' );
require_once( 'functions.php' );

if( count( $argv ) != 3 ) {
    exit( 1 );
}
runGpio( "cron-write", $argv[1], $argv[2] );
$Schedule = readCrontab();
$Schedule = checkSchedules($Schedule);  // cron job run so check for next schedules
writeCrontab($Schedule);
