:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "crc32 teststring" returns the CRC32 checksum for "teststring" in hexadecimal format
@IF NOT "%~1"=="" PHP.EXE -r "print('0x'.strtoupper(dechex(crc32('%~1')&0xFFFFFFFF)));"
