#!/bin/bash
/usr/local/bin/sbfspot.3/SBFspot -ad0 -am0 -ae0 -nocsv | cut --complement -s -f79 > /home/pi/sbfspot2.log
# SBFspot -v -nocsv -nosql -finq | cut --complement -s -f79 > /home/pi/sbfspot.log
# usr/bin/php /var/www/rasptimer/check-power.php

