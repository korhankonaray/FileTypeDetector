@ECHO OFF
IF "%~1"=="" (
	PHP.EXE -r "print(date('l, j F Y',easter_date()));"
) ELSE (
	ECHO.%*| FINDSTR /R /X /C:"[12][0-9][0-9][0-9]" >NUL
	IF ERRORLEVEL 1 GOTO Syntax
	IF %~10 LSS 19700 GOTO Syntax
	IF %~10 GTR 20370 GOTO Syntax
	PHP.EXE -r "print(date('l, j F Y',easter_date('%~1')));"
)

GOTO:EOF

:Syntax
ECHO.
ECHO EasterPHP.bat,  Version 1.01
ECHO Use PHP to display the Easter date for the specified year
ECHO.
ECHO Usage:  EASTERPHP  [ year ]
ECHO.
ECHO Where:  "year"   is a year in the range 1970..2037
ECHO                  (default: current year)
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
EXIT /B 1
