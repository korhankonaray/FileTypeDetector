@ECHO OFF
IF "%~1"=="" (
	PHP.EXE -r "print(idate('W'));"
) ELSE (
	ECHO.%*| FINDSTR /R /X /C:"[0-9][0-9]*[/-][0-9][0-9]*[/-][0-9][0-9]*" >NUL
	IF ERRORLEVEL 1 (
		ECHO WeekPHP.bat,  Version 1.02
		ECHO Use PHP to display the ISO week number for the specified date
		ECHO.
		ECHO Usage:  WEEKPHP  [ date ]
		ECHO.
		ECHO Where:  "date"   is a date in YYYY-MM-DD or the local system's date format
		ECHO                  ^(default: today^)
		ECHO.
		ECHO PHP code by Stan Littlefield
		ECHO Batch file "wrapper" by Rob van der Woude
		ECHO http://www.robvanderwoude.com
		EXIT /B 1
	) ELSE (
		PHP.EXE -r "print(idate('W',strtotime('%~1')));"
	)
)
