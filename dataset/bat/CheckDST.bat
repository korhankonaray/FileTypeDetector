@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Check command line arguments -- none required
IF NOT "%~1"=="" GOTO Syntax

:: Display header -- on screen only
>CON ECHO Computers without automatic DST adjustment:

:: Find active computers without DST adjustment
FOR /F %%A IN ('NET.EXE VIEW ^| FIND.EXE "\\"') DO (
	FOR /F "tokens=5 delims=\ " %%B IN ('NET.EXE TIME %%A 2>NUL ^| FIND.EXE "Local time"') DO (
		ECHO.%%B
	)
)

:: Done
GOTO:EOF


:Syntax
ECHO.
ECHO CheckDST.bat,  Version 1.00 for Windows NT 4 and later
ECHO Check which active computers don't have automatic DST adjustment.
ECHO.
ECHO Usage:  CHECKDST
ECHO.
ECHO Note:   This check should only be performed during DST,
ECHO         otherwise the list will be empty.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
