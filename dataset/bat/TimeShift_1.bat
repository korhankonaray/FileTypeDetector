@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF      "%~2"==""           GOTO Syntax
IF NOT  "%~6"==""           GOTO Syntax
PHP -v   >NUL   2>&1   ||   GOTO Syntax

PHP -r "date_default_timezone_set('%~1'); print(date_format(new DateTime(date('c',strtotime('%~2 %~3 %~4 %~5'))),'d-m-Y H:i:s'));"
EXIT /B 0


:Syntax
ECHO.
ECHO TimeShift.bat,  Version 1.01 for Windows NT4+ and PHP 5.2+
ECHO Convert date/time from any timezone to local date/time
ECHO.
ECHO Usage:    TIMESHIFT local_timezone remote_date remote_time remote_timezone
ECHO.
ECHO Example:  TIMESHIFT Europe/Amsterdam 2011-04-09 9:00 PM PDT
ECHO.
ECHO Returns:  10-04-2011 06:00:00 or 04/10/2011 06:00:00 (local time for Amsterdam)
ECHO.
ECHO Requires: PHP 5.2 or later
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" EXIT /B 1
