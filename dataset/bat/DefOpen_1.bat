@ECHO OFF
:: No parameters required
IF NOT [%1]==[] GOTO Syntax

:: Choose the correct command processor for the current operating system
SET _cmd=
:: Variable to add shortcut to menu entry (NT only,
:: since COMMAND.COM cannot echo an ampersand)
SET _=
ECHO.%COMSPEC% | FIND /I "command.com" >NUL
IF NOT ERRORLEVEL 1 SET _cmd=command.com /e:4096
ECHO.%COMSPEC% | FIND /I "cmd.exe" >NUL
IF NOT ERRORLEVEL 1 SET _cmd=cmd.exe
IF [%_cmd%]==[cmd.exe] SET _=^&

:: Create a temporary .REG file
> %TEMP%.\DEFOPEN.REG ECHO REGEDIT4
>>%TEMP%.\DEFOPEN.REG ECHO.

:: Open With Notepad doesn't work in XP
SET Skip=0
VER | FIND /I "XP" >NUL
IF NOT ERRORLEVEL 1 SET Skip=1
VER | FIND /I "Server 2003" >NUL
IF NOT ERRORLEVEL 1 SET Skip=1
IF "%Skip%"=="1" ECHO Skipping "Open with Notepad" entry
IF "%Skip%"=="1" GOTO Print
ECHO Adding "Open with Notepad" entry
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\*\shell\open]
>>%TEMP%.\DEFOPEN.REG ECHO @="%_%Open with Notepad"
>>%TEMP%.\DEFOPEN.REG ECHO.
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\*\shell\open\command]
>>%TEMP%.\DEFOPEN.REG ECHO @="notepad.exe \"%%L\""
>>%TEMP%.\DEFOPEN.REG ECHO.

:Print
ECHO Adding "Print with Notepad" entry
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\*\shell\print]
>>%TEMP%.\DEFOPEN.REG ECHO @="%_%Print with Notepad"
>>%TEMP%.\DEFOPEN.REG ECHO.
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\*\shell\print\command]
>>%TEMP%.\DEFOPEN.REG ECHO @="notepad.exe /p \"%%L\""
>>%TEMP%.\DEFOPEN.REG ECHO.

:: If neither COMMAND.COM nor CMD.EXE then skip this step
IF [%_cmd%]==[] ECHO Skipping "Command Prompt Here" entry
IF [%_cmd%]==[] GOTO Merge

ECHO Adding "Command Prompt Here" entry
SET Pushd=cd
IF "%Skip%"=="1" SET Pushd=pushd
VER | FIND /I "Windows 2000" >NUL
IF NOT ERRORLEVEL 1 SET Pushd=pushd

:: Add Command Prompt Here for files
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\*\shell\prompt]
>>%TEMP%.\DEFOPEN.REG ECHO @="Command Prompt Here"
>>%TEMP%.\DEFOPEN.REG ECHO.
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\*\shell\prompt\command]
>>%TEMP%.\DEFOPEN.REG ECHO @="%_cmd% /k %Pushd% \"%%L\\..\""
>>%TEMP%.\DEFOPEN.REG ECHO.
:: Add Command Prompt Here for directories
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\Directory\shell\prompt]
>>%TEMP%.\DEFOPEN.REG ECHO @="Command Prompt Here"
>>%TEMP%.\DEFOPEN.REG ECHO.
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\Directory\shell\prompt\command]
>>%TEMP%.\DEFOPEN.REG ECHO @="%_cmd% /k %Pushd% \"%%L\""
>>%TEMP%.\DEFOPEN.REG ECHO.
:: Add Command Prompt Here for drives
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\Drive\shell\prompt]
>>%TEMP%.\DEFOPEN.REG ECHO @="Command Prompt Here"
>>%TEMP%.\DEFOPEN.REG ECHO.
>>%TEMP%.\DEFOPEN.REG ECHO [HKEY_CLASSES_ROOT\Drive\shell\prompt\command]
>>%TEMP%.\DEFOPEN.REG ECHO @="%_cmd% /k %Pushd% \"%%L\""
>>%TEMP%.\DEFOPEN.REG ECHO.

:: Merge the temporary .REG file
:Merge
START /WAIT REGEDIT /S %TEMP%.\DEFOPEN.REG

:: Delete the temporary .REG file
DEL %TEMP%.\DEFOPEN.REG

:: Ready
GOTO End

:Syntax
ECHO.
ECHO DefOpen.bat,  Version 3.00 for Windows 95 .. Windows Server 2003
ECHO Adds a default file association: double-clicking a file without a file
ECHO association will open the file in Notepad.
ECHO Also adds three new entries to Explorer's context menu: "Open with Notepad",
ECHO "Print with Notepad" and "Command Prompt Here".
ECHO.
ECHO Usage:  DEFOPEN
ECHO.
ECHO Notes:  In Windows 2000 and later, "Command Prompt Here" will also work for
ECHO         UNC paths by using Reinhard Irnberger's PUSHD trick; the price to pay
ECHO         for this functionality is that you need to close the window with the
ECHO         POPD command, otherwise a network mapping will persist.
ECHO         "Open With Notepad" will not be added in XP or later, as it won't work.
ECHO         Notepad registry tip courtesy of Regedit.com (http://www.regedit.com)
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:: Clean up variables and quit
:End
SET _cmd=
SET _=
