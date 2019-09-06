@ECHO OFF
ECHO.

:: Check the Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
SETLOCAL

:: Initialize variable
SET Error=0

:: Check the command line arguments
IF     "%~1"=="" GOTO Syntax
IF NOT "%~3"=="" GOTO Syntax
IF "%~2"=="" (
	FOR %%A IN (%Date%) DO SET cDate=%%A
	SET cDays=%~1
) ELSE (
	SET cDate=%~1
	SET cDays=%~2
)

:: Read the Date format from the registry
CALL :ReadDateFormat

:: Check if a valid date was specified
(ECHO.%cDate%) | FINDSTR /R /B /C:"[0-9]*\%sDate%[0-9]*\%sDate%[0-9]*" >NUL
IF ERRORLEVEL 1 (
	ECHO Error: %cDate% is not a valid date
	ECHO.
	GOTO Syntax
)

:: Check if the second argument is a valid number
(ECHO.%cDays%) | FINDSTR /R /B /C:"-*[0-9]*" >NUL
IF ERRORLEVEL 1 (
	ECHO Error: %cDays% is not an integer
	ECHO.
	GOTO Syntax
)

:: Parse the date specified
CALL :ParseDate %cDate%

:: Check for errors
IF %Error% NEQ 0 GOTO Syntax

:: Convert the parsed Gregorian date to Julian
CALL :JDate %GYear% %GMonth% %GDay%

:: Display original input
ECHO Starting date   : %cDate%

:: Add or subtract the specified number of days
IF "%cDays:~0,1%"=="-" (
	SET /A NewJDate = %JDate% - %cDays:~1%
	ECHO Days subtracted : %cDays:~1%
) ELSE (
	SET /A NewJDate = %JDate% + %cDays%
	ECHO Days added      : %cDays%
)

:: Convert the new Julian date back to Gregorian again
CALL :GDate %NewJDate%

:: Reformat the date to local format
CALL :ReformatDate %GDate%

:: Display the result
ECHO Resulting date  : %LDate%

:: Return the result in a variable named after this batch file
ENDLOCAL & SET %~n0=%LDate%
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
SET /A P      = %1 + 68569
SET /A Q      = 4 * %P% / 146097
SET /A R      = %P% - ( 146097 * %Q% +3 ) / 4
SET /A S      = 4000 * ( %R% + 1 ) / 1461001
SET /A T      = %R% - 1461 * %S% / 4 + 31
SET /A U      = 80 * %T% / 2447
SET /A V      = %U% / 11
SET /A GYear  = 100 * ( %Q% - 49 ) + %S% + %V%
SET /A GMonth = %U% + 2 - 12 * %V%
SET /A GDay   = %T% - 2447 * %U% / 80
:: Clean up the mess
FOR %%A IN (P Q R S T U V) DO SET %%A=
:: Add leading zeroes
IF 1%GMonth% LSS 20 SET GMonth=0%GMonth%
IF 1%GDay%   LSS 20 SET GDay=0%GDay%
:: Return value
SET GDate=%GYear% %GMonth% %GDay%
GOTO:EOF


:JDate
:: Convert date to Julian
:: Arguments : YYYY MM DD
:: Returns   : Julian date
::
:: First strip leading zeroes
SET MM=%2
SET DD=%3
IF %MM:~0,1% EQU 0 SET MM=%MM:~1%
IF %DD:~0,1% EQU 0 SET DD=%DD:~1%
::
:: Algorithm based on Fliegel-Van Flandern
:: algorithm from the Astronomical Almanac,
:: provided by Doctor Fenton on the Math Forum
:: (http://mathforum.org/library/drmath/view/51907.html),
:: and converted to batch code by Ron Bakowski.
SET /A Month1 = ( %MM% - 14 ) / 12
SET /A Year1  = %1 + 4800
SET /A JDate  = 1461 * ( %Year1% + %Month1% ) / 4 + 367 * ( %MM% - 2 -12 * %Month1% ) / 12 - ( 3 * ( ( %Year1% + %Month1% + 100 ) / 100 ) ) / 4 + %DD% - 32075
FOR %%A IN (Month1 Year1) DO SET %%A=
GOTO:EOF 


:ParseDate
:: Parse (Gregorian) date depending on registry's date format settings
:: Argument : Gregorian date in local date format,
:: Requires : sDate (local date separator), iDate (local date format number)
:: Returns  : GYear (4-digit year), GMonth (2-digit month), GDay (2-digit day)
::
IF %iDate%==0 FOR /F "TOKENS=1-3 DELIMS=%sDate%" %%A IN ('ECHO.%1') DO (
	SET GYear=%%C
	SET GMonth=%%A
	SET GDay=%%B
)
IF %iDate%==1 FOR /F "TOKENS=1-3 DELIMS=%sDate%" %%A IN ('ECHO.%1') DO (
	SET GYear=%%C
	SET GMonth=%%B
	SET GDay=%%A
)
IF %iDate%==2 FOR /F "TOKENS=1-3 DELIMS=%sDate%" %%A IN ('ECHO.%1') DO (
	SET GYear=%%A
	SET GMonth=%%B
	SET GDay=%%C
)
IF %GDay%   GTR 31 SET Error=1
IF %GMonth% GTR 12 SET Error=1
GOTO:EOF


:ReadDateFormat
:: Read the Date format from the registry.
:: Arguments : none
:: Returns   : sDate (separator), iDate (date format number)
::
:: First, export registry settings to a temporary file:
START /W REGEDIT /E "%TEMP%.\_TEMP.REG" "HKEY_CURRENT_USER\Control Panel\International"
:: Now, read the exported data:
FOR /F "tokens=1* delims==" %%A IN ('TYPE "%TEMP%.\_TEMP.REG" ^| FIND /I "iDate"') DO SET iDate=%%B
FOR /F "tokens=1* delims==" %%A IN ('TYPE "%TEMP%.\_TEMP.REG" ^| FIND /I "sDate"') DO SET sDate=%%B
:: Remove the temporary file:
DEL "%TEMP%.\_TEMP.REG"
:: Remove quotes from the data read:
:: SET iDate=%iDate:"=%
FOR %%A IN (%iDate%) DO SET iDate=%%~A
:: SET sDate=%sDate:"=%
FOR %%A IN (%sDate%) DO SET sDate=%%~A
GOTO:EOF


:ReformatDate
:: Reformat the date back to the local format
:: Arguments : YYYY MM DD
:: Returns   : LDate (Gregorian date in local format)
::
IF %iDate%==0 SET LDate=%2%sDate%%3%sDate%%1
IF %iDate%==1 SET LDate=%3%sDate%%2%sDate%%1
IF %iDate%==2 SET LDate=%1%sDate%%2%sDate%%3
GOTO:EOF


:Syntax
ECHO DateAdd.bat,  Version 1.10 for Windows NT 4 / 2000 / XP / Server 2003 / Vista
ECHO Add (or subtract) the specified number of days to (or from) the specified date
ECHO.
ECHO Usage:  DATEADD  [ date ]  days
ECHO.
ECHO Where:  "date"   is a "normal" Gregorian date in the local computer's format
ECHO                  (default value if no date is specified: today's date)
ECHO         "days"   is the number of days to add or subtract
ECHO.
IF     "%OS%"=="Windows_NT" FOR %%A IN (%Date%) DO SET Today=%%A
IF     "%OS%"=="Windows_NT" ECHO E.g.    DATEADD %Today%  1 will return tomorrow's date  (as will DATEADD  1)
IF     "%OS%"=="Windows_NT" ECHO         DATEADD %Today% -1 will return yesterday's date (as will DATEADD -1)
IF     "%OS%"=="Windows_NT" ENDLOCAL
IF NOT "%OS%"=="Windows_NT" ECHO E.g.    DATEADD 01/25/2007  1 should return 01/26/2007
IF NOT "%OS%"=="Windows_NT" ECHO         DATEADD 01/25/2007 -1 should return 01/24/2007
ECHO.
ECHO Julian date conversion based on Fliegel-Van Flandern algorithms from
ECHO the Astronomical Almanac, provided by Doctor Fenton on the Math Forum
ECHO (http://mathforum.org/library/drmath/view/51907.html), and converted
ECHO to batch code by Ron Bakowski.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
