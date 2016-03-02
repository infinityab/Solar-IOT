 <!DOCTYPE html>
<html>
<p style="font-family:verdana,georgia,garamond,serif;">
<!-- <div style="background-color:orange;font-family:verdana,georgia,garamond,serif;text-align:center">
<h3>Solar Scheduler</div>
-->
<div style="background-color:lightgreen;font-family:verdana,georgia,garamond,serif;text-align:center">
<b>Solar Scheduler Help</h3></div></b>Press F5 to resize - sizing not fixed yet!</p></div>
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
the <b>Configure</b> menu which provides additional conditions such as Suspend, Day-of-Week etc and lastly the <b>Auto 
Power Management</b> function which automatically allocates any surplus solar power.<br>
<p class="ex2"><b>FUNCTIONS</b><br>
<b>Change Schedule</b> - used to set up the various schedule times or to switch off a scheduled appliance.<br>
<b>TurnOn/Off</b> - manually turn on or off an appliance for various times or terminate a current schedule. This wont work in APM mode unless it is run within the timespan of an existing schedule.
<br><b>Bump</b> - nudge the timer earlier or later in 15 minute steps, if later must be within the current schedule timespan, returns to normal next run.
<br><b>Auto</b> - used for Auto Power Management (APM) - 0 = OFF, power calculated in order of number, 1 = first, 2 next and so on. The APM function works within any existing schedule so prudent to set aside a wider ranging schedule or one that may be optionally suspended for this purpose. This is entered under Schedule-1 but valid for all.
<br><b>Power</b> - used for APM - power requirement in watts and is entered under Schedule-1 but valid for all. When free power is available an appliance having <b>Auto</b> set is matched against free power and switched on. As free power drops below a required level they will be switched off. Free power is determined from the solar power excess over that of the current consumed power. 
<br><b>Suspend</b> - used to temporarily NOT run an appliance but leaves the schedules intact. This applies to <u>individual</u> schedules and the days that are set in that schedule.
<br><b>Day of Week</b> - individual days may be set to switch on or off for any day for an appliance.
<br><b>Light</b> - No function.
<br><b>Power Lag</b> - Power Lag is like the hysterisis of a thermostat. In this case it will take x power to switch on an appliance but x + Lag to switch it OFF. This reduces constant ON-OFF-ON switching every time the power drops slightly due to say a fridge or freezer starting up.
<br><p class="ex1"><b>Tricks and Tips</b>
<ul><li><p class="ex2">Schedules do NOT have to be in order but obviously it is easier to follow if they are.</li>
<li><p class="ex2">Do not overlap Schedules on the same appliance and leave a minimum 1 minute gap between them.</li>
<li><p class="ex2">If the <u>current status</u> for an appliance shows 'not scheduled' in the Home page 'Active Schedule' then none of the remaining schedules will ever run, however
if any other remaining schedules <u>are</u> required then just re-enter one of those schedules to reactivate the remaining schedules.</li>
<li><p class="ex2">The APM power calculation is performed every 3 minutes as default using Crontab but may be altered according to requirements. If you are running an air conditioner under APM then also take account of the aircons short cycling delay protection which is usually about 3-5 mins. </li>
<li><p class="ex2">The timer relies on regular schedules to nudge all of the schedules along. As time creeps on there will eventually be only one left to run, it is this last one that will finally nudge all the schedules for the next days run.</li>
<a href="<?= $baseUrl ?>/help2.php" onclick="javascript:void window.open(
   '<?=$baseUrl."/rasptimer/help2.php"?>','1439010501199','width=1100,height=850,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
          return false;"><div align="right">...hardware</div></a>

