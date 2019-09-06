@ECHO OFF
ECHO.

:: Check the Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
SETLOCAL ENABLEDELAYEDEXPANSION

:: Check the number of command line arguments
IF     "%~1"=="" GOTO Syntax
IF NOT "%~7"=="" GOTO Syntax

:: Initialize variables
SET Date1=
SET Date2=
SET iDate=
SET sDate=
FOR /F "skip=1 tokens=2*" %%A IN ('REG.EXE Query "HKCU\Control Panel\International" /v iDate') DO SET iDateLocal=%%~B
FOR /F "skip=1 tokens=2*" %%A IN ('REG.EXE Query "HKCU\Control Panel\International" /v sDate') DO SET sDateLocal=%%~B
FOR %%A IN (%Date%) DO SET Today=%%A
SET Verbose=0
SET Debug=0
TYPE "%~f0" | FINDSTR.EXE /R /B /I /C:":: *@ECHO OFF" >NUL && SET Debug=1

:: parse command line
FOR %%A IN (%*) DO (
	SET Arg=%%~A
	IF "%Debug%"=="1" ECHO Arg=%%~A
	IF "!Arg:~0,1!"=="/" (
		IF /I "!Arg:~0,2!"=="/I" (
			IF "!iDate!"=="" (
				SET iDate=!Arg:~3!
				IF "%Debug%"=="1" ECHO iDate=!iDate!
				IF "%Debug%"=="1" ECHO iDateLocal=%iDateLocal%
			) ELSE (
				ECHO Duplicate switch /i
				ECHO.
				GOTO Syntax
			)
		) ELSE (
			IF /I "!Arg:~0,2!"=="/S" (
				IF "!sDate!"=="" (
					SET sDate=!Arg:~3!
					IF "%Debug%"=="1" ECHO sDate=!sDate!
				) ELSE (
					ECHO Duplicate switch /s
					ECHO.
					GOTO Syntax
				)
			) ELSE (
				IF /I "!Arg!"=="/V" (
					IF "!Verbose!"=="0" (
						SET Verbose=1
						IF "%Debug%"=="1" SET Verbose
					) ELSE (
						ECHO Duplicate switch /v
						ECHO.
						GOTO Syntax
					)
				) ELSE (
					IF /I "!Arg:~0,2!"=="/D" (
						SET Debug=1
						SET Debug
					) ELSE (
						ECHO Invalid command line switch !Arg!
						ECHO.
						GOTO Syntax
					)
				)
			)
		)
	) ELSE (
		IF "!Date1!"=="" (
			SET Date1=%%A
			IF "%Debug%"=="1" SET Date1
		) ELSE (
			IF "!Date2!"=="" (
				SET Date2=%%A
				IF "%Debug%"=="1" SET Date2
			) ELSE (
				ECHO Too many dates on command line
				ECHO.
				GOTO Syntax
			)
		)
	)
)

SET iDateEnum.0=Month%sDate%Day%sDate%Year
SET iDateEnum.1=Day%sDate%Month%sDate%Year
SET iDateEnum.2=Year%sDate%Month%sDate%Day

:: Use today for second date if not spedified
IF "%Date2%"=="" (
	IF %Debug%%Verbose% GEQ 1 SET Today
	IF %Debug%%Verbose% GEQ 1 SET Date2
	IF NOT "%iDate%%sDate%"=="" (
		CALL :ParseDate %Today% %iDateLocal% %sDateLocal%
		IF %iDate%==0 SET Today=!GMonth!%sDate%!GDay!%sDate%!GYear!
		IF %iDate%==1 SET Today=!GDay!%sDate%!GMonth!%sDate%!GYear!
		IF %iDate%==2 SET Today=!GYear!%sDate%!GMonth!%sDate%!GDay!
	)
	SET Date2=!Today!
	IF %Debug%%Verbose% GEQ 1 SET Today
	IF %Debug%%Verbose% GEQ 1 SET Date2
)

:: Use local date format if no alternative was specified
IF "%iDate%"=="" SET iDate=%iDateLocal%
IF "%sDate%"=="" SET sDate=%sDateLocal%

IF "%verbose%"=="1" (
	ECHO Date format used:
	ECHO iDate=%iDate% ^(!iDateEnum.%iDate%!^)
	SET Local_iDate=!iDateEnum.%iDateLocal%!
	SET Local_iDate=!Local_iDate:%sDate%=%sDateLocal%!
	ECHO iDateLocal=%iDateLocal% ^(!Local_iDate!^)
	SET sDate
	ECHO.
)

:: Check if the first date is valid
(ECHO.%Date1%) | FINDSTR /R /B /C:"[0-9]*%sDate%[0-9]*%sDate%[0-9]*" >NUL
IF ERRORLEVEL 1 (
	ECHO Error: %Date1% is not a valid date
	ECHO.
	GOTO Syntax
)

:: Check if the second date is valid
(ECHO.%Date2%) | FINDSTR /R /B /C:"[0-9]*%sDate%[0-9]*%sDate%[0-9]*" >NUL
IF ERRORLEVEL 1 (
	ECHO Error: %Date2% is not a valid date
	ECHO.
	GOTO Syntax
)

:: Parse the first date
CALL :ParseDate %Date1%
IF "%Verbose%"=="1" (
	ECHO Date1=%Date1%
	SET GYear
	SET GMonth
	SET GDay
	ECHO.
)
IF %GDay% GTR 31 (
	ECHO Invalid date, day cannot be greater than 31
	ECHO.
	GOTO Syntax
)
IF %GMonth% GTR 12 (
	ECHO Invalid date, month cannot be greater than 12
	ECHO.
	GOTO Syntax
)

:: Convert the parsed Gregorian date to Julian
CALL :JDate %GYear% %GMonth% %GDay%
IF "%Verbose%"=="1" (
	ECHO Julian Date1
	SET JDate
	ECHO.
)

:: Save the resulting Julian date
SET JDate1=%JDate%

:: Parse the second date
CALL :ParseDate %Date2%
IF "%Verbose%"=="1" (
	ECHO Date2=%Date2%
	SET GYear
	SET GMonth
	SET GDay
	ECHO.
)
IF %GDay% GTR 31 (
	ECHO Invalid date, day cannot be greater than 31
	ECHO.
	GOTO Syntax
)
IF %GMonth% GTR 12 (
	ECHO Invalid date, month cannot be greater than 12
	ECHO.
	GOTO Syntax
)

:: Convert the parsed Gregorian date to Julian
CALL :JDate %GYear% %GMonth% %GDay%
IF "%Verbose%"=="1" (
	ECHO Julian Date2
	SET JDate
	ECHO.
)

:: Calculate the absolute value of the difference in days
IF %JDate% GTR %JDate1% (
	SET /A DateDiff = %JDate% - %JDate1%
) ELSE (
	SET /A DateDiff = %JDate1% - %JDate%
)

:: Format output for singular or plural
SET Days=days
IF %DateDiff% EQU 1 SET Days=day

:: Prefix value with a minus sign if negative
IF %JDate% GTR %JDate1% SET DateDiff=-%DateDiff%

:: Display the result
ECHO First date  : %Date1%
ECHO Second date : %Date2%
ECHO Difference  : %DateDiff% %Days%

:: Return the result in a variable named after this batch file
ENDLOCAL & SET %~n0=%DateDiff%
GOTO:EOF


::===================================::
::                                   ::
::   -   S u b r o u t i n e s   -   ::
::                                   ::
::===================================::


:JDate
:: Convert date to Julian
:: Arguments : YYYY MM DD
:: Returns   : Julian date
::
:: First strip 1 or 2 leading zeroes; a logical error in this
:: routine was corrected with help from Alexander Shapiro
SET MM=%2
SET DD=%3
IF "%MM:~0,1%"=="0" IF NOT "%MM%"=="0" SET MM=%MM:~1%
IF "%MM:~0,1%"=="0" IF NOT "%MM%"=="0" SET MM=%MM:~1%
IF "%DD:~0,1%"=="0" IF NOT "%DD%"=="0" SET DD=%DD:~1%
IF "%DD:~0,1%"=="0" IF NOT "%DD%"=="0" SET DD=%DD:~1%
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
:: Argument : Gregorian date in local date format, optional iDate and sDate alternatives (in that order)
:: Requires : sDate (local date separator), iDate (local date format number)
:: Returns  : GYear (4-digit year), GMonth (2-digit month), GDay (2-digit day)
::
SET iDateUsed=%iDate%
SET sDateUsed=%sDate%
IF NOT "%~2"=="" SET iDateUsed=%~2
IF NOT "%~3"=="" SET sDateUsed=%~3
IF %iDateUsed%==0 FOR /F "TOKENS=1-3 DELIMS=%sDateUsed%" %%A IN ("%~1") DO (
	SET GYear=%%~C
	SET GMonth=%%~A
	SET GDay=%%~B
)
IF %iDateUsed%==1 FOR /F "TOKENS=1-3 DELIMS=%sDateUsed%" %%A IN ("%~1") DO (
	SET GYear=%%~C
	SET GMonth=%%~B
	SET GDay=%%~A
)
IF %iDateUsed%==2 FOR /F "TOKENS=1-3 DELIMS=%sDateUsed%" %%A IN ("%~1") DO (
	SET GYear=%%~A
	SET GMonth=%%~B
	SET GDay=%%~C
)
SET iDateUsed=
SET sDateUsed=
GOTO:EOF


:Syntax
ECHO DateDiff.bat,  Version 1.11 for Windows XP .. 10
ECHO Calculate the difference (in days) between two dates
ECHO.
ECHO Usage:  DATEDIFF  date  [ date  [ /i:iDate ]  [ /s:sDate ] ]  [ /v ]
ECHO.
ECHO Where:  "date"    is a "normal" Gregorian date in the computer's
ECHO                   local format; if no second date is specified,
ECHO                   today is assumed
ECHO         /i:iDate  specify alternative date format:
ECHO                   iDate = 0 for month/day/year format
ECHO                   iDate = 1 for day/month/year format
ECHO                   iDate = 2 for year/month/day format
ECHO         /s:sDate  specify alternative date separator
ECHO                   (/ or - or . or whatever you want)
ECHO         /v        Verbose output
ECHO.
ECHO Julian date conversion based on Fliegel-Van Flandern algorithms from
ECHO the Astronomical Almanac, provided by Doctor Fenton on the Math Forum
ECHO (http://mathforum.org/library/drmath/view/51907.html), and converted
ECHO to batch code by Ron Bakowski.
ECHO Bug found by and corrected with help from Alexander Shapiro.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" ENDLOCAL
EXIT /B 1
