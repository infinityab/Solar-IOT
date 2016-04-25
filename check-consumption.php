 <!-- <script src="http://pvoutput.org/portlet/r1/getstatus.jsp?sid=40003"></script> --> <!-- get graph data -->
<?php
  require( 'functions.php' );
  require( 'config.php' );
  $j = strip_tags(file_get_contents($wifiget."5"));   // GET http data from meter
  $tp = strip_tags(file_get_contents($wifigetw."6"));   // GET http temperature from weather server
  $poweravailable = getSmaPower();  // get current solar power available
  if ($poweravailable == 0) $poweravailable = getSmaPower();  // second try
  if ($j > 0){ $pc = ($poweravailable * 1000)- $j; } else { $pc = ($poweravailable * 1000) + (0 - $j); } // calculate consumption
  $t=date("H:i"); // get the time
  $d=date("Ymd");
  $ch = curl_init();  // set up pvoutput update
  $fields = array( 'd'=> $d, 't'=> $t, 'v4'=> $pc, 'v5'=> (float)$tp, 'n'=> '0' );   // add the data values v5 is temperature
  $postvars = '';
  foreach($fields as $key=>$value) {
    $postvars .= $key . "=" . $value . "&";
    }
  $url = "http://pvoutput.org/service/r2/addstatus.jsp";
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_POST, 1);                // 0 for a get request
  curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
  curl_setopt($ch,CURLOPT_HTTPHEADER, array(
    "X-Pvoutput-Apikey: b48740f4f30a7be6b44ca821f75554b2c28eea37", "X-Pvoutput-SystemId: 40003"));
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
  curl_setopt($ch,CURLOPT_TIMEOUT, 20);
  $response = curl_exec($ch); // send data to pvoutput
  curl_close ($ch);

//  print "curl response is:" . $response;
// $d="d=20160323";   // example - direct CURL command to PVoutput
// $result = exec('curl "http://pvoutput.org/service/r2/addstatus.jsp" -H "X-Pvoutput-Apikey: b48740f4f30a7be6b44ca821f75554b2c28eea37" -H "X-Pvoutput-SystemId: 40003" -d "d=20160324" -d "t=07:45" -d "v4=110" -0');

?>
