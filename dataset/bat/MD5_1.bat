:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "MD5 teststring" returns the MD5 checksum for "teststring"
@IF NOT "%~1"=="" PHP.EXE -r "print(md5('%~1'));"