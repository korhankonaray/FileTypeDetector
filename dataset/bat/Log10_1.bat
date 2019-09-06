:: http://www.robvanderwoude.com/batchphp.php
:: Returns base-10 logarithm of specified value
:: Usage:  "Log10 100" returns "2", "Log10 25" returns "1.397940008672"
@IF NOT "%~1"=="" PHP -r print(log10(%~1));
