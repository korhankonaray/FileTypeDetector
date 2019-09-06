:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "SHA1 teststring" returns the SHA-1 checksum for "teststring"
@IF NOT "%~1"=="" PHP.EXE -r "print(sha1('%~1'));"