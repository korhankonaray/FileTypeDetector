@ECHO OFF
ECHO.

:: Check Windows version (XP Pro or later)
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Check command line argument (one mandatory)
IF NOT "%~1"=="" GOTO Syntax

:: Check if WMIC is available
WMIC.EXE Alias /? >NUL 2>&1 || GOTO Syntax

:: Localize variables
SETLOCAL ENABLEDELAYEDEXPANSION

:: Reset/initialize the variables used
SET DatePart=
SET Day=
SET Month=
SET Year=
SET Error=0

:: Get current day, month, year
CALL :Today

:: Determine if we have a leap year
CALL :LeapYear

:: Calculate the day of the year
CALL :DayOfYear

:: Calculate the ISO week number
CALL :WeekOfYear

:: Display result
ECHO.%Week%

:: Check for errors trapped by WMIC
IF "%Error%"=="1" (
	ENDLOCAL
	GOTO Syntax
)

:: Done
ENDLOCAL & SET Week=%Week%
EXIT /B %Week%


:DayOfYear
:: Fill array with cumulative number of days of past months
SET /A DaysPast.1  = 0
SET /A DaysPast.2  = %DaysPast.1%  + 31
SET /A DaysPast.3  = %DaysPast.2%  + 28 + %LeapYear%
SET /A DaysPast.4  = %DaysPast.3%  + 31
SET /A DaysPast.5  = %DaysPast.4%  + 30
SET /A DaysPast.6  = %DaysPast.5%  + 31
SET /A DaysPast.7  = %DaysPast.6%  + 30
SET /A DaysPast.8  = %DaysPast.7%  + 31
SET /A DaysPast.9  = %DaysPast.8%  + 31
SET /A DaysPast.10 = %DaysPast.9%  + 30
SET /A DaysPast.11 = %DaysPast.10% + 31
SET /A DaysPast.12 = %DaysPast.11% + 30
SET /A DayOfYear   = !DaysPast.%Month%! + %Day%
GOTO:EOF


:LeapYear
SET LeapYear=0
SET /A "Test = %Year% %% 4"
IF %Test% EQU 0 SET LeapYear=1
SET /A "Test = %Year% %% 100"
IF %Test% EQU 0 SET LeapYear=0
SET /A "Test = %Year% %% 400"
IF %Test% EQU 0 SET LeapYear=1
GOTO:EOF


:Today
FOR /F "skip=1 tokens=1-4" %%A IN ('WMIC Path Win32_LocalTime Get Day^,DayOfWeek^,Month^,Year /Format:table 2^>NUL ^|^| SET Error=1') DO (
	IF "!Day!"==""       SET Day=%%A
	IF "!DayOfWeek!"=="" SET DayOfWeek=%%B
	IF "!Month!"==""     SET Month=%%C
	IF "!Year!"==""      SET Year=%%D
)
IF %DayOfWeek% EQU 0 SET DayOfWeek=7
GOTO:EOF


:WeekOfYear
SET /A ThisWeeksSunday = %DayOfYear% - %DayOfWeek% + 7
SET /A Week = %ThisWeeksSunday% / 7
SET /A FirstThursday = %ThisWeeksSunday% - 7 * %Week% + 4
IF %FirstThursday% GTR 7 SET /A Week -= 1
GOTO:EOF


:Syntax
ECHO WeekXP.bat, Version 1.01 for Windows XP Professional and later
ECHO Returns the ISO week number for the current date
ECHO.
ECHO Usage:   WEEK
ECHO.
ECHO Notes:   The value returned is numeric, without leading zeros.
ECHO          The value is displayed on screen, returned as "errorlevel"
ECHO          and stored in environment variable %%Week%%.
ECHO          Week 0 means the last week (52 or 53) of the previous year.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
