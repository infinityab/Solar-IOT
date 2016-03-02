 <!DOCTYPE html>
<html>
<p style="font-family:verdana,georgia,garamond,serif;">

<!-- <div style="background-color:orange;font-family:verdana,georgia,garamond,serif;text-align:center">
<p><h3>Rasptimer</h3></p></div>
-->
<div style="background-color:lightgreen;font-family:verdana,georgia,garamond,serif;text-align:center">
<p><h3>Solar Scheduler Hardware</h3></p></div>
<style type="text/css">
p.ex1 { font: bold 22px verdana, arial, sans-serif; }
p.ex2 { font: 20px verdana, Georgia, serif; }
p.ex3 { font: 15px serif; }
body{overflow:hidden;}
</style>
<p class="ex2">
...font size not fixed yet press F5 to resize....<br><br>

The timer scheduler hardware consists of a Raspberry Pi micro computer running Apache Raspbian server and can comfortably run alongside other programs such as SBFSpot or similar programs for uploading solar data to sites such as PVOutput etc. 
It is designed to serve Wifi Clientside relay units, 433Mhz Wireless sockets and to drive Contacters for permanently wired or high power appliances directly from the switchboard. All three of these modes are optional.
<p>
<p class="ex2">For contacter use an optically iscolated relay board is recommended and is suitable for up to 240v 10A resistive load (2400W but advise limiting to 1500W) or about 750W inductive load (motors). Thes are cheap and come in various sizes 1, 2,4,8 and 16 relay versions.
The signals from the Pi are opposite to that required by the relay board to maintain a standard of 0=OFF and 1=ON so an inverter chip needs to be installed, this also provides input clamping to 3v for Pi GPIO ports. 
A 74HFC04 is recommended for this which has 6 inverters and can be powered directly from the pi at 3V. The relay board requires 5v.<p>
<p class="ex2">The Contactors may be any type suitable for your requirements but bear in mind amperage quoted is always for resistive loads 
you need to triple the required amperage for inductive loads, so a 1.5HP motor would probably need a 25A Contactor. A manual overide on the contactor would also be useful.
<p class="ex2">The Wireless WiFi AC socket outlets are just ordinary commercial units available from hardware stores and plug into existing sockets. The Pi 
will directly drive 433Mhz transmitters located in WiFi clientside units via WiFi command.
<p class="ex2">
Wifi Clientside units consist of a WiFi SOC and a 2 or 4 channel relay board plus an optional 433Mhz transmitter to pass on wireless commands to sockets. Typically a WiFi unit would be used to switch Air Conditioners, lights etc, wireless sockets would be used for any appliance that has a plug such as heaters etc. 
<p class="ex2"> 
<br><a href="<?= $baseUrl ?>/help3.php" onclick="javascript:void window.open(
   '<?=$baseUrl."/rasptimer/help3.php"?>','1439010501199','width=1100,height=850,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
          return false;"><div align="right">...hardware</div></a>


