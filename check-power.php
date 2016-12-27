mail -s "This is the subject line" root@localhost
<?php
  require( 'functions.php' );
  require( 'config.php' );
  $j = 0;
       // test Meter box reader for failure
  $url = $wifiget."4";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.4");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_TIMEOUT,10);
  curl_setopt($ch, CURLOPT_ENCODING, "gzip");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $output = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if( $httpcode  == '200' ) {
    $j = strip_tags(file_get_contents($wifiget."4"));   // ie http://192.168.0.116/gpio/4 - is current signed consumption in watts
  } else {

    $msg = "***  Meter Reader Failure  ***\n\nReset Meter Reader in External Power Box";
    mail("larapenta@westnet.com.au","METER BOX READER FAILURE",$msg);       // send email
  }
    // use wordwrap() if lines are longer than 70 characters
    // $msg = wordwrap($msg,70);

  $res = checkPowerTargets($j);   // $res only for testing, $J is raw +watts (export) or -watts (import)

?>

