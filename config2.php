<?php
// Schedules file, adjust as needed.
// array positions > pin,running flag,run-ON (reguarly),timeon hr,min,duration hr,min
// Title of the web page
$title = "Solar Timer Scheduler";

$schedules = array(
  "Schedule-1" => array(
    "Hot Water Main" => array(6,1,1,12,0,2,0),
    "Washing Mach." => array(5,0,1,9,0,1,15),
    "Pool Pump" => array(4,0,1,9,24,0,1),
    "Enviro Pump" => array(10,0,1,10,25,0,1),
    "Wireless Pwr1" => array(11,0,1,7,0,1,0),
    "Wireless Pwr2" => array(3,0,1,6,0,0,58),
    "Reserve Extra" => array(2,0,1,11,0,12,20),
    ),
  "Schedule-2" => array(
    "Hot Water Main" => array(6,0,1,13,58,0,1),
    "Washing Mach." => array(5,0,1,11,5,1,10),
    "Pool Pump" => array(4,0,1,8,59,0,10),
    "Enviro Pump" => array(10,0,1,8,55,0,1),
    "Wireless Pwr1" => array(11,0,1,17,0,1,0),
    "Wireless Pwr2" => array(3,0,0,6,50,1,0),
    "Reserve Extra" => array(2,0,0,11,0,12,30),
    ),
  "Schedule-3" => array(
    "Hot Water Main" => array(6,0,1,11,15,0,1),
    "Washing Mach." => array(5,0,1,20,23,0,1),
    "Pool Pump" => array(4,0,1,9,59,0,10),
    "Enviro Pump" => array(10,0,0,10,0,1,0),
    "Wireless Pwr1" => array(11,0,0,11,12,0,1),
    "Wireless Pwr2" => array(3,0,1,17,0,0,58),
    "Reserve Extra" => array(2,0,1,12,10,1,0),
    ),
  "Schedule-4" => array(
    "Hot Water Main" => array(6,0,1,21,46,0,1),
    "Washing Mach." => array(5,0,0,21,40,0,2),
    "Pool Pump" => array(4,0,1,6,12,0,10),
    "Enviro Pump" => array(10,0,1,8,30,0,1),
    "Wireless Pwr1" => array(11,0,0,21,30,0,5),
    "Wireless Pwr2" => array(3,0,0,11,0,1,0),
    "Reserve Extra" => array(2,0,1,10,15,1,20),
    ),
);

