# Solar-IOT
Automatically control heaters, aircons, hot water heater, pool pumps and other appliances based on Solar production using WiFi, Wireless or direct switching.


Use Raspberry Pi as a controller alongside SBFspot for Auto or Timer switching appliances with choices of activation using WiFi, Wireless and/or Contactor relay, monitored and configurable over your local network by PC, tablet or smartphone.

This was originally based on Johannes Ernst's Poool Timer and described at http://upon2020.com/blog/2012/12/my-raspberry-pi-pool-timer-why/. It uses the core of this with major changes and additions to make it a fully fledged multi-schedule timer controller with auto power management for solar applications. It can control as many appliances/devices as there are Pi GPIO ports available, so about 12 appliances.

This should run on any Linux-based OS, although installation instructions are written for raspbian. You just need Apache Server and WiringPi, PHP is used for the server side application.

You can schedule appliances connected by any of the above methods to be on and off at up to 5 arbitrary times throughout any day or days of a week. Appliances may also be manually switched on and off or suspended from running. Any appliances may be set for auto power management (APM) as well which will operate when there is any excess solar power available. There is also a graphical log which was part of the original core with some extensions and minor changes. See screenshot examples.

SMA Inverter solar data and actual total power consumption from the electricity meter is also extracted and displayed on the timer for APM and sent to PVoutput.

If contactor switching is required at the power board (for large HWS's or heavily inductive loads) the associated Pi header pins are buffered and inverted with a 74HFC04 inverter to drive optically isolated 4 x relay module boards thus providing 4 240V/110V AC switchable outlets which in turn can directly trigger the contactors. If only clientside WiFi (which has it's own relays) or Wireless switching is to be used then the 74' inverter and relay board is not required. Note - The 74HFC04 version inverter was selected because it has input clamping for 3v3 operation to match the Pi GPIO pins rating, it is not absolutely essential to use this but it does offer additional Pi protection and has the advantage of inverting the driver signal to the traditional 0=OFF 1=ON. 

Remote appliances are driven by WiFi clientside units with relays or by Wireless RC sockets (see below). Be aware that ratings quoted on relays are for resistive loads, inductive loads will be about a quarter of that. See the hardware folder. Commands may be for ON or OFF, or Pulse which is for appliances that have 'push start' buttons (aircons etc).

Wireless RC power sockets may also be triggered anywhere on the premises using a wireless cell structure within the premises built into the wifi client units as wireless relay points. This can be used to switch any plug driven mobile appliance such as heaters etc. A standard hardware store pack of cheap wireless RC sockets was used although probably any other will work. See details in screenshots folder. The wireless socket trigger codes discovered using the Arduino desktop IDE software with ESP8266 RC-Switch software and 433MHZ receiver attached. These are cheap devices costing about $1 or so and the utility is included with this project.

* The wireless transmitter may also be located centrally within the house to provide a wider transmission range using a separate ESP8266-12e SOC module with transmitter attached. The antenna for 433MHz should be 17.2 cms in length (1/4 wave length) and may be coiled in the short range clientside units but should be straight on the central unit for a superior range.

For Solar users - If you have installed the Power Meter project to constantly update the current power consumption (you can just use the timer functions without the PM) then Auto Power Management may be optionally used, this works extremely well. The Auto Power Magagement feature allows the user to set a power target to reach before an APM appliance/device is switched on and this can be done via Wifi, WiFi-Wireless or directly by contactor switching - it just depends on the way you have set it up. Every appliance that is to be included in the power calculation needs to have a power target  and a power trigger point entered. So for instance water heater 2400 watts #1 priority, Fan Heater 1000W (by wireless) or AirCon 1800W (by WiFi) so these could be set to #2 priority, pool pump 1200W this set to say #3 priority. Priority (the Auto #) dictates the order of power calculation. Thus in this example once the water heater power is used up and there is still surplus solar the calculation can be carried forward and if say 1Kw surplus is available a signal is transmitted to the wireless socket for the heater and it switches on. This is recalculated at 3 minute interval (settable) so if the power drops it will be commanded to switch off. In practice this all works perfectly and like magic with appliances going on and off according to the power available and note there is an OFF hysterisis in the calculation (settable as Power Lag), the trigger power for each device is the ON hysterisis. In summer for a small air conditioner a WiFi unit is used. The aircon is placed in standby and the WiFi units relay connected across the start switch (for LV use just a cut in half USB extender lead for plug and socket) and a pulse command is sent (simulating a press of the start button) - simple but effective. 

Power Lag Configuration - this is basically the OFF hysterisis of the power calculation. So after making an allowance of say 500W for appliances like fridges, deep freeze which you have no control over, etc if the appliance that is ON is using say 2400W and the the Lag is 500W then the power calculation to switch the appliance OFF is 2900W. So if the consumption suddenly rises by say 300W due to a fridge starting up then there will still be enough power in the calculation to keep the appliance ON thus reducing the possible yoyoing OFF-ON-OFF-ON effect.
___
###The Main Software Modules - for reference

Crontab - holds all the timed calls (SBFspot, Check-Power etc)

Config .php - holds the Solar-IOT day-to-day configuration for all the schedules and appliances and the Controller setup

Config2 .php - holds all the timer schedules for all the appliances

SBFspot - .sh provided by SBFspot and modified to include additional consumption data
It Reads data from the SMA inverter and uploads to PVoutput (this is standard SBFspot software).

Calls SBFspot .sh again and extracts raw solar power data and stores in log file.

Calls Check-Consumption .php which reads meter data and solar data and then calculates current consumption and uploads to PVoutput.

Check-Power as .sh and .php - this is used for the Auto Power function.
It reads the current meter consumption and calls the checkPowerTargets function to calculate what to switch on or off.


###Main PHP Modules

Show-Status .php - top half of main Solar-IOT page showing schedules

Show-Schedules .php - bottom half of main Solar-IOT page showing schedules

Show-Devices .php - the Configure page where most of the day to day configurations and Auto settings are made

Show-Change-Schedule .php - where changes to the timed schedules are made

Handle-Post .php - called everytime there is a configuration update

Functions .php - all the functions that are called 


###Installing the Software 

Firstly make an image of your existing SD/TF card memory using the free WinDskMgr utility and make it a habit of keeping images of the Pi whenever you do a major change to the Pi memory so you can always fallback. Note use cards that are identical in size. Leave your SBFspot software on the Pi flash card and install Raspbian and wifi network drivers if they are not installed already - see Raspberry Pi site for details, PUTTY SSH software is also extremely useful to access Pi remotely. Then connect and type -


####Installation:
    
    sudo apt-get update
    sudo apt-get install libapache2-mod-php5 git at
    cd ~
    git clone https://github.com/WiringPi/WiringPi.git
    cd WiringPi/wiringPi
    make
    sudo make install
    cd ../gpio
    make
    sudo make install
    cd /var/www
    sudo git clone https://github.com/infinityab/Solar-IOT.git rasptimer
    touch /var/log/rasptimer.log
    chown www-data /var/log/rasptimer.log, config.php and config2.php
    sudo echo www-data > /etc/at.allow

then using Vi or preferably NANO editor enter your Raspberry Pi input/output configuration first switching to the /var/www/rasptimer directory and edit e.g. sudo nano config.php, and the schedules, config2.php - you should just have to set names and pins you want to use and your timer program entries will do the rest DO NOT alter the structure of the files other than reducing the amount of lines. Once you have created and tested the config files make backup copies of them for 'just in case'.

If you have an SMA solar inverter installed and you are using SBFspot to gather the SMA data you can also display this and apply as auto power management to the timer - to do so set up a 3 and 5 minute cron job - type sudo crontab -e and then add the lines

*/3 6-20 * * * /home/pi/scripts/check-power.sh > /dev/null

*/5 0-23 * * * /home/pi/scripts/SBFspot.sh > /dev/null

*/3 6-20 * * * /home/pi/scripts/check-power.sh > /dev/null

*/5 * * * * sudo /home/pi/scripts/wifi-monitor.sh > /dev/null

optionally add WiFi watchdog check above if Pi using its own WiFi

This will generate a curtailed logfile which the instananeous inverter power data is extracted from for display. Make sure you put the SBFspot.sh, check-power.sh and wifi-monitor.sh* files in the /home/pi/scripts folder and set permissions and ownership e.g. 
   sudo chmod 754 check-power.php
   chown pi:pi check-power.php
etc.

note - wifi-monitor is not essential.

The check-power.sh generates curtailed logfile which the instananeous inverter power data is extracted from for part of the calculation this calls check-power.php which extracts the current consumption from the meter box. Make sure you put the SBFspot.sh, power-check.sh and wifi-monitor.sh files in the /home/pi/scripts folder

 - then visit

    http://192.168.0.100/rasptimer/
        (or whatever the IP address of your Raspberry Pi is)

You may need to change to local time so to set up the UTC time zone e.g. :-

$ ln -sf /usr/share/zoneinfo/Australia/Sydney /etc/localtime 

To add a password to the website use vi or nano editor:

    sudo vi /etc/apache2/sites-enabled/000-default 
        In section <Directory /var/www/, change "AllowOverride None" to "AllowOverride AuthConfig"
    sudo a2enmod auth_digest
    sudo service apache2 restart
    sudo htdigest -c /var/www/.htpasswd "Administrators only" admin
        (use any username instead of 'admin')

To enable weekly log rotation:

    sudo cp /etc/logrotate.d/rasptimer logrotate.d-rasptimer /etc/logrotate.d/rasptimer
    
    To Add a Watchdog Timer in case of Pi hanging (thanks to Ricardo Cabral)
    
    To load the watchdog kernel module right now, issue the following commad:
$ sudo modprobe bcm2708_wdog

If you are running Raspbian, to load the module the next time the system boots, add a line to your /etc/modules file with "bcm2708_wdog". The -a option makes sure tee appends instead.
$ echo "bcm2708_wdog" | sudo tee -a /etc/modules

 Install the software watchdog daemon
Run the following command:
$ sudo apt-get install watchdog

Then, make sure it runs after every boot.
Run:
$ sudo update-rc.d watchdog defaults
OR
$ sudo chkconfig --add watchdog

Configure the watchdog daemon
Open /etc/watchdog.conf with your favorite editor.
$ sudo nano /etc/watchdog.conf

Uncomment the line that starts with #watchdog-device by removing the hash (#) to enable the watchdog daemon to use the watchdog device.
Uncomment the line that says #max-load-1 = 24 by removing the hash symbol to reboot the device if the load goes over 24 over 1 minute. A load of 25 of one minute means that you would have needed 25 Raspberry Pis to complete that task in 1 minute. You may tweak this value to your liking.

Start the watchdog daemon
$ sudo chkconfig watchdog on
or
$ sudo /etc/init.d/watchdog start
Done.
    
Pi GPIO Wiring Pin Equivalents
The pin numbers on the Pi as described and used in the config files are the Wiring Pi pin numbers not the Pi header pin numbers, here is a cross reference header chart as used on the Pi for the 26 pin header

HD	Wi	GP	 Name   	   
11  0	17	 GPIO 0 	   
12	1	18	 GPIO 1 	   
13	2	27	 GPIO 2 	   
15	3	22	 GPIO 3 	   
16	4	23	 GPIO 4 	   
18	5	24	 GPIO 5 	   
22	6	25	 GPIO 6 	   
7   7	4	 GPIO 7 	   
3   8	2	 SDA    	   
5   9	3	 SCL    	   
24  10	8	 CE0    	   
26	11	7	 CE1    	   
19	12	10	 MOSI   	   
21	13	9	 MISO   	   
23	14	11	 SCLK   	   
8	15	14	 TxD    	   
10	16	15	 RxD    	   
	17	28	 GPIO 8 	   
	18	29	 GPIO 9 	   
	19	30	 GPIO10 	   
	20	31	 GPIO11 	 

key : HD= Header pin, Wi= WiringPi pin, GP= Broadcom Socket pin number
other header pins : 5V= 2,4, 0V= 6,14,25,9, 3.3V= 1,17 

You can use the following command as a status test of the pins

gpio readall

More information on the wiringpi.com website. 