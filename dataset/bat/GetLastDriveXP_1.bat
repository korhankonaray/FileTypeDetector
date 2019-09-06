@ECHO OFF
:: Check Windows version and command line arguments (none required)
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT  "%~1"==""           GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION

:: Read the list of physical drives from the registry, and save only the last one
FOR /F "tokens=2 delims=\ " %%A IN ('REG Query "HKLM\SYSTEM\MountedDevices" /s ^| FIND "\DosDevices\"') DO (
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
ECHO GetLastDriveXP.bat,  Version 1.00 for Windows XP
ECHO Return the last ("highest") drive letter used
ECHO.
ECHO Usage:   GETLASTDRIVEXP
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
