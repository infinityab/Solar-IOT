#!/bin/bash
/usr/local/bin/sbfspot.3/SBFspot -v
# get the raw Solar output from SBFspot log
/usr/local/bin/sbfspot.3/SBFspot -v -nocsv -nosql -finq | cut --complement -s -f79 > /home/pi/sbfspot.log
/usr/bin/php /var/www/rasptimer/check-consumption.php
