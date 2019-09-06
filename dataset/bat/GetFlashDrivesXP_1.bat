@ECHO OFF
:: Check Windows version and command line arguments (none required)
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT  "%~1"==""           GOTO Syntax

:: Read the list of physical drives from the registry, and show only the CDROM drives
FOR /F "tokens=2 delims=\ " %%A IN ('REG Query "HKLM\SYSTEM\MountedDevices" /s ^| FIND "\DosDevices\" ^| FINDSTR /R /E /C:" 5F[0-9A-F]*"') DO ECHO.%%A
GOTO:EOF

:Syntax
ECHO.
ECHO GetFlashDrivesXP.bat,  Version 1.00 for Windows XP and later
ECHO List all removable ("Flash") drives on the local computer
ECHO.
ECHO Usage:   GETFLASHDRIVESXP
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
