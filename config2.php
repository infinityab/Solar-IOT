<?php
// Schedules file, adjust as needed.
// array positions > pin,running flag,run-ON (reguarly),timeon hr,min,duration hr,min
// Title of the web page
$title = "Solar Timer Scheduler";

$schedules = array(
  "Schedule-1" => array(
    "Hot Water Main" => array(6,1,1,17,39,0,1),
    "Hot Water Boost" => array(5,0,1,11,33,0,1),
    "Pool Pump" => array(4,0,1,9,24,0,1),
    "Enviro Pump" => array(10,0,1,10,25,0,1),
    "Heat-Aircon" => array(11,0,1,10,0,1,0),
    "Wireless Pwr1" => array(3,0,1,9,0,1,0),
    ),
  "Schedule-2" => array(
    "Hot Water Main" => array(6,0,1,9,0,1,0),
    "Hot Water Boost" => array(5,0,1,8,17,0,35),
    "Pool Pump" => array(4,0,1,8,59,0,10),
    "Enviro Pump" => array(10,0,1,8,55,0,1),
    "Heat-Aircon" => array(11,0,1,9,50,0,29),
    "Wireless Pwr1" => array(3,0,1,9,39,0,50),
    ),
  "Schedule-3" => array(
    "Hot Water Main" => array(6,0,1,11,15,0,1),
    "Hot Water Boost" => array(5,0,1,11,17,0,35),
    "Pool Pump" => array(4,0,1,9,59,0,10),
    "Enviro Pump" => array(10,0,0,10,0,1,0),
    "Heat-Aircon" => array(11,0,1,11,12,0,1),
    "Wireless Pwr1" => array(3,0,1,10,0,1,0),
    ),
  "Schedule-4" => array(
    "Hot Water Main" => array(6,0,1,18,49,0,2),
    "Hot Water Boost" => array(5,0,1,11,17,0,35),
    "Pool Pump" => array(4,0,1,6,12,0,10),
    "Enviro Pump" => array(10,0,1,8,30,0,1),
    "Heat-Aircon" => array(11,0,1,8,12,0,5),
    "Wireless Pwr1" => array(3,0,1,11,0,1,0),
    ),
);

