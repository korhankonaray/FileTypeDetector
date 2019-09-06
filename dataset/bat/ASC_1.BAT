@GOTO :Batch

A 100
MOV AH,08
INT 21
CMP AL,0
JNZ 010A
INT 21
MOV AH,4C
INT 21

RCX
E
N ASC.COM
W
Q

:Batch
@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF "%~1"=="" GOTO Syntax

PUSHD "%Temp%"
DEBUG < "%~f0" >NUL
POPD

SET Chr=%~1
ECHO.%Chr%| "%Temp%.\ASC.COM"
SET Asc=%ErrorLevel%
DEL "%Temp%.\ASC.COM"
SET Chr
SET Asc
EXIT /B %Asc%


:Syntax
ECHO.
ECHO Asc.bat,  Version 1.00 for Windows NT 4 / 2000 / XP
ECHO Return the ASCII number for the specified character, more or less
ECHO like many scripting languages' Asc( ) functions
ECHO.
ECHO Usage:  ASC.BAT  char
ECHO.
ECHO    or:  ASC.BAT  "char"
ECHO.
ECHO Where:  "char"   is the character whose ASCII value you want to know
ECHO                  (space or "interpreted" characters in doublequotes)
ECHO.
ECHO Notes:  This batch file cannot handle a single doublequote character
ECHO         (ASCII value 34) nor a carriage return (13), linefeed (10),
ECHO         ampersand (38), less than (60), greater than (62) or pipe (124).
ECHO         The result is displayed on screen and returned as "errorlevel".
ECHO         This batch file uses DEBUG to create a temporary utility ASC.COM.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
