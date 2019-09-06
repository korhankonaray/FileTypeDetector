@ECHO OFF
IF NOT "%1"=="" GOTO Syntax

:: Use BATCHMAN to retrieve day
BATCHMAN DAY
:: Errorlevel 0 means BATCHMAN was not found
IF NOT ERRORLEVEL 1 GOTO NotFound
FOR %%A IN   (1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL  %%A SET DD=0%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 1%%A SET DD=1%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 2%%A SET DD=2%%A
FOR %%A IN (0 1)                 DO IF ERRORLEVEL 3%%A SET DD=3%%A

:: Use BATCHMAN to retrieve month
BATCHMAN MONTH
FOR %%A IN (1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL  %%A SET MM=0%%A
FOR %%A IN (0 1 2)             DO IF ERRORLEVEL 1%%A SET MM=1%%A

:: Use BATCHMAN to retrieve year
BATCHMAN YEAR
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL  %%A SET YYYY=198%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 1%%A SET YYYY=199%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 2%%A SET YYYY=200%%A
FOR %%A IN (0 1 2 3 4 5 6 7 8 9) DO IF ERRORLEVEL 3%%A SET YYYY=201%%A

:: Store in variable and clean up temporary variables
SET SortDate=%YYYY%%MM%%DD%
SET YYYY=
SET MM=
SET DD=

:: Display the result
ECHO.
ECHO SortDate = %SortDate%
GOTO End

:Syntax
ECHO.
ECHO SortDate.bat,  Version 1.00 for MS-DOS
ECHO Display the current date in YYYYMMDD format
ECHO.
ECHO Usage:  SORTDATE
ECHO.
ECHO This batch file uses BATCHMAN, a utility by Michael Mefford
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
