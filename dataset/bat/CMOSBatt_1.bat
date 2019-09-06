@GOTO Run

o 70 0d
i 71

q


:Syntax
ECHO.
ECHO CMOSBatt.bat,  Version 1.00 for Windows NT 4 and later
ECHO Check the CMOS battery status
ECHO.
ECHO Usage:    CMOSBATT
ECHO.
ECHO Returns:  On screen text: CMOS battery OK or NOT OK
ECHO           Return code (errorlevel) 0 = OK, 1 = NOT OK
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
GOTO :End


:Run
@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
:: Check command line (no arguments required)
IF NOT "%~1"=="" GOTO Syntax
:: Localize variables
SETLOCAL
:: Read bit 7 of CMOS register 13
FOR /F "skip=1" %%A IN ('DEBUG ^< "%~sf0" ^| FIND /V "-"') DO SET /A Status = "( 0x%%~A >> 7 ) %% 2"
:: Invert the result
SET /A Status = 1 - %Status%
:: Display the result on screen and set returncode
IF %Status% EQU 0 (
	ECHO CMOS battery OK
	ENDLOCAL
) ELSE (
	ECHO CMOS battery NOT OK
	ENDLOCAL
	COLOR FF
)
:End
