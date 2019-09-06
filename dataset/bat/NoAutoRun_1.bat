@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF /I "%~1"=="/Q" GOTO Run

:Syntax
ECHO NoAutoRun.bat,  Version 1.00 for Windows XP
ECHO Completely disable Windows' AutoRun feature
ECHO.
IF NOT "%OS%"=="Windows_NT" ECHO Usage:  %0  [ /Q ]
IF     "%OS%"=="Windows_NT" ECHO Usage:  %~ns0  [ /Q ]
ECHO.
ECHO Where:  /Q  will suppress screen output and the prompt for confirmation
ECHO.
ECHO Based on an article by Scott Dunn
ECHO http://windowssecrets.com/comp/071108
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF NOT "%OS%"=="Windows_NT" GOTO End
IF NOT "%~1"=="" IF /I NOT "%~1"=="/Q" GOTO End

ECHO.
SET /P Answer=Are you sure you want to disable Windows' AutoRun? [yN] 
ECHO.
IF /I NOT "%Answer%"=="Y" (
	ECHO Script aborted by user request.
	ECHO The AutoRun feature was left unchanged.
	GOTO End
)

:Run
> "%Temp%.\NoAutoRun.reg" ECHO REGEDIT4
>>"%Temp%.\NoAutoRun.reg" ECHO.
>>"%Temp%.\NoAutoRun.reg" ECHO [HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\IniFileMapping\Autorun.inf]
>>"%Temp%.\NoAutoRun.reg" ECHO @="@SYS:DoesNotExist"
>>"%Temp%.\NoAutoRun.reg" ECHO.
START /WAIT REGEDIT.EXE /S "%Temp%.\NoAutoRun.reg"
DEL "%Temp%.\NoAutoRun.reg"

IF /I NOT "%~1"=="/Q" ECHO Windows' AutoRun feature is now disabled on this computer.

:End
