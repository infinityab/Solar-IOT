<style type="text/css">
body{overflow:hidden;}
</style>
<HTML>
<p style="font-family:verdana"><p style="font-size:25px"><b>Hardware</b><p style="font-size:18px">
The timer scheduler hardware consists of a Raspberry Pi micro computer running Raspbian or UBOS (under development),
and is designed to drive an optically iscolated relay board, and in addition optional Contacters to drive
permanently wired or high power appliances directly from the switchboard such as water heaters,
pumps etc, and lastly a number of wireless wifi driven AC sockets which may be sited anywhere within its 30m range.

The relay board contains 4 relays suitable for up to 240v 10A resistive load (2400W) or about 750W inductive load (motors).
They require invertors to drive the Pi signals to the relays as they are reverse polarity as to  what is required so a single 
74HFC04 is recommended although the standard 7404 will suffice but not the LS version. This IC has 6 invertors and can be powered 
directly from the pi or relay board at 5v. 
<br>
The Contactors may be any type suitable for your requirements but bear in mind amperage quoted is always for resistive loads 
you need to triple the required amperage for inductive loads, so a 1.5HP motor would probably need a 25A Contactor.. A manual overide on the contactor would also be useful.
<br>
The Wireless WiFi AC socket outlets are just like ordinary mobile  double outlets and plug into existing sockets. The Pi 
will directly drive the transmiteer to the  outlets via the Pi header. 
<br><a href="<?= $baseUrl ?>/help3.php" onclick="javascript:void window.open(
   '<?=$baseUrl."/rasptimer/help3.php"?>','1439010501199','width=1100,height=850,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
          return false;"><div align="right">...hardware</div></a>
