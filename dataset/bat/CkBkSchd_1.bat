@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Keep variables local
SETLOCAL

:: Check command line arguments -- only 1 allowed: a remote computer name
IF NOT "%~2"=="" GOTO Syntax
ECHO "%~1" | FINDSTR.EXE /R /I    /C:"[/?]" >NUL && GOTO Syntax
ECHO "%~1" | FINDSTR.EXE /R /I /B /C:".-"   >NUL && GOTO Syntax

:: Check the first command line argument: optional remote
:: computer name; if specified, PING it to check connectivity
IF "%~1"=="" (
	SET Node=%ComputerName%
) ELSE (
	PING.EXE %~1 2>NUL | FIND.EXE "TTL=" >NUL
	IF ERRORLEVEL 1 (
		ECHO Unable to connect to %~1
		GOTO:EOF
	)
	SET Node=%~1
)

:: Locate the directory where the Scheduled Tasks are located
SET TaskDir=
:: Try WMIC first
FOR /F "tokens=2 delims==" %%A IN ('WMIC.EXE /Node:%Node% Path Win32_OperatingSystem Get WindowsDirectory /Format:List 2^>NUL') DO SET TaskDir=\\%Node%\%%A\Tasks
:: If not found, try the default locations
IF DEFINED TaskDir (
	SET TaskDir=%TaskDir::=$%
) ELSE (
	IF EXIST \\%Node%\C$\WINDOWS\Tasks SET TaskDir=\\%Node%\C$\WINDOWS\Tasks
	IF EXIST \\%Node%\C$\WINNT\Tasks   SET TaskDir=\\%Node%\C$\WINNT\Tasks
)
:: If still not found, abort the mission
IF NOT DEFINED TaskDir (
	ECHO Unable to locate Scheduled Tasks folder on %Node%
	GOTO:EOF
)

:: Check if JT.EXE is available and if not, offer to download it
SET JTAvailable=
SET Download=
JT.EXE /? >NUL 2>&1
IF ERRORLEVEL 1 (
	SET JTAvailable=No
	ECHO.>CON
	ECHO This batch file requires Microsoft's JT utility.>CON
	SET /P Download=Do you want to download it now? [y/N] >CON
)

:: Start download if requested
IF /I "%Download%"=="Y" (
	START "JT" "ftp://ftp.microsoft.com/reskit/win2000/jt.zip"
	ECHO.>CON
	ECHO Install the downloaded file and make sure JT.EXE is in the PATH.>CON
	ECHO Then try again.>CON
)

:: Abort if JT.EXE is not available yet
IF "%JTAvailable%"=="No" GOTO End

:: Check all Scheduled Tasks with the word "backup" in their names
FOR %%A IN ("%TaskDir%\*backup*.job") DO CALL :CheckJob "%%~fA"

ENDLOCAL
GOTO:EOF


:CheckJob
SETLOCAL
SET ScheduledTask="%~1"
FOR /F "tokens=1*" %%B IN ('JT.EXE /LJ %ScheduledTask% /PJ ^| FINDSTR.EXE /R /B /C:"  MostRecentRun:"') DO SET MostRecentRun=%%C
FOR /F "tokens=1*" %%B IN ('JT.EXE /LJ %ScheduledTask% /PJ ^| FINDSTR.EXE /R /B /C:"  NextRun:"      ') DO SET NextRun=%%C
FOR /F "tokens=1*" %%B IN ('JT.EXE /LJ %ScheduledTask% /PJ ^| FINDSTR.EXE /R /B /C:"  StartError:"   ') DO SET StartError=%%C
FOR /F "tokens=1*" %%B IN ('JT.EXE /LJ %ScheduledTask% /PJ ^| FINDSTR.EXE /R /B /C:"  ExitCode:"     ') DO SET ExitCode=%%C
SET ScheduledTask
SET MostRecentRun
SET NextRun
SET StartError
SET ExitCode
ECHO.
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO CkBkSchd.bat (ChecK BacKup SCHeDuled tasks),  Version 0.10 for Windows 2000/XP
ECHO Display the status of all Scheduled Tasks with the word "backup" in their names
ECHO.
ECHO Usage:  CKBKSCHD.BAT  [ remote_computer ]
ECHO.
ECHO Output: ScheduledTask="\\remote_computer\C$\WINNT\Tasks\My daily backup.job"
ECHO         MostRecentRun=06/25/2008 22:40:00
ECHO         NextRun=06/26/2008 22:40:00
ECHO         StartError=S_OK
ECHO         ExitCode=0
ECHO.
ECHO Notes:  Requires Microsoft's JT, and will prompt you to download it from
ECHO         ftp://ftp.microsoft.com/reskit/win2000/jt.zip if it isn't found.
ECHO         This batch file will fail on remote non-XP computers that have
ECHO         Windows installed in a non-default partition, i.e. multi-boot.
ECHO         Modify the FOR command in line 66 to query other Scheduled Tasks.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" ENDLOCAL
