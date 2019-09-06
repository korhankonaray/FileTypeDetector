:: http://www.robvanderwoude.com/batchphp.php
:: Returns square root of specified value
:: Usage:  "Sqrt 36" returns "6", "Sqrt 81" returns "9"
@IF NOT "%~1"=="" PHP -r print(sqrt(%~1));
