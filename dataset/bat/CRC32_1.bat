:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "crc32 teststring" returns the CRC32 checksum for "teststring"
@IF NOT "%~1"=="" PHP.EXE -r "print(crc32('%~1'));"
