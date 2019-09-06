@GOTO Run

o 70 0b
i 71

q


:Syntax
ECHO.
ECHO CMOSDST.bat,  Version 1.00 for Windows NT 4 and later
ECHO Check if Daylight Saving Time is enabled for the CMOS clock
ECHO.
ECHO Usage:    CMOSDST
ECHO.
ECHO Returns:  On screen text: Clock Daylight Saving Time DISABLED or ENABLED
ECHO           Return code (errorlevel) 0 = DISABLED, 1 = ENABLED
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
GOTO :End


:Run
::@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
:: Check command line (no arguments required)
IF NOT "%~1"=="" GOTO Syntax
:: Localize variables
SETLOCAL
:: Read bit 0 of CMOS register 11
FOR /F "skip=1" %%A IN ('DEBUG ^< "%~sf0" ^| FIND /V "-"') DO SET /A DST = "0x%%~A %% 2"
:: Display the result on screen and set returncode
IF %DST% EQU 0 (
	ECHO CMOS Clock Daylight Saving Time DISABLED
	ENDLOCAL
) ELSE (
	ECHO CMOS Clock Daylight Saving Time ENABLED
	ENDLOCAL
	COLOR FF
)
:End
