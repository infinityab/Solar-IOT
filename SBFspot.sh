#!/bin/bash
/usr/local/bin/sbfspot.3/SBFspot -v
# /usr/bin/php /var/www/rasptimer/check-power.php
/usr/local/bin/sbfspot.3/SBFspot -v -nocsv -nosql -finq | cut --complement -s -f79 > /home/pi/sbfspot.log
/usr/bin/php /var/www/rasptimer/check-consumption.php
