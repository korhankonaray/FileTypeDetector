@ECHO OFF
ECHO.

:: Reset variables
SET "cDate="
SET "iDate="
SET "sDate="

:: Check the Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION

:: Initialize variable
SET "Error=0"

:: Check the command line arguments
IF     "%~1"=="" GOTO Syntax
IF NOT "%~3"=="" GOTO Syntax
ECHO.%* | FINDSTR.EXE /R /I /C:"[^-\""adnotwy/0-9 ]" >NUL && GOTO Syntax

:: Get today's date in local date format
SET ArgsCount=0
FOR %%A IN (%Date%) DO (
	SET /A ArgsCount += 1
	SET "Today=%%~A"
)
IF %ArgsCount% GTR 2 (
	REM Use WMIC to get today's date in ISO 8601 format
	FOR /F "skip=1 tokens=1-3" %%A IN ('WMIC Path Win32_LocalTime Get Day^,Month^,Year /Format:table') DO (
		IF NOT "%%~F"=="" (
			SET Today=%%C-%%B-%%A
		)
	)
)

IF "%~2"=="" (
	SET "cDate=%Today%"
	SET /A "cDays=%~1" >NUL 2>&1
) ELSE (
	SET "cDate=%~1"
	IF /I "%~1"=="Now"   (SET "cDate=%Today%")
	IF /I "%~1"=="Today" (SET "cDate=%Today%")
	SET /A "cDays=%~2" >NUL 2>&1
)
IF "%cDays%"=="0" (
	ECHO.
	ECHO Error: %cDays% is not a valid integer
	GOTO Syntax
)

:: Read the Date format from the registry; if this fails, we're probably dealing with an older Windows version
FOR /F "tokens=3" %%A IN ('REG.EXE Query "HKEY_CURRENT_USER\Control Panel\International" /v iDate 2^>NUL') DO SET "iDate=%%~A"
FOR /F "tokens=3" %%A IN ('REG.EXE Query "HKEY_CURRENT_USER\Control Panel\International" /v sDate 2^>NUL') DO SET "sDate=%%~A"
IF "%iDate%"=="" GOTO Syntax

:: Check if a valid date in local format was specified
ECHO.%cDate% | FINDSTR.EXE /R /B /C:"[0-9][0-9]*%sDate%[0-9][0-9]*%sDate%[0-9][0-9][0-9][0-9]" >NUL
IF ERRORLEVEL 1 (
	REM Try testing for ISO 8601 format
	ECHO.%cDate% | FINDSTR.EXE /R /B /C:"[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]" >NUL
	IF ERRORLEVEL 1 (
		ECHO.
		ECHO Error: %cDate% is not a valid date
		GOTO Syntax
	) ELSE (
		SET "iDate=2"
		SET "sDate=-"
	)
)

:: Parse the date specified, abort on failure
CALL :ParseDate %cDate%
IF "%Error%"=="1" GOTO Syntax

:: Convert the parsed Gregorian date to Julian
CALL :JDate %GYear% %GMonth% %GDay%

:: Display original input
ECHO Starting date   : %cDate%

:: Add or subtract the specified number of days
IF "%cDays:~0,1%"=="-" (
	SET /A "NewJDate = %JDate% - %cDays:~1%"
	ECHO Days subtracted : %cDays:~1%
) ELSE (
	SET /A "NewJDate = %JDate% + %cDays%"
	ECHO Days added      : %cDays%
)

:: Convert the new Julian date back to Gregorian again
CALL :GDate %NewJDate%

:: Reformat the date to local format
CALL :ReformatDate %GDate%

:: Display the result
ECHO Resulting date  : %LDate%

:: Return the result in a variable named after this batch file
ENDLOCAL & SET "%~n0=%LDate%"
GOTO:EOF


::===================================::
::                                   ::
::   -   S u b r o u t i n e s   -   ::
::                                   ::
::===================================::


:GDate
:: Convert Julian date back to "normal" Gregorian date
:: Argument : Julian date
:: Returns  : YYYY MM DD
::
:: Algorithm based on Fliegel-Van Flandern
:: algorithm from the Astronomical Almanac,
:: provided by Doctor Fenton on the Math Forum
:: (http://mathforum.org/library/drmath/view/51907.html),
:: and converted to batch code by Ron Bakowski.
::
SET /A "P      = %~1 + 68569"
SET /A "Q      = 4 * %P% / 146097"
SET /A "R      = %P% - ( 146097 * %Q% + 3 ) / 4"
SET /A "S      = 4000 * ( %R% + 1 ) / 1461001"
SET /A "T      = %R% - 1461 * %S% / 4 + 31"
SET /A "U      = 80 * %T% / 2447"
SET /A "V      = %U% / 11"
SET /A "GYear  = 100 * ( %Q% - 49 ) + %S% + %V%"
SET /A "GMonth = %U% + 2 - 12 * %V%"
SET /A "GDay   = %T% - 2447 * %U% / 80"
:: Clean up the mess
FOR %%A IN (P Q R S T U V) DO SET "%%~A="
:: Add leading zeroes
IF 1%GMonth% LSS 20 SET "GMonth=0%GMonth%"
IF 1%GDay%   LSS 20 SET "GDay=0%GDay%"
:: Return value
SET "GDate=%GYear% %GMonth% %GDay%"
GOTO:EOF


:JDate
:: Convert date to Julian
:: Arguments : YYYY MM DD
:: Returns   : Julian date
::
:: First strip leading zeroes
SET "MM=%2"
SET "DD=%3"
IF "%MM:~0,1%"=="0" SET "MM=%MM:~1%"
IF "%DD:~0,1%"=="0" SET "DD=%DD:~1%"
::
:: Algorithm based on Fliegel-Van Flandern
:: algorithm from the Astronomical Almanac,
:: provided by Doctor Fenton on the Math Forum
:: (http://mathforum.org/library/drmath/view/51907.html),
:: and converted to batch code by Ron Bakowski.
SET /A "Month1 = ( %MM% - 14 ) / 12"
SET /A "Year1  = %~1 + 4800"
SET /A "JDate  = 1461 * ( %Year1% + %Month1% ) / 4 + 367 * ( %MM% - 2 -12 * %Month1% ) / 12 - ( 3 * ( ( %Year1% + %Month1% + 100 ) / 100 ) ) / 4 + %DD% - 32075"
FOR %%A IN (Month1 Year1) DO SET "%%~A="
GOTO:EOF 


:ParseDate
:: Parse (Gregorian) date depending on registry's date format settings
:: Argument : Gregorian date in local date format, or in ISO 8601 format
:: Requires : sDate (local date separator), iDate (local date format number)
:: Returns  : GYear (4-digit year), GMonth (2-digit month), GDay (2-digit day)
::
IF "%iDate%"=="0" FOR /F "tokens=1-3 delims=%sDate%" %%A IN ('ECHO.%1') DO (
	SET "GYear=%%~C"
	SET "GMonth=%%~A"
	SET "GDay=%%~B"
)
IF "%iDate%"=="1" FOR /F "tokens=1-3 delims=%sDate%" %%A IN ('ECHO.%1') DO (
	SET "GYear=%%~C"
	SET "GMonth=%%~B"
	SET "GDay=%%~A"
)
IF "%iDate%"=="2" FOR /F "TOKENS=1-3 DELIMS=%sDate%" %%A IN ('ECHO.%1') DO (
	SET "GYear=%%~A"
	SET "GMonth=%%~B"
	SET "GDay=%%~C"
)
IF %GDay%   GTR 31 SET "Error=1"
IF %GMonth% GTR 12 SET "Error=1"
GOTO:EOF


:ReformatDate
:: Reformat the date back to the local format
:: Arguments : YYYY MM DD
:: Returns   : LDate (Gregorian date in local format)
::
IF "%iDate%"=="0" SET "LDate=%~2%sDate%%~3%sDate%%~1"
IF "%iDate%"=="1" SET "LDate=%~3%sDate%%~2%sDate%%~1"
IF "%iDate%"=="2" SET "LDate=%~1%sDate%%~2%sDate%%~3"
GOTO:EOF


:Syntax
ECHO.
ECHO DateAdd.bat,  Version 2.02 for Windows XP Professional and later
ECHO Add the specified number of days to the specified date
ECHO.
ECHO Usage:   DATEADD  [ date ]  days
ECHO.
ECHO Where:   date     is a "normal" Gregorian date, either in the local date
ECHO                   format, or in ISO 8601 yyyy-MM-dd format, or "Today"
ECHO                   or "Now" (default if not specified: today's date)
ECHO          days     is the number of days to add (negative to subtract)
ECHO.
ECHO E.g.     DATEADD  2017-01-01   1        will return 2017-01-02
ECHO          DATEADD  2017-01-01  -1        will return 2016-12-31
:: To show the following "advanced" examples, Windows XP or later is required
IF NOT "%OS%"=="Windows_NT" GOTO Skipped2
FOR /F "tokens=3" %%A IN ('REG.EXE Query "HKEY_CURRENT_USER\Control Panel\International" /v iDate 2^>NUL') DO SET "iDate=%%~A"
FOR /F "tokens=3" %%A IN ('REG.EXE Query "HKEY_CURRENT_USER\Control Panel\International" /v sDate 2^>NUL') DO SET "sDate=%%~A"
:: Windows XP or later is required to read iDate, so if iDate isn't set, skip the "advanced" examples
IF "%iDate%"=="" GOTO Skipped2
FOR %%A IN (%Date%) DO SET "Today=%%~A"
CALL :ParseDate %Today%
IF NOT "%Error%"=="0" GOTO Skipped1
CALL :JDate %GYear% %GMonth% %GDay%
SET /A "NewJDate = %JDate% + 1"
CALL :GDate %NewJDate%
CALL :ReformatDate %GDate%
SET "Tomorrow=%LDate%"
CALL :ParseDate %Today%
CALL :JDate %GYear% %GMonth% %GDay%
SET /A "NewJDate = %JDate% - 1"
CALL :GDate %NewJDate%
CALL :ReformatDate %GDate%
SET "Yesterday=%LDate%"
:Skipped1
IF "%Yesterday%"=="" (
	ECHO          DATEADD  %Today%   1        will return tomorrow's date  ^(as will DATEADD  1^)
	ECHO          DATEADD  %Today%  -1        will return yesterday's date ^(as will DATEADD -1^)
) ELSE (
	ECHO          DATEADD  %Today%   1        will return %Tomorrow%
	ECHO          DATEADD  1                     will return %Tomorrow% too
	ECHO          DATEADD  %Today%  -1        will return %Yesterday%
	ECHO          DATEADD  -1                    will return %Yesterday% too
)
:: End of "advanced" examples section
:Skipped2
ECHO.
ECHO Notes:   By default, the returned date will be presented in the local date
ECHO          format; however, if the date in the command line argument is in the
ECHO          ISO 8601 yyyy-MM-dd format, the result will be in ISO 8601 format too.
ECHO          Unlike its earlier 1.* versions, this batch file does not require
ECHO          elevated privileges.
ECHO.
ECHO Credits: Julian date conversion based on Fliegel-Van Flandern algorithms from
ECHO          the Astronomical Almanac, provided by Doctor Fenton on the Math Forum
ECHO          http://mathforum.org/library/drmath/view/51907.html
ECHO          and converted to batch code by Ron Bakowski.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" ENDLOCAL
IF "%OS%"=="Windows_NT" EXIT /B 1
