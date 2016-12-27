<?php
// Schedules file, adjust as needed.
// array positions > pin,running flag,run-ON (reguarly),timeon hr,min,duration hr,min
// Title of the web page
// $title = "Solar IOT";

$schedules = array(
  "Schedule-1" => array(
    "Hot Water Main" => array(6,1,1,10,0,7,25),
    "Pool Pump" => array(5,0,1,9,41,8,45),
    "Enviro Pump" => array(10,0,1,8,40,9,0),
    "Wireless Skt1" => array(11,0,1,8,31,1,25),
    "Wireless Skt2" => array(3,0,1,8,30,8,25),
    "Wireless Skt3" => array(1,0,1,9,15,8,0),
    "WiFi1 Air-Heat" => array(4,0,1,11,15,6,30),
    "WiFi2 Air-Heat" => array(0,0,1,13,0,4,44),
    "Cntl Off-Peak" => array(7,0,0,0,0,0,0),
    ),
  "Schedule-2" => array(
    "Hot Water Main" => array(6,0,1,12,30,2,30),
    "Pool Pump" => array(5,0,1,10,0,1,30),
    "Enviro Pump" => array(10,0,0,9,1,9,0),
    "Wireless Skt1" => array(11,0,0,9,0,9,0),
    "Wireless Skt2" => array(3,0,1,5,59,1,0),
    "Wireless Skt3" => array(1,0,0,21,42,2,10),
    "WiFi1 Air-Heat" => array(4,0,0,16,0,2,1),
    "WiFi2 Air-Heat" => array(0,0,1,22,0,1,0),
    "Cntl Off-Peak" => array(7,0,0,0,0,0,0),
    ),
  "Schedule-3" => array(
    "Hot Water Main" => array(6,0,1,11,50,2,15),
    "Pool Pump" => array(5,0,1,10,0,6,0),
    "Enviro Pump" => array(10,0,0,10,0,1,0),
    "Wireless Skt1" => array(11,0,0,11,12,0,1),
    "Wireless Skt2" => array(3,0,0,10,0,5,0),
    "Wireless Skt3" => array(1,0,0,21,42,2,10),
    "WiFi1 Air-Heat" => array(4,0,0,1,0,0,1),
    "WiFi2 Air-Heat" => array(0,0,0,1,0,0,1),
    "Cntl Off-Peak" => array(7,0,0,0,0,0,0),
    ),
  "Schedule-4" => array(
    "Hot Water Main" => array(6,0,1,13,21,2,0),
    "Pool Pump" => array(5,0,1,3,0,1,30),
    "Enviro Pump" => array(10,0,0,8,30,0,1),
    "Wireless Skt1" => array(11,0,1,14,39,0,1),
    "Wireless Skt2" => array(3,0,0,11,0,1,0),
    "Wireless Skt3" => array(1,0,0,21,42,2,10),
    "WiFi1 Air-Heat" => array(4,0,0,9,0,12,1),
    "WiFi2 Air-Heat" => array(0,0,0,1,0,0,1),
    "Cntl Off-Peak" => array(7,0,0,0,0,0,0),
    ),
  "Schedule-5" => array(
    "Hot Water Main" => array(6,0,1,6,0,1,0),
    "Pool Pump" => array(5,0,1,0,5,2,0),
    "Enviro Pump" => array(10,0,0,8,30,0,1),
    "Wireless Skt1" => array(11,0,1,14,39,0,1),
    "Wireless Skt2" => array(3,0,0,11,0,1,0),
    "Wireless Skt3" => array(1,0,0,21,42,2,10),
    "WiFi1 Air-Heat" => array(4,0,0,9,0,12,1),
    "WiFi2 Air-Heat" => array(0,0,0,1,0,0,1),
    "Cntl Off-Peak" => array(7,0,0,0,0,0,0),
    ),
);

