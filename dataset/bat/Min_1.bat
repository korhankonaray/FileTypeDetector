@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF "%~2"=="" GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION
SET Min=%~1
FOR %%A IN (%*) DO (
	ECHO.%%~A| FINDSTR /R /I /C:"[^0-9-]" >NUL
	IF NOT ERRORLEVEL 1 (
		ENDLOCAL
		GOTO Syntax
	)
	IF %%~A LSS !Min! SET /A Min = %%~A
)
ECHO.%Min%
ENDLOCAL & SET Min=%Min%
EXIT /B 0


:Syntax
ECHO.
ECHO Min.bat,  Version 1.00 for Windows NT4+
ECHO Returns the lowest from a list of values on the command line
ECHO.
ECHO Usage:  MIN  num1  num2  [ num3  [ num4 ... ] ]
ECHO.
ECHO Notes:  The lowest value is displayed on screen and stored in an environment
ECHO         variable %%Min%%.
ECHO         Works with (signed) integers only, size limited by OS version.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" EXIT /B 1
