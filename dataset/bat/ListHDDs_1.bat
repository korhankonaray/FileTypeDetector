@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF     "%~1"=="" GOTO Syntax
IF NOT "%~2"=="" IF /I NOT "%~2"=="/C" GOTO Syntax
ECHO.%1| FINDSTR /R /C:"[^A-Z0-9_-]" >NUL && GOTO Syntax
PING %~1 2>NUL | FIND "TTL=" >NUL || GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION

SET Computer=%~1

:: Check if WMIC.EXE is available
WMIC.EXE /? >NUL 2>&1 && GOTO :WMIC

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
IF "%DevconAvailable%"=="No" (
	ENDLOCAL
	GOTO:EOF
)

:: Query the remote computer and store the results in variables
:: List IDE and SATA devices first
SET Count=-1
FOR /F "tokens=1,2* delims=[]: " %%A IN ('DEVCON -m:\\%Computer% Find =DiskDrive IDE\DISK* ^| FIND /N ":"') DO (
	Set /A Count = %%A - 1
	SET %1.HDD.!Count!=%%C
)
:: Next list SCSI devices
SET IntCnt=%Count%
FOR /F "tokens=1,2* delims=[]: " %%A IN ('DEVCON -m:\\%Computer% Find =DiskDrive SCSI\DISK* ^| FIND /N ":"') DO (
	Set /A Count = %%A + %IntCnt%
	SET Model=%%C
	REM Remove " SCSI Disk Device" from model string
	SET Model=!Model:~0,-17!
	REM Remove inconsistent trailing spaces
	IF "!Model:~-1,1!"==" " SET Model=!Model:~0,-1!
	SET %1.HDD.!Count!=!Model!
)

GOTO :Display

:WMIC
SET Count=-1
FOR /F "skip=1 tokens=2 delims=," %%A IN ('WMIC.EXE /Node:%Computer% /Output:STDOUT Path Win32_DiskDrive Where ^(InterfaceType^="SCSI" Or InterfaceType^="IDE"^) Get Model /Format:CSV ^| FIND ","') DO (
	SET /A Count += 1
	SET Model=%%A
	ECHO.!Model! | FIND "SCSI Disk Device" >NUL
	IF NOT ERRORLEVEL 1 (
		REM Remove " SCSI Disk Device" from model string
		SET Model=!Model:~0,-17!
		REM Remove inconsistent trailing spaces
		IF "!Model:~-1,1!"==" " SET Model=!Model:~0,-1!
	)
	SET %1.HDD.!Count!=!Model!
)

:Display
SET /A %1.HDD.Count = %Count% + 1
IF /I "%~2"=="/C" (
	REM Comma delimited
	SET Result="%Computer%","!%1.HDD.Count!"
	FOR /L %%A IN (0,1,!%1.HDD.Count!) DO (
		IF %%A LSS !%1.HDD.Count! (
			SET Result=!Result!,"!%1.HDD.%%A!"
		)
	)
	ECHO.!Result!
) ELSE (
	REM Default list format
	SET %1.HDD
)

ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO ListHDDs.bat,  Version 1.11 for Windows 2000 / XP
ECHO List all harddisk models of the specified computer
ECHO.
ECHO Usage:  LISTHDDS  computer  [ /C ]
ECHO.
ECHO Where:  computer  is the remote computer name or IP address
ECHO         /C        forces comma delimited output (default is list)
ECHO.
ECHO Note:   Requires either WMIC or DEVCON to query the remote computer.
ECHO         If neither is available, you will be prompted to open the DEVCON
ECHO         download page on microsoft.com
ECHO.
ECHO Sample output (default list format):
ECHO %ComputerName%.HDD.0=SAMSUNG HD103UJ
ECHO %ComputerName%.HDD.1=WDC WD10 EACS-22D6B0
ECHO %ComputerName%.HDD.Count=2
ECHO.
ECHO or comma delimited:
ECHO "%ComputerName%","2","SAMSUNG HD103UJ","WDC WD10 EACS-22D6B0"
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" ENDLOCAL
