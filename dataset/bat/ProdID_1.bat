@ECHO OFF
ECHO.
IF NOT [%1]==[] GOTO Syntax
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Export registry tree to a temporary file
START /WAIT REGEDIT /E "%Temp%.\test.dat" "HKEY_LOCAL_MACHINE\Software\Microsoft\Windows NT\CurrentVersion"
:: Read the required value from the temporary file
FOR /F "tokens=1* delims==" %%A IN ('TYPE "%Temp%.\test.dat"') DO IF /I %%A=="ProductId" SET ProductID=%%B
:: Remove the quotes
IF DEFINED ProductID SET ProductID=%ProductID:"=%
:: Delete the temporary file
IF EXIST "%Temp%.\test.dat" DEL "%Temp%.\test.dat"
:: Display the result
SET ProductID
:: Done
GOTO:EOF

:Syntax
ECHO ProdID.bat,  Version 1.00 for Windows NT 4 / 2000 / XP
ECHO Display Windows' Product ID and store its value in an
ECHO environment variable "ProductID"
ECHO.
ECHO Usage:  PRODID
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
