<?php
// Configuration file. adjust as needed.

// Title of the web page
$title = "Solar Timer Scheduler";
//        Device Pins 0-p=pin,1-L=light trigger,2-s=sched box,3-d=power target,4-s=suspend,5-a=autoPM,6-12 then mon-sun
//                               Sched1              Sched2              Sched3              Sched4
//                                  v             10    v             20    v             30    v             40
//                            0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2
//                            p,L,s,d,s,a,m,t,w,t,f,s,s,d,s,a,m,t,w,t,f,s,s,d,s,a,m,t,w,t,f,s,s,d,s,a,m,t,w,t,f,s,s
$devices = array(
    "Hot Water Main" => array(6,0,0,2000,0,0,1,0,0,0,1,0,0,2400,0,0,0,1,1,1,0,1,1,2000,1,1,1,1,1,1,1,1,1,2000,1,0,1,1,1,1,1,1,1),
    "Pool Pump" => array(5,0,0,0,0,0,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,1,1,0,1,0,1,1,1,1,1,1,1,0,0,0,1,1,1,1,1,0,0),
    "Enviro Pump" => array(10,0,0,70,0,0,1,1,1,1,1,1,1,70,0,0,1,1,1,1,1,1,1,70,1,0,1,1,1,1,1,1,1,70,0,0,1,1,1,1,1,1,1),
    "Wireless Pwr1" => array(11,0,0,399,1,0,1,1,1,1,1,1,1,399,1,0,1,1,1,1,1,1,1,399,1,0,1,1,1,1,1,1,1,399,1,0,1,1,1,1,1,1,1),
    "Wireless Pwr2" => array(3,0,0,0,1,0,1,1,1,1,1,1,1,0,1,0,0,0,1,0,0,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Aircon WiFi-1" => array(4,0,0,1200,0,2,1,1,1,1,1,1,1,1200,1,2,1,1,1,1,1,1,1,1200,1,2,0,0,0,0,0,1,0,1200,1,2,1,1,1,1,1,1,1),
    "Aircon WiFi-2" => array(0,0,0,800,1,3,1,1,1,1,1,1,1,800,1,3,1,1,1,1,1,1,1,800,1,3,0,0,0,0,0,1,0,800,1,3,1,1,1,1,1,1,1),
);

$powerReserve = 500;
                //  Power Reserve is deducted from the available solar power before any Priority calculations are made
$wirelessDevs = array(
                    array(11,0),
                    array(3,0));    // wireless devices pin number, 0 (Off) - set to null if not used
$gridpower = 0.123;
$wifi1 = array (4,"http://192.168.0.118/pulse/");    // 1 second pulse On and Off ID 1 - aircon units
$wifi2 = array (0,"http://192.168.0.117/pulse/");     // ID 2 (for tablet/phone switching)
// Situated in AirCon 1 - downstairs
$wifi3 = array (11,"http://192.168.0.118/wireless/21/");    // socket #1 all wireless sockets/devices are offset with +20
$wifi4 = array (3,"http://192.168.0.118/wireless/22/");     // socket #2 for 433Mhz wireless not WiFi
$wifi5 = array (1,"http://192.168.0.118/wireless/23/");     // socket #3 for 433Mhz wireless not WiFi
// Situated in AirCon 2 - downstairs
$wifi6 = array (11,"http://192.168.0.117/wireless/21/");    // socket #1 all wireless sockets are offset with +20
$wifi7 = array (3,"http://192.168.0.117/wireless/22/");     // socket #2 for 433Mhz wireless not WiFi
$wifi8 = array (1,"http://192.168.0.117/wireless/23/");     // socket #3 for 433Mhz wireless not WiFi
// note that wireless 24 is ALL OFF or ALL ON but not used automatically

$wifiget = "http://192.168.0.116/gpio/";   // meter power from esp8266 micro server

// Where to log events. This file must be writeable by the webserver user, e.g. "chown www-data /var/log/rasptimer.log"
$logFile = "/var/log/rasptimer.log";

// "Glob" expression that finds all log files, including old ones. The syntax is the same as in a shell:
// * and ? are wildcards.
$logFilesGlob = "/var/log/rasptimer.log*";

// Regular expression that parses file names of log files other than the current one.
$oldLogFilesPattern = "/var/log/rasptimer\.log\.(\d+)(\.gz)?";

// Printf expression that creates candidate file names of log files other than the current one
$oldLogFilesPrintf = array( "/var/log/rasptimer.log.%d", "/var/log/rasptimer.log.%d.gz" );
