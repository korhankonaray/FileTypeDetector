@ECHO OFF
:: Check Windows version and command line arguments
VER | FIND "Windows 2000" >NUL
IF ERRORLEVEL 1 GOTO Syntax
IF NOT [%1]==[] IF /I NOT [%1]==[/F] IF /I NOT [%1]==[/R] GOTO Syntax
IF NOT [%2]==[] GOTO Syntax

:: Export registry data to temporary file
START /WAIT REGEDIT /E "%Temp%.\_drives.dat" "HKEY_LOCAL_MACHINE\SYSTEM\MountedDevices"
ECHO.

:: Read data from temporary file
FOR /F "tokens=3,5 delims=\:," %%A IN ('TYPE "%Temp%.\_drives.dat" ^| FIND /I "\\DosDevices\\" ^| SORT') DO IF 0x%%~B LSS 0x60 (
	IF /I NOT [%1]==[/F] ECHO %%A:	Removable
) ELSE (
	IF /I NOT [%1]==[/R] ECHO %%A:	Fixed
)

:: Remove temporary file
IF EXIST "%Temp%.\_drives.dat" DEL "%Temp%.\_drives.dat"

:: Done
GOTO:EOF


:Syntax
ECHO.
ECHO Drives.bat,  Version 1.01 for Windows 2000
ECHO Display local drives plus types
ECHO.
ECHO Usage:  DRIVES  [ /type ]
ECHO.
ECHO Where:  /type   may be either /F to display Fixed disks only,
ECHO                            or /R to display Removable disks only
ECHO.
ECHO Note:   Removable drives that aren't currently available may still be displayed
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
