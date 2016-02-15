Rasptimer - Solar Timer Scheduler
=========

Use Raspberry Pi as a schedulable timer for GPIO hardware, configurable over the web by PC, tablet or smartphone.

This uses the core software for the original pool timer project conceived by Johannes Ernst and described at http://upon2020.com/blog/2012/12/my-raspberry-pi-pool-timer-why/ and Alan Stead's later additions with my further additions in this version to make it a fully fledged multi-schedule timer with auto power management for as many appliances/devices as there are Pi GPIO ports available.

This should run on any Linux-based OS, although installation instructions
were written for raspbian. You just need Apache Server and WiringPi, PHP is used for the server side application.

You can schedule devices connected to any GPIO pin to be on and off at up to 4 arbitrary times throughout a day. Individual days are also programmable. Devices/appliances may also be manually switched on and off and the timers may also be nudged or bumped in 15 minute steps if required or even suspended from running. Any device(s) may be set for auto power management (APM) and provision is also made for WiFi and Wireless operated devices. There is a textual log, and graphical log. See also directory screenshots.

SMA Inverter solar data and actual total power consumption may also extracted and displayed on the timer for APM.

The Pi header pins are buffered and inverted with a 74HFC04 inverter and then fed into one or two optically isolated 4 x relay module boards thus providing 4-8 240V/110V AC switchable outlets which in turn can directly drive appliances or trigger contactors. Be aware that ratings quoted on relays are for resistive loads, inductive loads will be about a quarter of that. See directory hardware/. The HFC version inverter is selected because it has input clamping for 3v3 operation to match the Pi GPIO pins.

Wireless driven AC sockets may also be triggered anywhere on the premises using a wireless cell structure within the premises built into the wifi client units as wireless relay points. This can be used to switch any plug driven mobile appliance such as heaters etc. A major hardware store pack of wireless sockets was used although probably any other will work. See details in screenshots folder. The wireless codes used on the wireless sockets are discovered using Arduino/ESP8266 RCSwitch software.

For Solar users - If you have installed the Power Meter project to constantly update the current power consumption then Auto Power Management may be optionally used, this works extremely well. The Auto Power Magagement feature allows the user to set a power target to reach before an APM appliance/device is switched on and this can be done via Wifi, Wireless or directly by contacter switching - it just depends on the way you have set it up. Every appliance that is to be included in the power calculation needs to have a power target entered. So for instance water heater 2400 watts #1 priority, Fan Heater 1000W (by wireless) or AirCon 1800W (by WiFi) so these could be set to #2 priority, pool pump 1200W this set to say #3 priority. Thus in this example once the water heater power is used up and there is still surplus solar the calculation can be carried forward and if say 1Kw surplus is available a signal is transmitted to the wireless socket for the heater and it switches on. This is recalculated at 3 minute interval (settable) so if the power drops it will be commanded to switch off. In practice this all works perfectly and like magic with appliances going on and off according to the power available. In summer for a small air conditioner a WiFi unit is used. The aircon is placed in standby and the WiFi units relay connected across the start switch and a pulse command is sent (simulating a press of the start button) - simple but effective. 

Power Lag - this is basically the OFF hysterisis of the power calculation. So after making an allowance of say 500W for appliances like fridges, deep freeze which you have no control over, etc if the appliance that is ON is using say 2400W and the the Lag is 500W then the power available for the calculation to switch the appliance OFF is 2900W. So if the consumption suddenly rises by say 300W due to a fridge starting up then there will still be enough power in the calculation to keep the appliance ON thus reducing the possible yoyoing OFF-ON-OFF-ON effect.

Installing the Software 
First install Raspbian and wifi network drivers if required - see Raspberry Pi site for details, PUTTY may also be useful to access Pi remotely. Then -

Installation:
    
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
    sudo git clone https://github.com/infinityab/Rasptimer-Solar-Timer-Scheduler.git rasptimer
    touch /var/log/rasptimer.log
    chown www-data /var/log/rasptimer.log, config.php and config2.php
    sudo echo www-data > /etc/at.allow

then using vi or nano enter your Raspberry Pi input/output configuration by editing vi rasptimer/config.php and the schedules /rasptimer/config2.php - you should just have to set names and pins you want to use and your timer program entries will do the rest.

If you have an SMA solar inverter installed and you are using SBFspot to gather the SMA data you can also display this and apply as auto power management to the timer - to do so set up a 2 and 5 minute cron job - type sudo crontab -e     ...and then add the line

*/2 6-20 * * * /home/pi/scripts/power-check.sh > /dev/null
*/5 6-23 * * * /home/pi/scripts/SBFspot.sh > /dev/null

This will generate a curtailed logfile which the instananeous inverter power data is extracted from for display. Make sure you put the SBFspot.sh file and power-check.sh file in the /home/pi/scripts folder

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
    
    To Add a Watchdog Timer in case of Pi hanging - thanks to Ricardo Cabral
    
     To load the watchdog kernel module right now, issue the following command:
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
11	0	17	 GPIO 0 	   
12	1	18	 GPIO 1 	   
13	2	27	 GPIO 2 	   
15	3	22	 GPIO 3 	   
16	4	23	 GPIO 4 	   
18	5	24	 GPIO 5 	   
22	6	25	 GPIO 6 	   
7	7	4	 GPIO 7 	   
3	8	2	 SDA    	   
5	9	3	 SCL    	   
24	10	8	 CE0    	   
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
