@ECHO OFF
IF NOT "%OS%"=="Windows_NT"         GOTO Syntax
IF NOT "%~1"==""                    GOTO Syntax
VER | FIND.EXE "Windows XP" >NUL || GOTO Syntax

:: Create temporary .reg file
>  "%Temp%.\nonagxp.reg" ECHO REGEDIT4
>> "%Temp%.\nonagxp.reg" ECHO.
>> "%Temp%.\nonagxp.reg" ECHO [HKEY_CURRENT_USER\Software\Microsoft\MessengerService]
>> "%Temp%.\nonagxp.reg" ECHO "PassportBalloon"=hex:0a,00
>> "%Temp%.\nonagxp.reg" ECHO.
>> "%Temp%.\nonagxp.reg" ECHO [HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Applets\Tour]
>> "%Temp%.\nonagxp.reg" ECHO "RunCount"=dword:00000000
>> "%Temp%.\nonagxp.reg" ECHO.

:: Import settings from temporary .reg file
START /WAIT REGEDIT.EXE /S "%Temp%.\nonagxp.reg"

:: Remove temporary .reg file
DEL "%Temp%.\nonagxp.reg"

:: Done
GOTO:EOF


:Syntax
ECHO.
ECHO NoNagXP.bat,  Version 1.00 for Windows XP
ECHO Disable nag screens for .NET Passport and Windows XP Pro Tour
ECHO.
ECHO Usage:  NONAGXP
ECHO.
ECHO Idea: Greg Schultz's xpnagdisabler VBScripts on
ECHO http://techrepublic.com.com
ECHO Converted to batch by Rob van der Woude
ECHO http://www.robvanderwoude.com
