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
    "Hot Water Main" => array(6,0,0,2400,0,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,0,0,0,1,1,1,1,1,1),
    "Washing Mach." => array(5,0,0,1100,0,0,1,1,1,1,1,1,1,0,0,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Pool Pump" => array(4,0,0,400,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Enviro Pump" => array(10,0,0,400,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Wireless Pwr1" => array(11,0,0,1250,1,2,1,1,1,1,1,1,1,0,0,2,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Wireless Pwr2" => array(3,0,0,1000,1,1,1,1,1,1,1,0,0,0,0,1,0,0,0,0,0,1,1,0,1,0,1,1,1,1,1,1,1,0,1,0,1,1,1,1,1,1,1),
    "Reserve Extra" => array(2,0,0,1000,0,0,1,0,0,0,0,0,0,1000,0,0,0,0,0,0,1,0,0,1000,0,0,1,1,1,1,1,1,1,1000,0,0,0,1,0,0,0,0,0),
);

$powerReserve = 350;
                //  Power Reserve is deducted from the available solar power before any Priority calculations are made
$hwsTsPin = array();
                // Hws Pin#,thermostat Wiring Pin# to indicate thermostat status - leave as null array if not used
$cloudPin = 0;
                // cloud wiring pin#
// Where to log events. This file must be writeable by the webserver user, e.g. "chown www-data /var/log/rasptimer.log"
$logFile      = "/var/log/rasptimer.log";

// "Glob" expression that finds all log files, including old ones. The syntax is the same as in a shell:
// * and ? are wildcards.
$logFilesGlob = "/var/log/rasptimer.log*";

// Regular expression that parses file names of log files other than the current one.
$oldLogFilesPattern = "/var/log/rasptimer\.log\.(\d+)(\.gz)?";

// Printf expression that creates candidate file names of log files other than the current one
$oldLogFilesPrintf = array( "/var/log/rasptimer.log.%d", "/var/log/rasptimer.log.%d.gz" );
