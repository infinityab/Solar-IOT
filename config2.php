<?php
// Schedules file, adjust as needed.
// array positions > pin,running flag,run-ON (reguarly),timeon hr,min,duration hr,min
// Title of the web page
$title = "Solar Timer Scheduler";

$schedules = array(
  "Schedule-1" => array(
    "Hot Water Main" => array(6,1,1,10,15,8,0),
    "Pool Pump" => array(5,0,1,2,0,3,0),
    "Enviro Pump" => array(10,0,1,8,15,9,45),
    "Wireless Pwr1" => array(11,0,1,8,30,12,0),
    "Wireless Pwr2" => array(3,0,1,8,30,12,0),
    "Aircon WiFi-1" => array(4,0,1,9,45,9,0),
    "Aircon WiFi-2" => array(0,0,1,9,45,9,0),
    ),
  "Schedule-2" => array(
    "Hot Water Main" => array(6,0,1,12,0,2,0),
    "Pool Pump" => array(5,0,1,10,0,3,0),
    "Enviro Pump" => array(10,0,0,9,1,9,0),
    "Wireless Pwr1" => array(11,0,0,17,0,1,0),
    "Wireless Pwr2" => array(3,0,0,15,5,0,15),
    "Aircon WiFi-1" => array(4,0,0,16,0,2,1),
    "Aircon WiFi-2" => array(0,0,0,22,10,1,20),
    ),
  "Schedule-3" => array(
    "Hot Water Main" => array(6,0,1,12,30,14,30),
    "Pool Pump" => array(5,0,0,20,23,0,1),
    "Enviro Pump" => array(10,0,0,10,0,1,0),
    "Wireless Pwr1" => array(11,0,0,11,12,0,1),
    "Wireless Pwr2" => array(3,0,0,17,0,0,58),
    "Aircon WiFi-1" => array(4,0,0,1,0,0,1),
    "Aircon WiFi-2" => array(0,0,0,1,0,0,1),
    ),
  "Schedule-4" => array(
    "Hot Water Main" => array(6,0,1,11,0,13,0),
    "Pool Pump" => array(5,0,0,21,40,0,2),
    "Enviro Pump" => array(10,0,0,8,30,0,1),
    "Wireless Pwr1" => array(11,0,0,21,30,0,5),
    "Wireless Pwr2" => array(3,0,0,11,0,1,0),
    "Aircon WiFi-1" => array(4,0,0,9,0,12,1),
    "Aircon WiFi-2" => array(0,0,0,1,0,0,1),
    ),
);

