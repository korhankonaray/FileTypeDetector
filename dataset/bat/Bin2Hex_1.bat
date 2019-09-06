:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "bin2hex 11001101" returns "0xCD"
@PHP -r print('0x'.strtoupper(dechex(bindec(%~1))));
