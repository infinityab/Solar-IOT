<?php
// Schedules file, adjust as needed.
// array positions > pin,running flag,run-ON (reguarly),timeon hr,min,duration hr,min
// Title of the web page
$title = "Solar Timer Scheduler";

$schedules = array(
  "Schedule-1" => array(
    "Hot Water Main" => array(6,1,1,11,45,3,0),
    "Pool Pump" => array(5,0,1,2,0,2,0),
    "Enviro Pump" => array(10,0,1,8,10,8,30),
    "Wireless Skt1" => array(11,0,1,9,0,9,0),
    "Wireless Skt2" => array(3,0,1,11,0,7,0),
    "Wireless Skt3" => array(1,0,1,9,0,9,0),
    "WiFi1 Air-Heat" => array(4,0,1,9,45,9,0),
    "WiFi2 Air-Heat" => array(0,0,1,9,0,9,0),
    ),
  "Schedule-2" => array(
    "Hot Water Main" => array(6,0,1,10,45,3,0),
    "Pool Pump" => array(5,0,1,10,0,2,0),
    "Enviro Pump" => array(10,0,0,9,1,9,0),
    "Wireless Skt1" => array(11,0,0,9,0,9,0),
    "Wireless Skt2" => array(3,0,0,22,0,1,0),
    "Wireless Skt3" => array(1,0,0,21,42,2,10),
    "WiFi1 Air-Heat" => array(4,0,0,16,0,2,1),
    "WiFi2 Air-Heat" => array(0,0,1,22,0,1,0),
    ),
  "Schedule-3" => array(
    "Hot Water Main" => array(6,0,1,5,50,0,30),
    "Pool Pump" => array(5,0,0,20,23,0,1),
    "Enviro Pump" => array(10,0,0,10,0,1,0),
    "Wireless Skt1" => array(11,0,0,11,12,0,1),
    "Wireless Skt2" => array(3,0,0,17,0,0,58),
    "Wireless Skt3" => array(1,0,0,21,42,2,10),
    "WiFi1 Air-Heat" => array(4,0,0,1,0,0,1),
    "WiFi2 Air-Heat" => array(0,0,0,1,0,0,1),
    ),
  "Schedule-4" => array(
    "Hot Water Main" => array(6,0,1,10,0,6,50),
    "Pool Pump" => array(5,0,1,8,40,8,0),
    "Enviro Pump" => array(10,0,0,8,30,0,1),
    "Wireless Skt1" => array(11,0,0,21,30,0,5),
    "Wireless Skt2" => array(3,0,0,11,0,1,0),
    "Wireless Skt3" => array(1,0,0,21,42,2,10),
    "WiFi1 Air-Heat" => array(4,0,0,9,0,12,1),
    "WiFi2 Air-Heat" => array(0,0,0,1,0,0,1),
    ),
);

