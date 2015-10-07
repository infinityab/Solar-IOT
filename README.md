Rasptimer - Solar Timer Scheduler
=========

Use Raspberry Pi as a schedulable timer for GPIO hardware, configurable over the web by PC, tablet or smartphone.

This uses the core software for the original pool timer project conceived by Johannes Ernst and described at http://upon2020.com/blog/2012/12/my-raspberry-pi-pool-timer-why/ and Alan Stead's later additions with my further additions in this version to make it a fully fledged multi-schedule timer with auto power management for 6 different appliances/devices which may be increased or decreased as required.

This should run on any Linux-based OS, although installation instructions
were written for raspbian. You just need Apache, PHP, and WiringPi.

You can schedule devices connected to any GPIO pin to be on and off at
an arbitrary time at four different times throughout a day. Individual days are also programmable. Devices/appliances may also be manually switched on and off and the timers may also be nudged or bumped in 15 minute steps if required or even suspended from running. Any device(s) may be set for auto power management and wireless operated sockets are also provided for. There is a textual log, and graphical log. See also directory screenshots/.

SMA Inverter solar data may also extracted and displayed on the timer for intelligent power management. Power consumption data will be added soon (October 2015).

The Pi header pins are buffered and inverted with a 74HFC04 inverter and then fed into one or two optically isolated 4 x relay module boards thus providing 4-8 240V/110V AC switchable outlets which in turn can directly drive appliances or trigger contactors. Be aware that ratings quoted on relays are for resistive loads, inductive loads will be about a quarter of that. See directory hardware/. The HFC version inverter is selected because it has input clamping for 3v operation as well which is used for the wireless transmitter/sockets.

Wireless driven AC sockets may also be triggered anywhere in the premises or within a max. 30m range to switch any plug driven mobile appliance such as heaters etc. The China 'HD' brand version is used although probably any other will work. See circuit details in screenshots folder. 

The Auto Power Magagement feature allows the user to set a power target to reach before the APM appliance/device is switched on and this can be done via wireless or directly by contacter switching - it just depends on the way you have set it up. Every appliance that is to be included in the power calculation needs to have a power target enetered. So for instance water heater 2400 watts (this will nearly be always switched by timer), Power Reserve - this is for things like fridges, deep freeze which you have no control over, Fan Heater 1000W (by Wirelees) so this one is set to highest priority #1, pool pump 1200W this set to say #2 priority. Thus once the water heater power + reserve is used up and there is still surplus solar the calculations can begin and if 1Kw surplus is available a signal is transmitted to the wireless socket for the heater and it switches on. This is recalculated every 2 mins so if the power drops it will be told to switch off. In practice this all works perfectly and like magic with heaters going on and off according to the power available. In summer for a small air conditioner a different wireless unit is used. The aircon is placed in standby and the wireless unit connected across the start switch - simple but effective. The wireless sockets with transmitter are about Aus$10-12 each and wireless switch about $8 all from China. Some extra components are added to the transmitters to interface to the Pi header, a diagram of this will be put in screenshots folder shortly.

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
