@ECHO OFF
ECHO.
ECHO CLLUN.bat,  Version 1.00 for Windows 9x and 2000
ECHO Clear or modify Last Logon User Name
ECHO.
ECHO Usage:   CLLUN  [ new logon user name ]
ECHO.
ECHO Invoking CLLUN without parameters will clear the
ECHO last logon user name from the logon dialog.
ECHO If an optional command line parameter is specified,
ECHO the last logon user name will be set to that value.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
ECHO.

:: Command line parameters check
ECHO.%1 | FIND "?" > NUL
IF NOT ERRORLEVEL 1 GOTO Error
IF NOT [%2]==[] GOTO End

:: Display a warning
SET _modify_=clear
IF NOT [%1]==[] SET _modify_=modify
ECHO You are about to %_modify_% the last user logon name in the registry.
SET _modify_=
ECHO Press Ctrl+C to abort or any other key to continue . . .
PAUSE > NUL

:: Create temporary REG file
>  "%TEMP%.\LogonName.reg" ECHO REGEDIT4
>> "%TEMP%.\LogonName.reg" ECHO.

:: Windows version check
VER | FIND "Windows 2000" >NUL
IF NOT ERRORLEVEL 1 GOTO Win2K
VER | FIND "Windows 9" >NUL
IF NOT ERRORLEVEL 1 GOTO Win9x
GOTO Error

:Win9x
>> "%TEMP%.\LogonName.reg" ECHO [HKEY_LOCAL_MACHINE\Network\Logon]
>> "%TEMP%.\LogonName.reg" ECHO "UserName"="%1"
GOTO Merge

:Win2K
>> "%TEMP%.\LogonName.reg" ECHO [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer]
>> "%TEMP%.\LogonName.reg" ECHO "Logon User Name"="%1"
>> "%TEMP%.\LogonName.reg" ECHO.
>> "%TEMP%.\LogonName.reg" ECHO [HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon]
>> "%TEMP%.\LogonName.reg" ECHO "AltDefaultUserName"="%1"
>> "%TEMP%.\LogonName.reg" ECHO "DefaultUserName"="%1"

:Merge
>> "%TEMP%.\LogonName.reg" ECHO.
:: Use REG file to change registry setting
START /WAIT REGEDIT.EXE /S "%TEMP%.\LogonName.reg"
:: Remove temporary file
DEL "%TEMP%.\LogonName.reg"
GOTO End

:Error
ECHO.
ECHO Error: wrong Windows version.
ECHO This script is intended for Windows 9x and 2000 only.
ECHO.
PAUSE

:End
CLS
