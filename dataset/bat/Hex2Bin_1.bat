@ECHO OFF
:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "hex2bin 0xF7" or "hex2bin F7" both return "11110111"
SETLOCAL
SET Hex=%~1
IF /I "%Hex:~0,2%"=="0x" SET Hex=%Hex:~2%
PHP -r print(decbin(hexdec(%Hex%)));
ENDLOCAL
