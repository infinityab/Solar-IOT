<?php
// Configuration file. adjust as needed.

// Title of the web page
$title = "Solar IOT";
//        Device Pins 0-p=pin,1-A=APM Auto,2-s=sched box,3-d=trigger,4-s=suspend,5-n=power target,6-12 then mon-sun
//                               Sched1              Sched2              Sched3              Sched4
//                                  v             10    v             20    v             30    v             40
//                            0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2
//                            p,A,s,d,s,n,m,t,w,t,f,s,s,d,s,n,m,t,w,t,f,s,s,d,s,n,m,t,w,t,f,s,s,d,s,n,m,t,w,t,f,s,s
$devices = array(
    "Hot Water Main" => array(6,0,0,1900,0,2400,1,1,1,1,1,1,1,1900,0,2400,1,0,0,0,1,0,0,50,0,50,0,1,1,1,0,1,1,2100,0,2400,1,1,1,1,1,1,1,1900,0,2400,0,0,1,0,0,0,1),
    "Pool Pump" => array(5,0,0,1500,0,1500,1,1,1,1,1,0,0,1500,0,1500,0,0,0,0,0,1,1,1500,1,1500,1,1,1,1,1,1,1,1500,1,1500,1,1,1,1,1,0,0,1500,1,1500,1,1,1,1,1,1,1),
    "Enviro Pump" => array(10,0,0,70,0,70,1,1,1,1,1,1,1,70,1,70,1,1,1,1,1,1,1,70,1,70,1,1,1,1,1,1,1,70,1,70,1,1,1,1,1,1,1,70,1,70,1,1,1,1,1,1,1),
    "Wireless Skt1" => array(11,3,0,500,0,1200,1,1,1,1,1,1,1,800,1,1200,1,1,1,1,1,1,1,800,1,1200,1,1,1,1,1,1,1,800,1,1200,1,1,1,1,1,1,1,800,1,1200,1,1,1,1,1,1,1),
    "Wireless Skt2" => array(3,2,0,1200,0,2000,1,1,1,1,1,1,1,1600,1,2000,1,1,1,1,1,1,1,1600,1,2000,1,1,1,1,1,1,1,1600,1,2000,1,1,1,1,1,1,1,1600,1,2000,1,1,1,1,1,1,1),
    "Wireless Skt3" => array(1,5,0,1700,1,2000,1,1,1,1,1,1,1,1600,1,2000,0,0,1,0,0,1,1,1700,1,2000,1,1,1,1,1,1,1,1600,1,2000,1,1,1,1,1,1,1,1600,1,2000,1,1,1,1,1,1,1),
    "WiFi1 Air-Heat" => array(4,4,0,1400,1,1750,0,0,0,0,1,1,0,1400,1,1750,1,1,1,1,1,1,1,1400,1,1750,0,0,0,0,0,1,0,1400,1,1750,0,0,0,0,0,1,0,1400,1,1750,0,0,0,0,0,1,0),
    "WiFi2 Air-Heat" => array(0,0,0,2000,1,2000,0,0,0,0,0,1,0,2000,1,2000,1,1,1,1,1,1,1,2000,1,2000,0,0,0,0,0,1,0,2000,1,2000,0,0,0,0,0,1,0,2000,1,2000,0,0,0,0,0,1,0),
    "Cntl Off-Peak" => array(7,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
);
$powerReserve = 1000;
    // Power Lag
$autoOnhr = 9;
$autoOnmin = 0;
    // Auto start time (it can only use Solar power)
$autoOffhr = 16;
$autoOffmin = 59;
  // Auto finish time
$hwsautoOffhr = 12;
$hwsautoOffmin = 20;
  // HWS Auto finish time
$wifi1 = array (4,"http://192.168.0.118/pulse/");    // WiFi command 1 second pulse On and Off ID 1 - aircon units
$wifi2 = array (0,"http://192.168.0.117/pulse/");     // WiFi command as above ID 2 (for tablet/phone switching)
// Situated in AirCon 1 - downstairs
$wifi3 = array (11,"http://192.168.0.115/wireless/21/");    // socket #1 all wireless sockets/devices are offset with +20
$wifi4 = array (3,"http://192.168.0.115/wireless/22/");     // socket #2 for 433Mhz wireless not WiFi // 118 summer
$wifi5 = array (1,"http://192.168.0.115/wireless/23/");     // socket #3 for 433Mhz wireless not WiFi
// Situated in AirCon 2 - downstairs
$wifi6 = array (11,"http://192.168.0.115/wireless/21/");    // socket #1 all wireless sockets are offset with +20
$wifi7 = array (3,"http://192.168.0.115/wireless/22/");     // socket #2 for 433Mhz wireless not WiFi  // 117 summer
$wifi8 = array (1,"http://192.168.0.115/wireless/23/");     // socket #3 for 433Mhz wireless not WiFi
// Situated in Meter Box
$wifi9 = array (11,"http://192.168.0.116/wireless/21/");    // socket #1 all wireless sockets are offset with +20
$wifi10 = array (3,"http://192.168.0.116/wireless/22/");     // socket #2 for 433Mhz wireless not WiFi
$wifi11 = array (1,"http://192.168.0.116/wireless/23/");     // socket #3 for 433Mhz wireless not WiFi
// note that wireless 24 is ALL OFF or ALL ON but not used automatically
$wifiget = "http://192.168.0.116/gpio/";   // meter power from esp8266 micro server
$wifigetw = "http://192.168.0.114/gpio/";   // weather details from esp8266 micro server
// Where to log events. This file must be writeable by the webserver user, e.g. "chown www-data /var/log/rasptimer.log"
$logFile = "/var/log/rasptimer.log";

// "Glob" expression that finds all log files, including old ones. The syntax is the same as in a shell:
// * and ? are wildcards.
$logFilesGlob = "/var/log/rasptimer.log*";

// Regular expression that parses file names of log files other than the current one.
$oldLogFilesPattern = "/var/log/rasptimer\.log\.(\d+)(\.gz)?";

// Printf expression that creates candidate file names of log files other than the current one
$oldLogFilesPrintf = array( "/var/log/rasptimer.log.%d", "/var/log/rasptimer.log.%d.gz" );

