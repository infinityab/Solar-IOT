<?php
// Configuration file. adjust as needed.

// Title of the web page
$title = "Solar Timer Scheduler";
//                             0-p=pin,1-c=cloud,2-s=sched box,3-d=power target,4-s=suspend,5-a=autoPM,6-12 then mon-sun
//                               Sched1              Sched2              Sched3              Sched4
//                                  v             10    v             20    v             30    v             40
//                            0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2
//                            p,c,s,d,s,a,m,t,w,t,f,s,s,d,s,a,m,t,w,t,f,s,s,d,s,a,m,t,w,t,f,s,s,d,s,a,m,t,w,t,f,s,s
$devices = array(
    "Hot Water Main" => array(6,0,0,2400,1,0,1,1,1,1,1,1,1,0,0,0,1,1,0,1,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,1,0,0,1,1),
    "Pool Pump" => array(5,0,0,0,1,0,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Enviro Pump" => array(10,0,0,70,0,0,1,1,1,1,1,1,1,0,0,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Wireless Pwr1" => array(11,0,0,399,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Wireless Pwr2" => array(3,0,0,1000,1,0,1,1,1,1,1,1,1,0,1,0,0,0,1,0,0,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Aircon WiFi-1" => array(4,0,0,1750,0,2,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,0,0,0,0,0,1,0,0,1,0,1,1,1,1,1,1,1),
    "Aircon WiFi-2" => array(0,0,0,1000,0,3,1,1,1,1,1,1,1,0,0,0,1,1,1,1,1,1,1,0,1,0,0,0,0,0,0,1,0,0,1,0,1,1,1,1,1,1,1),
);

$powerReserve = 500;
                //  Power Reserve is deducted from the available solar power before any Priority calculations are made
$wirelessDevs = array(
                    array(11,0),
                    array(3,0));    // wireless devices pin number, 0 (Off) - set to null if not used
$gridpower = 0.123;
$wifi1 = array (4,"http://192.168.0.118/digital/");    // 1 second pulse On and Off ID 1 - aircon units
$wifi2 = array (0,"http://192.168.0.117/digital/");     // ID 2 (for tablet/phone switching)
$wifi3 = array (11,"http://192.168.0.116/sw1/");    // actually 433Mhz wireless not wifi
$wifi4 = array (3,"http://192.168.0.116/sw3/");     // wireless (sw2 is busted)
$wifiget = "http://192.168.0.116/gpio/";   // meter power from esp8266 micro server

// Where to log events. This file must be writeable by the webserver user, e.g. "chown www-data /var/log/rasptimer.log"
$logFile      = "/var/log/rasptimer.log";

// "Glob" expression that finds all log files, including old ones. The syntax is the same as in a shell:
// * and ? are wildcards.
$logFilesGlob = "/var/log/rasptimer.log*";

// Regular expression that parses file names of log files other than the current one.
$oldLogFilesPattern = "/var/log/rasptimer\.log\.(\d+)(\.gz)?";

// Printf expression that creates candidate file names of log files other than the current one
$oldLogFilesPrintf = array( "/var/log/rasptimer.log.%d", "/var/log/rasptimer.log.%d.gz" );
