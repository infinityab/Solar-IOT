    #!/bin/bash

       if /sbin/ifconfig wlan0 | grep -q "inet addr:" ; then
        echo
       else
          /sbin/ifup --force wlan0
       fi
