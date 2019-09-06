@ECHO OFF
ECHO.

:: Windows NT 4 / 2000 / XP only
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Localize environment and enable delayed variable expansion
SETLOCAL ENABLEDELAYEDEXPANSION

:: Command line check
IF NOT [%2]==[] GOTO Syntax

:: Determine current year
CALL :ThisYear

:: If no year is specified, use current year
IF "%~1"=="" (SET Y=%ThisYear%) ELSE (SET Y=%~1)

:: Is the specified year valid?
:: Check if number
FOR /F "tokens=1 delims=0123456789" %%A IN ('ECHO.%Y%') DO IF NOT "%%~A"=="" GOTO Syntax
:: check if in range
IF %Y%0 LSS 17520 GOTO Syntax
IF %Y%0 GTR 30000 GOTO Syntax

:: Array of month names used
SET Month.03=March
SET Month.3=March
SET Month.04=April
SET Month.4=April
SET Month.05=May
SET Month.5=May
SET Month.06=June
SET Month.6=June

:: Calculate Easter Day using the instructions found at
:: Simon Kershaw's "KEEPING THE FEAST"
:: http://www.oremus.org/liturgy/etc/ktf/app/easter.html
SET /A G  = ( %Y% %% 19 ) + 1
SET /A S  = (( %Y% - 1600 ) / 100 ) - (( %Y% - 1600 ) / 400 )
SET /A L  = ((( %Y% - 1400 ) / 100 ) * 8 ) / 25
SET /A P1 = ( 30003 - 11 * %G% + %S% - %L% ) %% 30
SET P=%P1%
IF %P%==28 IF %G% GTR 11 SET P=27
IF %P%==29 SET P=28
SET /A D  = ( %Y% + ( %Y% / 4 ) - ( %Y% / 100 ) + ( %Y% / 400 )) %% 7
SET /A D1 = ( 8 - %D% ) %% 7
SET /A P2 = ( 70003 + %P% ) %% 7
SET /A X  = (( 70004 - %D% - %P% ) %% 7 ) + 1
SET /A E  = %P% + %X%
IF %E% LSS 11 (
	SET /A ED = %E% + 21
	SET EM=3
) ELSE (
	SET /A ED = %E% - 10
	SET EM=4
)
IF %Y% LSS %ThisYear% SET IS=was
IF %Y% EQU %ThisYear% SET IS=is
IF %Y% GTR %ThisYear% SET IS=will be

:: Calculate Ascension and Pentecost dates
CALL :JDate %Y% %EM% %ED%
SET /A ADJ = %JDate% + 39
SET /A PDJ = %JDate% + 49
CALL :GDate %ADJ%
FOR /F "tokens=2,3" %%A IN ("%GDate%") DO (
	SET AM=%%A
	SET AD=%%B
)
CALL :GDate %PDJ%
FOR /F "tokens=2,3" %%A IN ("%GDate%") DO (
	SET PM=%%A
	SET PD=%%B
)

:: Display the result
ECHO In %Y% Easter Day %IS% !Month.%EM%! %ED%
ECHO         Ascension Day %IS% !Month.%AM%! %AD%
ECHO         Pentecost %IS% !Month.%PM%! %PD%

:: Done
GOTO End


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
:: Algorithm based on Fliegel-Van Flandern
:: algorithm from the Astronomical Almanac,
:: provided by Doctor Fenton on the Math Forum
:: (http://mathforum.org/library/drmath/view/51907.html),
:: and converted to batch code by Ron Bakowski.
::
SET /A Month1 = ( %2 - 14 ) / 12
SET /A Year1  = %1 + 4800
SET /A JDate  = 1461 * ( %Year1% + %Month1% ) / 4 + 367 * ( %2 - 2 -12 * %Month1% ) / 12 - ( 3 * ( ( %Year1% + %Month1% + 100 ) / 100 ) ) / 4 + %3 - 32075
FOR %%A IN (Month1 Year1) DO SET %%A=
GOTO:EOF 


:ThisYear
:: Export registry settings to a temporary file
START /WAIT REGEDIT /E "%Temp%.\_Temp.reg" "HKEY_CURRENT_USER\Control Panel\International"
:: Read iDate and sDate from the exported data; more info on iDate can be found at
:: http://technet2.microsoft.com/windowsserver/en/library/7dedbd31-40bd-4f47-a833-517a0b9ab9bb1033.mspx
:: and more info on sDate at
:: http://technet2.microsoft.com/windowsserver/en/library/072ad962-21c4-4070-9c6f-2720922d6d361033.mspx
FOR /F "tokens=1* delims==" %%A IN ('TYPE "%Temp%.\_Temp.reg" ^| FINDSTR /R /B /C:"\"[is]Date\"="') DO SET %%~A=%%~B
DEL "%Temp%.\_Temp.reg"
:: Detemine current year depending on registry settings
FOR %%A IN (%Date%) DO SET Today=%%A
IF %iDate%==2 (SET Token=1) ELSE (SET Token=3)
FOR /F "tokens=%Token% delims=%sDate%" %%A IN ("%Today%") DO SET ThisYear=%%A
GOTO:EOF



:Syntax
ECHO Easter.bat,  Version 3.00 for Windows NT 4 and later
ECHO Calculate Easter day, Ascension day and Pentecost dates for the specified year.
ECHO.
ECHO Usage:  EASTER  [ year ]
ECHO.
ECHO Where:  year should be within the range of 1752..3000 (default: current year)
ECHO.
ECHO Note:   Easter day calculation based on Simon Kershaw's "KEEPING THE FEAST"
ECHO         (http://www.oremus.org/liturgy/etc/ktf/app/easter.html).
ECHO         Julian date math algorithms based on Fliegel-Van Flandern algorithm
ECHO         from the Astronomical Almanac, provided by Doctor Fenton on the Math
ECHO         Forum (http://mathforum.org/library/drmath/view/51907.html), and
ECHO         converted to batch code by Ron Bakowski.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
IF "%OS%"=="Windows_NT" ENDLOCAL
