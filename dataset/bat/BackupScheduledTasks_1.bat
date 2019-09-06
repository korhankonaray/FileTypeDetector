@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT "%~4"=="" GOTO Syntax
IF NOT "%~1"=="" IF /I NOT "%~1"=="/Backup" IF /I NOT "%~1"=="/Restore" GOTO Syntax
ECHO.%* | FIND "/?" >NUL && GOTO Syntax
SCHTASKS /?  >NUL  2>&1  || GOTO Syntax
IF "%~1"=="" GOTO BackupAll
IF /I "%~1"=="/Backup" (
	IF "%~2"=="" (
		GOTO Syntax
	) ELSE (
		CALL :Backup "%~2"
	)
)
IF /I "%~1"=="/Restore" (
	IF "%~2"=="" (
		ECHO Please specify an XML file
		ECHO.
		GOTO Syntax
	) ELSE (
		IF EXIST "%~2" (
			FOR %%X IN (%2) DO (
				CALL :Restore "%%~fX" %3
			)
		) ELSE (
			ECHO File^(s^) not found: "%~2"
			ECHO.
			GOTO Syntax
		)
	)
)
GOTO:EOF


:Backup
SETLOCAL
SET TaskName=%~1
IF "%TaskName:~0,1%"=="\" SET TaskName=%TaskName:~1%
SCHTASKS /Query /TN "%Taskname%" >NUL 2>&1
IF ERRORLEVEL 1 (
	ECHO Task not found: "%TaskName%"
	ECHO.
	GOTO Syntax
) ELSE (
	SCHTASKS /Query /TN "%TaskName%" /XML > "SCHTASKS.%ComputerName%.Backup.%TaskName%.xml"
)
ENDLOCAL
GOTO:EOF


:BackupAll
SETLOCAL ENABLEDELAYEDEXPANSION
FOR /F "tokens=1*" %%T IN ('SCHTASKS /Query /FO list ^| FINDSTR /R /B /C:"TaskName: " ^| FINDSTR /R /V /C:"\\.*\\."') DO (
	CALL :Backup "%%~U"
)
ENDLOCAL
GOTO:EOF


:Restore
SETLOCAL ENABLEDELAYEDEXPANSION
SET CurrentUser=%ComputerName%\%UserName%
SET XMLFile=%~f1
FOR /F "tokens=3* delims=." %%T IN ("%~n1") DO SET TaskName=%%U
IF NOT EXIST "%XMLFile%" (
	ECHO File not found: "%XMLFile%"
	ECHO.
	GOTO Syntax
)
SET Runas=
SET RunasUser=
FOR /F "tokens=3 delims=<>" %%R IN ('TYPE "%XMLFile%" ^| FIND /I /V "<UserId>%CurrentUser%</UserId>" ^| FIND /I /V "<UserId>SYSTEM</UserId>" ^| FIND /I "<UserId>"') DO (
	SET RunasUser=%%R
)
IF NOT "%RunasUser%"=="" (
	IF "%~2"=="" (
		SET /P RunasPassword=Please enter the password for %RunasUser%: 
		SET Runas=/RU %RunasUser% /RP !RunasPassword!
		CLS
	) ELSE (
		SET Runas=/RU %RunasUser% /RP %2
	)
)
echo SCHTASKS /Create /TN "%TaskName%" /XML "%XMLFile%" %Runas%
SCHTASKS /Create /TN "%TaskName%" /XML "%XMLFile%" %Runas%
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO BackupScheduledTasks.bat,  Version 1.02
ECHO Backup and restore scheduled tasks in Task Scheduler's root folder
ECHO.
ECHO Usage:  Backup all: BACKUPSCHEDULEDTASKS
ECHO         Backup one: BACKUPSCHEDULEDTASKS /Backup "taskname"
ECHO         Restore:    BACKUPSCHEDULEDTASKS /Restore "xmlfiles" [ password ^| /Q ]
ECHO.
ECHO Where:  "taskname" is the name of the scheduled task to be backed up
ECHO         "xmlfiles" XML file^(s^) ^(wildcards allowed^) created by this batch
ECHO                    file's backup command or exported in Task Scheduler's GUI
ECHO         "password" is the password for the task's "runas" user
ECHO         /Q         restores the task, but without the "runas" user's password
ECHO                    ^(must be set manually afterwards^)
ECHO.
ECHO Notes:  Only tasks in the Task Scheduler's root folder will be backed up.
ECHO         Each scheduled task in the Task Scheduler's root folder is saved as an
ECHO         XML file in the current directory, with the task's name for file name.
ECHO         When restoring a scheduled task configured for a user other than the
ECHO         current user or SYSTEM, and neither /Q is specified nor a password
ECHO         provided, then you will be prompted for the "runas" user's password.
ECHO         Note that this password will NOT be masked while being entered.
ECHO         Tested in Windows 7 only.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" EXIT /B 1
