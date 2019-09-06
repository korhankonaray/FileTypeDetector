@ECHO OFF
:: Check Windows version and command line arguments (none required)
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT  "%~1"==""           GOTO Syntax

:: Remove drive letters no longer in use
MOUNTVOL /R

SETLOCAL ENABLEDELAYEDEXPANSION
:: Read the list of physical drives from the registry, and save only the last one
FOR /F "tokens=2 delims=\ " %%A IN ('REG Query "HKLM\SYSTEM\MountedDevices" /v "\DosDevices\*" ^| FIND "\DosDevices\"') DO (
	IF %%A GTR !LastDrive! SET LastDrive=%%A
)
:: Read the list of mapped network drives, and save only the last one
FOR /F "tokens=2" %%A IN ('NET USE ^| FINDSTR /R /C:" [A-Z]: "') DO (
	IF %%A GTR !LastDrive! SET LastDrive=%%A
)
:: Read the list of SUBSTituted drives, and save only the last one
FOR /F "delims=:" %%A IN ('SUBST ^| FINDSTR /R /B /C:"[A-Z]:\\: "') DO (
	IF %%A GTR !LastDrive! SET LastDrive=%%A:
)
ECHO %LastDrive%
ENDLOCAL & SET LastDrive=%LastDrive%
GOTO:EOF

:Syntax
ECHO.
ECHO GetLastDrive.bat,  Version 1.00 for Windows 7 and later
ECHO Return the last ("highest") drive letter used
ECHO.
ECHO Usage:   GETLASTDRIVE
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
