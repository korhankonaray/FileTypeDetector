@ECHO OFF
IF NOT "%1"=="" GOTO Syntax

:: Use BATCHMAN to retrieve day
BATCHMAN DAY
:: Errorlevel 0 means BATCHMAN was not found
IF NOT ERRORLEVEL 1 GOTO NotFound

:: Use BATCHMAN to retrieve hour
BATCHMAN HOUR
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL  %%A SET HH=0%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 1%%A SET HH=1%%A
FOR %%A IN (0 1 2 3)             DO IF ERRORLEVEL 2%%A SET HH=2%%A

:: Use BATCHMAN to retrieve minutes
BATCHMAN MINUTE
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL  %%A SET MM=0%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 1%%A SET MM=1%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 2%%A SET MM=2%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 3%%A SET MM=3%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 4%%A SET MM=4%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 5%%A SET MM=5%%A

:: Use BATCHMAN to retrieve seconds
BATCHMAN SECOND
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL  %%A SET SS=0%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 1%%A SET SS=1%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 2%%A SET SS=2%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 3%%A SET SS=3%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 4%%A SET SS=4%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 5%%A SET SS=5%%A

:: Store in variable and clean up temporary variables
SET SortTime=%HH%%MM%%SS%
SET HH=
SET MM=

:: Display the result
ECHO.
ECHO SortTime = %SortTime%
GOTO End

:Syntax
ECHO.
ECHO SortTime.bat,  Version 1.00 for MS-DOS
ECHO Display the current time in HHmmss format
ECHO.
ECHO Usage:  SORTTIME
ECHO.
ECHO This batch file uses BATCHMAN, a utility by Michael Mefford
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
