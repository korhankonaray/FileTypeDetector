:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "wanip" returns your WAN IP address
@PHP -r print(file_get_contents('http://whatismyip.org/'));
