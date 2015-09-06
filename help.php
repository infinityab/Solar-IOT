 <!DOCTYPE html>
<html>
<p style="font-family:verdana,georgia,garamond,serif;">
<div style="background-color:orange;font-family:verdana,georgia,garamond,serif;text-align:center">
<h3>Rasptimer</div>

<div style="background-color:lightgreen;font-family:verdana,georgia,garamond,serif;text-align:center">
<b>Solar Scheduler</h3></div></b>Press F5 to resize - sizing not fixed yet!</p></div>
<style type="text/css">
p.ex1 {
    font: bold 22px verdana, arial, sans-serif;
}

p.ex2 {
    font: 18px verdana, Georgia, serif;
}
p.ex3 {
    font: 15px serif;
}

<? // body{overflow:hidden;} ?>
</style>
<p class="ex2">The timer scheduler consists of 3 parts, the <b>Schedule</b> menu which determines the on/off times,
the <b>Configure</b> menu which provides additional conditions such as Suspend, Day-of-Week, Cloud etc. and the <b>Auto 
Power Management</b> features which includes priority level and power requirement.<br>
<p class="ex2"><b>FUNCTIONS</b><br>
<b>Change Schedule</b> - used to set up the various schedule times or to switch off a scheduled appliance.<br>
<b>TurnOn/Off</b> - manually turn on or off an appliance for various times or terminate a current schedule.
<br><b>Bump</b> - nudge the timer up/down in 15 minute steps without disturbing the schedule, returns to normal next run.
<br><b>Priority</b> - used for Auto Power management - 0 = OFF, 1 = appliances NOT having timer during daylight hours, 2 = appliances that rely on their later timer functions or thermostat to switch them OFF - use with caution, mainly for HWS. 
<br><b>Power</b> - used for Auto Power management - set the power requirement in watts, when free power is available any appliance that has priority set will be matched against free power and switched on. As free power drops below the requirement they will be switched off. Free power is determined from the SMA inverter power available and any appliance switched ON.
<br><b>Suspend</b> - used to temporarily NOT run an appliance but leaves the schedules intact. This applies to <u>individual</u> schedules but <u>all</u> days.
<br><b>Day of Week</b> - individual days may be switched on or off for any appliance.
<br><b>Cloud</b> - if a 'low light detector' is connected to the Pi (wpin 0) it will suspend a set appliance from running if low light or cloud is detected.
<br><p class="ex1"><b>Some points to note </b>
<ul><li><p class="ex2">Schedules do NOT have to be in order but obviously it is easier to follow if they are.</li>
<li><p class="ex2">Do not overlap Schedules on the same appliance and leave a minimum 1 minute gap between them.</li>
<li><p class="ex2">If the <u>current status</u> for an appliance shows 'not scheduled' none of the remaining schedules will ever run, however
if any other remaining schedules <u>are</u> required then just re-enter one of those schedules to reactivate the remaining schedule</li>
<li><p class="ex2">Preferably leave the timer on the Home/Front page as it provides an additional nudge to the scheduler at zero hour and provides power checks for priority appliances.</li>
<li><p class="ex2">The timer relies on regular schedules to start and finish to nudge the schedules along. As time creeps on there will eventually be only one left to run, it is this last one that will finally nudge all the schedules for the next days run.</li>
<a href="<?= $baseUrl ?>/help2.php" onclick="javascript:void window.open(
   '<?=$baseUrl."/rasptimer/help2.php"?>','1439010501199','width=1100,height=850,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
          return false;"><div align="right">...hardware</div></a>

