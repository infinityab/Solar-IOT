 <!DOCTYPE html>
<html>
<p style="font-family:verdana,georgia,garamond,serif;">

<div style="background-color:orange;font-family:verdana,georgia,garamond,serif;text-align:center">
<p><h3>Rasptimer</h3></p></div>
<div style="background-color:lightgreen;font-family:verdana,georgia,garamond,serif;text-align:center">
<p><h3>Solar Scheduler Hardware</h3></p></div>
<style type="text/css">
p.ex1 {
    font: bold 22px verdana, arial, sans-serif;
}

p.ex2 {
    font: 20px verdana, Georgia, serif;
}
p.ex3 {
    font: 15px serif;
}

body{overflow:hidden;}
</style>
<p class="ex2">The timer scheduler hardware consists of a Raspberry Pi micro computer running Raspbian or UBOS (under development),
and is designed to drive an optically iscolated relay board, and in addition optional Contacters to drive
permanently wired or high power appliances directly from the switchboard such as water heaters,
pumps etc, and lastly a number of wireless wifi driven AC sockets which may be sited anywhere within its 30m range.
<p>
<p class="ex2">The relay board contains 4 optically iscolated relays suitable for up to 240v 10A resistive load (2400W but advise limiting to 1500W) or about 750W inductive load (motors).
The signals from the Pi are opposite to that required by the relay board so an inverter chip needs to be installed, and the  
74HFC04 is recommended for this. This IC has 6 invertors and can be powered directly from the pi or relay board at 5v. 
<p>
<p class="ex2">The Contactors may be any type suitable for your requirements but bear in mind amperage quoted is always for resistive loads 
you need to triple the required amperage for inductive loads, so a 1.5HP motor would probably need a 25A Contactor. A manual overide on the contactor would also be useful.
<p>
<p class="ex2">The Wireless WiFi AC socket outlets are just like ordinary mobile  double outlets and plug into existing sockets. The Pi 
will directly drive the transmiteer to the  outlets via the Pi header. 
<br><a href="<?= $baseUrl ?>/help3.php" onclick="javascript:void window.open(
   '<?=$baseUrl."/rasptimer/help3.php"?>','1439010501199','width=1100,height=850,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
          return false;"><div align="right">...hardware</div></a>

....NOT completed yet  F5 to resize....
