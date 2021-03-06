@ECHO OFF
:: Windows NT 4 / 2000 / XP only
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Localize environment
SETLOCAL

:: Specify temporary REG file name and path
SET _TmpFile="%Temp:"=%.\_DisTMgr.reg"

:: Check command line
IF [%1]==[] (
	ECHO.
	ECHO Current task manager setting:
	GOTO Display
)
IF NOT [%1]==[0] IF NOT [%1]==[1] GOTO Syntax

:: Create temporary REG file
> %_TmpFile% ECHO REGEDIT4
>>%_TmpFile% ECHO.
>>%_TmpFile% ECHO [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\System]
IF [%1]==[0] (>>%_TmpFile% ECHO "DisableTaskMgr"=dword:00000001)
IF [%1]==[1] (>>%_TmpFile% ECHO "DisableTaskMgr"=-)
>>%_TmpFile% ECHO.

:: Merge temporary REG file
START /WAIT REGEDIT /S %_TmpFile%

:: Remove temporary REG file
DEL %_TmpFile%

:: Display "header"
ECHO.
ECHO New task manager setting:

:Display
:: Read current setting from registry and store in temporary file
START /WAIT REGEDIT /E %_TmpFile% "HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\System"

:: Skip further tests if the registry key doesn't even exist
IF NOT EXIST %_TmpFile% (
	SET CurSet=0
	GOTO ResultRead
)

:: Check if value exists
TYPE %_TmpFile% | FIND "DisableTaskMgr" >NUL
IF ERRORLEVEL 1 (
	SET CurSet=0
) ELSE (
	ECHO.
	ECHO [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Policies\System]
	TYPE %_TmpFile% | FIND "DisableTaskMgr"
)

:: Check registry value's value
TYPE %_TmpFile% | FIND "DisableTaskMgr" | FIND "00000001" >NUL
IF ERRORLEVEL 1 (
	SET CurSet=0
) ELSE (
	SET CurSet=1
)

:: Display interpreted result
:ResultRead
ECHO.
IF %CurSet%==1 (
	ECHO Task manager is disabled
) ELSE (
	ECHO Task manager is enabled
)

:: Remove temporary REG file if it exists
IF EXIST %_TmpFile% DEL %_TmpFile%

:: Done
GOTO End


:Syntax
ECHO.
ECHO TaskMgr.bat,  Version 1.00 for Windows NT 4 / 2000 / XP
ECHO Disable or reenable task manager setting
ECHO.
ECHO Usage:   TASKMGR [ option ]
ECHO.
ECHO options: 0       disable task manager
ECHO          1       enable task manager
ECHO          none    show current setting
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com


:End
IF NOT "%OS%"=="Windows_NT" ENDLOCAL
