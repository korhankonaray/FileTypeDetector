@ECHO OFF
:: Check command line arguments and Windows version
IF NOT "%OS%"=="Windows_NT"    GOTO Syntax

:: Keep variables local
SETLOCAL

:: Check command line arguments and Windows version
IF NOT  "%~2"==""              GOTO Syntax
ECHO.%* | FIND.EXE "?" >NUL && GOTO Syntax
ECHO.%* | FIND.EXE "/" >NUL && GOTO Syntax

:: Check if DEVCON.EXE is available and if not, offer to download it
SET DevconAvailable=
SET Download=
DEVCON.EXE /? >NUL 2>&1
IF ERRORLEVEL 1 (
	SET DevconAvailable=No
	ECHO This batch file requires Microsoft's DEVCON untility.
	SET /P Download=Do you want to download it now? [y/N] 
)

:: Start download if requested
IF /I "%Download%"=="Y" (
	START "DevCon" "http://support.microsoft.com/default.aspx?scid=kb;EN-US;Q311272"
	ECHO.
	ECHO Install the downloaded file and make sure DEVCON.EXE is in the PATH.
	ECHO Then try again.
)

:: Abort if DEVCON.EXE is not available yet
IF "%DevconAvailable%"=="No" GOTO End

:: Check if a valid remote computer was specified
IF "%~1"=="" GOTO Run
SET PC=%~1
SET PC=%PC:\=%
PING.EXE %PC% -n 2 2>NUL | FIND.EXE "TTL=" >NUL && SET PC=-m:\\%PC%

:: List all harddisks
:Run
ECHO Model:                        Interface:  Revision:
ECHO.======                        ==========  =========
FOR /F "tokens=1,2* delims=\" %%A IN ('DEVCON.EXE %PC% Find ^=DiskDrive ^| FIND.EXE /V "USBSTOR\" ^| FIND.EXE ":"') DO CALL :List "%%~A" "%%~B" "%%~C"
GOTO:EOF


:List
(SET ThirtySpaces=                              )
SET Interface=%~1%ThirtySpaces%
SET Revision=%~2
SET Revision=%Revision:_= %
FOR %%a IN (%Revision%) DO SET Revision=%%a
FOR /F "tokens=1* delims=:" %%a IN ('ECHO.%3') DO SET Model="%%~b"
SET Model=%Model:~0,30%
SET Model=%Model:"=%%ThirtySpaces%
SET Model=%Model:~1,30%
ECHO.%Model%%Interface:~0,12%%Revision%
GOTO:EOF


:Syntax
ECHO.
ECHO HardDisk.bat,  Version 1.00 for Windows 2000 / XP / Server 2003
ECHO List harddisks, their interfaces and revision numbers for any PC on the network
ECHO.
ECHO Usage:  HARDDISK  [ remote_computer ]
ECHO.
ECHO Where:  "remote_computer"  is the optional name of the remote PC to be queried
ECHO                            (default is the local computer)
ECHO.
ECHO Note:  This batch file requires Microsoft's DEVCON.EXE, available at
ECHO        http://support.microsoft.com/default.aspx?scid=kb;EN-US;Q311272
ECHO        You will be prompted for download if it isn't found.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:: Discard of local variables
IF "%OS%"=="Windows_NT" ENDLOCAL
