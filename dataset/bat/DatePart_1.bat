@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
SETLOCAL
IF     "%~1"=="" GOTO Syntax
IF NOT "%~2"=="" GOTO Syntax
SET DatePart=
SET Valid=0
FOR %%A IN (d,h,m,n,q,s,w,ww,y,yyyy) DO IF /I "%~1"=="%%~A" SET Valid=1
IF NOT %Valid%==1 GOTO Syntax

> "%~dpn0.vbs" ECHO WScript.Echo DatePart^( "%~1", Now ^)
FOR /F %%A IN ('CSCRIPT //NoLogo "%~dpn0.vbs"') DO SET DatePart=%%A
DEL "%~dpn0.vbs"
ENDLOCAL & SET DatePart=%DatePart%
GOTO:EOF

:Syntax
ECHO.
ECHO DatePart.bat,  Version 1.00 for Windows NT 4 and later
ECHO Get the specified numerical part of the current date or time in a variable
ECHO.
ECHO Usage:  DATEPART  option
ECHO.
ECHO Where:  option   can be any of the following values to return:
ECHO                  d        day of the month
ECHO                  h        hour
ECHO                  m        month (number)
ECHO                  n        minutes
ECHO                  q        quarter
ECHO                  s        seconds
ECHO                  w        weekday (number)
ECHO                  ww       week of year
ECHO                  y        day of year
ECHO                  yyyy     year
ECHO.
ECHO Note:   The requested value is returned as environment variable DatePart.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
IF "%OS%"=="Windows_NT" ENDLOCAL
