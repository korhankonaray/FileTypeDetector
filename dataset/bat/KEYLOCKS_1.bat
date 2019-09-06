@GOTO :Batch

D 0:417 L 1
Q

:Batch
@ECHO OFF
:: Check the command line arguments
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT "%~2"=="" GOTO Syntax
IF NOT "%~1"=="" IF /I NOT "%~1"=="C" IF /I NOT "%~1"=="N" IF /I NOT "%~1"=="S" GOTO Syntax


:: Run DEBUG with the temporary script and capture the result
FOR /F "skip=4 tokens=2" %%A IN ('DEBUG ^< "%~f0" 2^>NUL') DO SET /A KeyLocks = 0x%%A

:: Calculate the status of the individual keys
SET /A CapsLock   = "(%KeyLocks% & 0x40) / 0x40"
SET /A NumLock    = "(%KeyLocks% & 0x20) / 0x20"
SET /A ScrollLock = "(%KeyLocks% & 0x10) / 0x10"

:: Display the requested result(s)
IF /I NOT "%~1"=="N" IF /I NOT "%~1"=="S" SET CapsLock
IF /I NOT "%~1"=="C" IF /I NOT "%~1"=="S" SET NumLock
IF /I NOT "%~1"=="C" IF /I NOT "%~1"=="N" SET ScrollLock

:: Default return code is the combined status
SET /A KeyLocks = "%KeyLocks% & 0x70"
:: If a single key lock was requested on the command
:: line, the return code will be that key's status
IF /I "%~1"=="C" SET KeyLocks=%CapsLock%
IF /I "%~1"=="N" SET KeyLocks=%NumLock%
IF /I "%~1"=="S" SET KeyLocks=%ScrollLock%

:: Return the requested key lock's status as "errorlevel"
EXIT /B %KeyLocks%


:Syntax
ECHO KeyLocks.bat,  Version 1.20 for Windows NT 4 / 2000 / XP
ECHO Return the status of the CapsLock, NumLock and ScrollLock keys
ECHO.
IF NOT "%OS%"=="Windows_NT" ECHO Usage:  KEYLOCKS  [ C ³ N ³ S ]
IF     "%OS%"=="Windows_NT" ECHO Usage:  KEYLOCKS  [ C ^| N ^| S ]
ECHO.
ECHO Where:  C is for CapsLock status, N for NumLock, and S for ScrollLock.
ECHO         By default the status for all three is displayed.
ECHO.
ECHO Notes:  The status of either the requested or all key lock(s) is displayed
ECHO         on screen, and each is stored in the environment variables CapsLock,
ECHO         NumLock and ScrollLock. The value of the environment variable
ECHO         KeyLocks, which will also be returned as an "errorlevel", will
ECHO         either be the status of the requested key lock (0=OFF, 1=ON) or
ECHO         a combination of the three (C=64, N=32, S=16).
ECHO         This batch file uses DEBUG to read the keyboard status.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
