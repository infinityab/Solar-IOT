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
<p class="ex2">The Solar IOT consists of 4 basic functions, the <b>Schedules</b> which program the on/off times,
the <b>Configure</b> which adds conditions such as Auto, Suspend, Day-of-Week etc, the <b>Auto</b> Power Management
 which automatically allocates any surplus solar power, and lastly the <b>Graphics</b>
with shows the on/off times of appliances both current and historic.<br>
<p class="ex2"><b>FUNCTIONS</b><br>
<b>Change Schedule</b> - used to set up the various schedule times or to switch off a scheduled appliance.<br>
<b>TurnOn/Off</b> - manually turn on or off an appliance for various times or terminate a current schedule. This wont work in APM mode unless it is run within the timespan of an existing schedule.
<br><b>Auto</b> - used for Auto Power Management (APM), 0=OFF any other number=ON, power calculated in order of number, 1 = first, 2 next and so on. The APM function works within any existing schedule so prudent to set aside a wider ranging schedule or one that may be optionally suspended for this purpose. NOTE Auto 1 is targeted at the HWS to enable a different mix of Auto and Timer. Do not use Auto 1 if not required. 
<br><b>Auto On Time</b> - this is set on the Configure page and is used to determine the hours that you want AUTO to be applied. Outside of these hours AUTO is ignored. HWS Auto is the same but reserved for Auto 1 to allow for additional flexablity enabling a different mix of Auto and Timer during daylight hours, for example the HWS to ensure hot water at days end.
<br><b>Power</b> - the actual power indicated on the appliances label. This is used in the overall true power calculation, once set this should never be altered.
<br><b>Trigger</b> - the trigger ON point for the AUTO power calculation in watts. When free power is available the appliance trigger value is matched against free power and if available is switched on. As free power drops below a required level (power available + Power Lag) an appliance may be switched off.
<br><b>Suspend</b> - used to temporarily NOT run an appliance for a particular schedule but leaves the schedules intact.
<br><b>Day of Week</b> - individual days may be set to switch on or off for any day for an appliance.
<br><b>Power Lag</b> - Power Lag is like the hysterisis of a thermostat. It is added to the solar power available when determining whether there is enough to keep an appliance ON. This reduces constant ON-OFF-ON switching every time the power drops slightly due to say a fridge or freezer starting up.
<br><p class="ex1"><b>Tricks and Tips</b>
<ul><li><p class="ex2">Schedules do NOT have to be in order but obviously it is easier to follow if they are.</li>
<li><p class="ex2">Timer Schedules are triggered from their start time if this is missed it wont start. Auto schedules just look at the time ranges and trigger if ALL other conditions are met</li>
<li><p class="ex2">If the <u>current status</u> for an appliance shows 'not scheduled' in the Home page 'Active Schedule' then none of the remaining schedules will ever run, however
if any other remaining schedules <u>are</u> required then just re-enter one of those schedules to reactivate the remaining schedules.</li>
<li><p class="ex2">The APM power calculation is performed every few minutes depending how you have set it in Crontab. If you are running an air conditioner under APM then also take account of the aircons short cycling delay protection which is usually about 3-5 mins and set the Crontab CHECK-POWER.SH accordingly. </li>
<li><p class="ex2">The timer relies on regular schedules to nudge all of the schedules along. As time creeps on there will eventually be only one left to run, it is this last one that will finally nudge all the schedules for the next days run.</li>
<a href="<?= $baseUrl ?>/help2.php" onclick="javascript:void window.open(
   '<?=$baseUrl."/rasptimer/help2.php"?>','1439010501199','width=1100,height=850,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
          return false;"><div align="right">...hardware</div></a>

