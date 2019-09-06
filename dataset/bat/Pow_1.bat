:: http://www.robvanderwoude.com/batchphp.php
:: Returns first argument raised to the power of second argument
:: Usage:  "Pow 2 3" returns "8", "Pow 3 2" returns "9"
@IF NOT "%~2"=="" PHP -r "print(pow(%1,%2));"
