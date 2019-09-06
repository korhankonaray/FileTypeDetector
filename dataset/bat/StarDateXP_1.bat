@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT  "%~1"==""           GOTO Syntax
WMIC.EXE /? > NUL  2>&1 ||  GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION
FOR /F "tokens=1* delims==" %%A IN ('WMIC Path Win32_LocalTime Get Day^,Hour^,Minute^,Month^,Second^,Year /Format:list') DO (
	IF NOT "%%~B"=="" (
		FOR /F %%C IN ("%%~B") DO (
			SET %%~A=%%~C
		)
	)
)

CALL :LeapYear
CALL :DayOfYear

IF %Year% GEQ 2323 (
	SET /A "YY = %Year% - 2323"
	SET ERA=
) ELSE (
	SET /A "YY = 2323 - %Year%"
	SET ERA= BW ^(Before Warp^)
)
SET /A "DDD = ( %DayOfYear%000 + 182 ) / 365"
SET /A "T   = ( %Hour% * 60 + %Minute% + 72 ) / 144"
SET /A "SD  = %YY% * 1000 + %DDD%"

SET StarDate=%SD%.%T%%ERA%
SET StarDate
ENDLOCAL & SET StarDate=%StarDate%
GOTO:EOF


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


:Syntax
ECHO.
ECHO StarDate.bat,  Version 2.00 for Windows XP Professional and later
ECHO Display the current StarDate and save its value in a variable
ECHO.
ECHO Usage:  STARDATE
ECHO.
ECHO Notes:  Requires WMIC (Windows XP Professional an later).
ECHO         Result is saved in environment variable %%StarDate%%.
ECHO         Based on an algorithm found at The Star Trek Gallery:
ECHO         http://www.trainerscity.com/startrek/stardate.php
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" EXIT /B 1
