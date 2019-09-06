@ECHO OFF
:: Check Windows version: NT 4 or later required
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
:: Check number of command line arguments: 1 and only 1 required
IF     "%~1"=="" GOTO Syntax
IF NOT "%~2"=="" GOTO Syntax
:: Check if the command line argument consists of zeroes and ones only
ECHO "%~1"| FINDSTR /R /B /C:"\"[01][01]*\"$" >NUL || GOTO Syntax

:: Initialize the variables
SET Binary=%~1
SET Decimal=0
SET DigVal=1

:: Display the initial binary value
SET Binary

:Loop
:: Extract the last digit from the binary number
IF %Binary% GTR 1 (
	SET Digit=%Binary:~-1%
	SET Binary=%Binary:~0,-1%
) ELSE (
	SET /A Digit = %Binary%
	SET Binary=0
)
:: Add the digit's value to the decimal result
IF %Digit% EQU 1 SET /A Decimal = %Decimal% + %DigVal%
:: Increment the digit's value (multiply by 2)
SET /A DigVal *= 2
:: If the value of the remaining digits is
:: greater than 0, loop to the next iteration
IF %Binary% GTR 0 GOTO Loop

:: Clean up aal variables but one
SET Binary=
SET Digit=
SET DigVal=

:: Display the decimal result
SET Decimal

:: Exit with the decimal result as return code
EXIT /B %Decimal%


:Syntax
ECHO Bin2Dec.bat,  Version 1.00 for Windows NT 4 and later
ECHO Convert binary numbers to decimal
ECHO.
ECHO Usage:  BIN2DEC  binary_number
ECHO.
ECHO Where:  "binary_number"  is the binary number to be converted
ECHO                          (zeroes and ones only, no prefix nor suffix)
ECHO.
ECHO Notes:  The binary number and the decimal result are displayed as text on
ECHO         screen, and the decimal number is stored in an environment variable
ECHO         named "Decimal", and returned as "errorlevel" (return code); this
ECHO         means errorlevel 0 could mean decimal result 0 or a syntax error.
ECHO         This batch file requires FINDSTR, which is not available in NT 4; for
ECHO         Windows NT 4 use FINDSTR from the Microsoft Windows NT Resource Kit.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
