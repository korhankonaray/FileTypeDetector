:: http://www.robvanderwoude.com/batchphp.php
:: Returns e raised to the power of the specified number
:: Usage:  "Exp 1" returns "2.718281828459", "Exp 5" returns "148.41315910258"
@IF NOT "%~1"=="" PHP -r print(exp(%~1));
