@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION

IF     "%~1"=="" CALL :Syntax Specify a date in YYYYMMDD or YYYY-MM-DD format
IF NOT "%~2"=="" CALL :Syntax Too many command line arguments

:: Specified date must be in YYYYMMDD or YYYY-MM-DD format
ECHO.%~1| FINDSTR /R /X /C:"20[0-9][0-9]-*[01][0-9]-*[0-3][0-9]" >NUL
IF ERRORLEVEL 1 CALL :Invalid "%~1"
SET LocalDate=%~1
SET LocalDate=%LocalDate:-=%

:: Extract and verify year
SET Year=%LocalDate:~0,4%
ECHO %Year%| FINDSTR /R /X /C:"20[0-9][0-9]" >NUL || CALL :Invalid "%~1"

:: Extract and verify month
SET Month=%LocalDate:~4,2%
ECHO %Month%| FINDSTR /R /X /C:"[01][0-9]" >NUL || CALL :Invalid "%~1"
SET /A Month = 1%Month% - 100
IF %Month% EQU  0 CALL :Invalid "%~1"
IF %Month% GTR 12 CALL :Invalid "%~1"

:: Extract and verify day
SET Day=%LocalDate:~6,2%
ECHO %Day%| FINDSTR /R /X /C:"[0-3][0-9]" >NUL || CALL :Invalid "%~1"
SET /A Day = 1%Day% - 100
IF %Day% EQU  0 CALL :Invalid "%~1"
IF %Day% GTR 31 CALL :Invalid "%~1"

:: Test for leap year
SET Leapyear=0
SET /A "Leaptest = %Year% %% 4"
IF %Leaptest% EQU 0 SET LeapYear=1
SET /A "Leaptest = %Year% %% 100"
IF %Leaptest% EQU 0 SET LeapYear=0
SET /A "Leaptest = %Year% %% 400"
IF %Leaptest% EQU 0 SET LeapYear=1

:: Array with days per month
SET MaxDay.1=31
SET /A Maxday.2 = 28 + %LeapYear%
SET MaxDay.3=31
SET MaxDay.4=30
SET MaxDay.5=31
SET MaxDay.6=30
SET MaxDay.7=31
SET MaxDay.8=31
SET MaxDay.9=30
SET MaxDay.10=31
SET MaxDay.11=30
SET MaxDay.12=31

:: Number of days for specified or current months
SET MaxDays=!MaxDay.%Month%!
IF %Day% GTR %MaxDays% CALL :Invalid "%~1"

:: If you made it to here, the date is assumed valid
ECHO %~1 is a valid date
ENDLOCAL
EXIT 0


:Invalid
ECHO %~1 is NOT a valid date

:: To abort the entire script we CANNOT use EXIT's /B switch; if
:: the /B switch were used, the batch file would continue after
:: displaying this help text, which we certainly do not want.
ENDLOCAL
EXIT 2


:Syntax
IF NOT "%*"=="" ECHO.
IF NOT "%*"=="" ECHO ERROR: %*
ECHO.
ECHO IsDate.bat,  Version 1.02 for Windows 2000 and later
ECHO Check if the specified date is a valid date
ECHO.
ECHO Usage:  ISDATE  YYYYMMDD
ECHO    or:  ISDATE  YYYY-MM-DD
ECHO.
ECHO Notes:  Displays the result on screen, and returns 'errorlevel' 0 if the
ECHO         date is valid, or 2 if not (1 is reserved for command line errors).
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com"

:: To abort the entire script we CANNOT use EXIT's /B switch; if
:: the /B switch were used, the batch file would continue after
:: displaying this help text, which we certainly do not want.
IF "%OS%"=="Windows_NT" ENDLOCAL
IF "%OS%"=="Windows_NT" EXIT 1
