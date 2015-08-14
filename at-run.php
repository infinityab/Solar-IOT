<?php
require_once( 'config.php' );
require_once( 'config2.php' );
require_once( 'functions.php' );
exec( "/usr/local/bin/gpio mode 0 input");      // set pin 0 to input for cloud detection
if( count( $argv ) != 3 ) {
    exit( 1 );
}
runGpio( "write", $argv[1], $argv[2] );
