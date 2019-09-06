:: http://www.robvanderwoude.com/batchphp.php
:: Returns natural logarithm of specified value
:: Usage:  "Ln 100" returns "4.6051701859881", "Ln 2.71828" returns "0.99999932734728"
@IF NOT "%~1"=="" PHP -r print(log(%~1));
