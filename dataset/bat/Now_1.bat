@GOTO Run

o 70 04
i 71
o 70 02
i 71
o 70 00
i 71

q

:Run
@ECHO OFF
IF     "%~1"=="/?" GOTO Syntax
IF     "%~1"=="-?" GOTO Syntax
IF NOT "%~2"==""   GOTO Syntax
SETLOCAL ENABLEDELAYEDEXPANSION
SET H=
SET M=
FOR /F "skip=1" %%A IN ('DEBUG ^< "%~sf0" ^| FIND /V "-"') DO (
	IF "!H!"=="" (
		SET H=%%A
	) ELSE (
		IF "!M!"=="" (
			SET M=%%A
		) ELSE (
			ECHO.!H!%~1!M!%~1%%A
		)
	)
)
ENDLOCAL
GOTO:EOF

:Syntax
ECHO.
ECHO Now.bat,  Version 1.00 for Windows NT 4 and later
ECHO Display the current time with your choice of delimiter
ECHO.
ECHO Usage:    NOW  [ delimiter ]
ECHO.
FOR /F "tokens=1-3" %%A IN ('%~sf0 " "') DO (
	ECHO Returns:  %%A %%B %%C ^(hh mm ss^) with any delimiter you choose
	ECHO.
	ECHO Examples: NOW :     -^>  %%A:%%B:%%C
	ECHO           NOW .     -^>  %%A.%%B.%%C
	ECHO           NOW " "   -^>  %%A %%B %%C
	ECHO           NOW "^&"  -^>  %%A^&%%B^&%%C
	ECHO           NOW       -^>  %%A%%B%%C
	ECHO           NOW +++   -^>  %%A+++%%B+++%%C
)
ECHO.
ECHO Based on a sample from The Starman's DEBUG Tutorial
ECHO http://mirror.href.com/thestarman/asm/debug/debug2.htm
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
