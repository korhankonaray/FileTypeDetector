@ECHO OFF
:: Check Windows version
IF "%OS%"=="Windows_NT" (SETLOCAL) ELSE (GOTO Syntax)
VER | FIND "Windows NT" >NUL && GOTO Syntax

:: Check command line arguments
IF NOT "%~1"=="" IF /I NOT "%~1"=="/A" GOTO Syntax

:: Check if DEVCON.EXE is available and if not, offer to download it
SET DevconAvailable=
SET Download=
DEVCON.EXE /? >NUL 2>&1
IF ERRORLEVEL 1 (
	SET DevconAvailable=No
	ECHO This batch file requires Microsoft's DEVCON utility.
	SET /P Download=Do you want to download it now? [y/N] 
)

:: Start download if requested
IF /I "%Download%"=="Y" (
	START "DevCon" "http://support.microsoft.com/default.aspx?scid=kb;EN-US;Q311272"
	ECHO.
	ECHO Install the downloaded files and make sure DEVCON.EXE is in the PATH.
	ECHO Then try again.
)

:: Abort if DEVCON.EXE is not available yet
IF "%DevconAvailable%"=="No" GOTO End

:: Initialize variables
SET Log="Drivers\%~n0.log"
SET TmpFile="%Temp:"=%.\_DevCon.dat"
SET Counter=0
SET Error=0

:: Create backup "root" directory
IF NOT EXIST Drivers\ MD Drivers

:: Remove old log file if it exists
IF EXIST %Log% DEL %Log%

:: Display welcome message
CLS
ECHO Gathering info, please wait...
ECHO.

:: Choose between all devices or just the active ones
IF /I "%~1"=="/A" (SET FindDev=FindAll) ELSE (SET FindDev=Find)

:: Find all drivers, including inactive ones, and start backup subroutine for each one
FOR /F "tokens=1* delims=: " %%A IN ('DEVCON %FindDev% * ^| FIND "\"') DO CALL :Driver "@%%A" "%%B"

:: Display summary
ECHO.
ECHO Backupped driver files for %Counter% devices

:: Log summary
>> %Log% ECHO.
>> %Log% ECHO Backupped driver files for %Counter% devices

:: Display warning message if copy errors were encountered
IF %Error% GTR 0 (
	ECHO.
	IF %Error% EQU 1 (
		ECHO An error was encountered while copying,
	) ELSE (
		ECHO %Error% errors were encountered while copying,
	)
	ECHO Please check the log file %Log%
)

:: Done
ENDLOCAL
GOTO End


:: :: :: :: ::  Backup subroutine  :: :: :: :: ::
:Driver
:: Drivers without description ususally have no driver files
:: defined, so abort if no description is available
IF "%~2"=="" GOTO:EOF
:: Remove old temporay file
IF EXIST %TmpFile% DEL %TmpFile%
:: Store DEVCON info in a temporary file to speed up processing
DEVCON DriverFiles %1 > %TmpFile% 2>NUL
:: Exit subroutine if there are no files to backup
TYPE %TmpFile% | FIND ":\" >NUL
IF ERRORLEVEL 1 GOTO:EOF
:: Use variables that are local to the subroutine
SETLOCAL
:: On the first call to the subroutine, clear the screen
IF %Counter% EQU 0 CLS
:: Display and log which device is being processed
ECHO Backing up driver for "%~2"
>> %Log% ECHO Backing up driver for "%~2"
:: "Escape" the device name, so it can be used as a directory name
SET Name="%~2"
SET Name=%Name:/=_%
SET Name=%Name::=_%
SET Name=%Name:;=_%
SET Name=%Name:,=_%
SET Name=%Name:(=[%
SET Name=%Name:)=]%
SET Name=%Name:&=_and_%
SET Name=%Name:"=%
:: Extract the "class" name from the device ID
FOR /F "tokens=1 delims=\" %%K IN ('TYPE %TmpFile% ^| FIND "\" ^| FIND /V ":"') DO SET Class=%%K
:: Extract the INF file name
FOR /F "tokens=1 delims=[" %%K IN ('TYPE %TmpFile% ^| FIND /I "Driver installed from"') DO SET Inf=%%~K
IF DEFINED Inf FOR /F "tokens=3* delims= " %%K IN ('ECHO.%Inf%') DO SET Inf=%%L
:: Backup the INF file, and log and count any errors
IF DEFINED Inf (
	XCOPY "%Inf:~0,-1%" "Drivers\%Class%\%Name%\*.*" /H /R /D >NUL 2>>%Log%
	IF ERRORLEVEL 1 SET /A Error = %Error% + 1
)
:: Backup the driver files, and log and count any errors
FOR /F "tokens=* delims= " %%K IN ('TYPE %TmpFile% ^| FIND ":\" ^| FIND /I /V "Driver installed from"') DO (
	XCOPY "%%~K" "Drivers\%Class%\%Name%\*.*" /H /R /D >NUL 2>>%Log%
	IF ERRORLEVEL 1 SET /A Error = %Error% + 1
)
:: Increment the device counter
SET /A Counter = %Counter% + 1
:: Clean up
IF EXIST %TmpFile% DEL %TmpFile%
:: Exit the subroutine, dropping all local variables except the counters
ENDLOCAL & (SET Counter=%Counter%) & (SET Error=%Error%)
GOTO:EOF


:Syntax
ECHO.
ECHO BkAllDrv.bat,  Version 1.06 for Windows 2000 / XP
ECHO Backup all Windows device drivers, optionally including even inactive ones
ECHO.
ECHO Usage:  BKALLDRV  [ /A ]
ECHO.
ECHO Where:  /A  forces backup of drivers for both active and inactive devices
ECHO             (default is active devices only)
ECHO.
ECHO Notes:  [1] This batch file requires Microsoft's DEVCON.EXE, available at
ECHO             http://support.microsoft.com/default.aspx?scid=kb;EN-US;Q311272
ECHO             You will be prompted for download if it isn't found.
ECHO         [2] Drivers will be backupped in a directory named Drivers, located in
ECHO             the current directory.
ECHO         [3] Devices with duplicate names will overwrite each other's files.
ECHO         [4] If errors are encountered you will be prompted to check a log file.
ECHO         [5] This batch file is much slower than its Perl or Rexx equivalents.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
IF "%OS%"=="Windows_NT" ENDLOCAL
