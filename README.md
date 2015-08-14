Rasptimer - Solar Timer Scheduler
=========

Use Raspberry Pi as a schedulable timer for GPIO hardware, configurable over the web.

This is the software for the pool timer project conceived by Johannes Ernst and described at http://upon2020.com/blog/2012/12/my-raspberry-pi-pool-timer-why/ and Alan Stead later additions with further additions in this version to make it a fully fledged multi-schedule timer for currently 6 different appliances/devices which may be increased or decreased as required. 

This should run on any Linux-based OS, although installation instructions
were written for raspbian. You just need Apache, PHP, and WiringPi.

You can schedule devices connected to any GPIO pin to be on and off at
an arbitrary time four times a day. Individual days are also programmable. You can also manually switch the devices on and off. There is a textual log, and graphical log. See also directory screenshots/.

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
    sudo git clone https://github.com/astead/rasptimer-1.git rasptimer
    touch /var/log/rasptimer.log
    chown www-data /var/log/rasptimer.log
    sudo echo www-data > /etc/at.allow

then enter your Raspberry Pi input/output configuration by editing
    vi rasptimer/config.php and the schedules /rasptimer/config2.php - you should just have to set names and your timer program entries will do the rest

then visit

    http://192.168.0.100/rasptimer/
        (or whatever the IP address of your Raspberry Pi is)

To add a password to the website:

    sudo vi /etc/apache2/sites-enabled/000-default
        In section <Directory /var/www/, change "AllowOverride None" to "AllowOverride AuthConfig"
    sudo a2enmod auth_digest
    sudo service apache2 restart
    sudo htdigest -c /var/www/.htpasswd "Administrators only" admin
        (use any username instead of 'admin')

To enable weekly log rotation:

    sudo cp /etc/logrotate.d/rasptimer logrotate.d-rasptimer /etc/logrotate.d/rasptimer

