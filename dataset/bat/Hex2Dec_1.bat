@ECHO OFF
:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "hex2dec 0xF" or "hex2dec F" both return "15"
SETLOCAL
SET Hex=%~1
IF /I "%Hex:~0,2%"=="0x" SET Hex=%Hex:~2%
PHP -r print(hexdec(%Hex%));
ENDLOCAL
