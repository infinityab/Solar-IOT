#!/bin/bash
/usr/local/bin/sbfspot.3/SBFspot -v -nocsv -nosql -finq | cut --complement -s -$
/usr/bin/php /var/www/rasptimer/check-power.php