@GOTO Run
o 70 0E
i 71
q

:Run
@ECHO OFF
IF "%~1"=="" (
	FOR /F "skip=1" %%A IN ('DEBUG ^< "%~fs0" ^| FIND /V "-"') DO IF 0x0%%A GEQ 0x080 COLOR FF
) ELSE (
	ECHO.
	ECHO IsRTCSet.bat,  Version 1.00 for Windows NT 4 and later
	ECHO Return errolevel 1 if the CMOS Real Time Clock is not set
	ECHO.
	ECHO Usage:    CALL ISRTCSET
	ECHO           IF ERRORLEVEL 1 ^(
	ECHO               DATE
	ECHO               TIME
	ECHO           ^)
	ECHO.
	ECHO Sources:
	ECHO http://mirror.href.com/thestarman/asm/debug/debug2.htm
	ECHO http://www.plasma-online.de/textual/download/misc/cmos_registers.html
	ECHO.
	ECHO Written by Rob van der Woude
	ECHO http://www.robvanderwoude.com
)
