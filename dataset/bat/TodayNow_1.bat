@GOTO Run

o 70 0E
i 71
o 70 32
i 71
o 70 09
i 71
o 70 08
i 71
o 70 07
i 71
o 70 04
i 71
o 70 02
i 71
o 70 00
i 71

q

:Run
@ECHO OFF
SETLOCAL ENABLEDELAYEDEXPANSION
IF NOT "%~1"=="" GOTO Syntax
SET Check=
SET TodayNow=
FOR /F "skip=1" %%A IN ('DEBUG ^< "%~fs0" ^| FIND /V "-"') DO (
	If "!Check!"=="" (
		SET Check=%%A
	) ELSE (
		SET TodayNow=!TodayNow!%%A
	)
)
IF 0x%Check% LSS 0x80 (
	ECHO.%TodayNow%
) ELSE (
	ECHO %TodayNow%_CMOS_RTC_NOT_SET
)
ENDLOCAL
GOTO:EOF

:Syntax
ECHO TodayNow.bat,  Version 1.10 for Windows NT 4 and later
ECHO Display the current date and time without delimiters
ECHO.
ECHO Usage:    TODAYNOW
ECHO.
FOR /F %%A IN ('%~sf0') DO SET TodayNow=%%A
SET TodayNow=%TodayNow:~0,14%
ECHO Returns:  %TodayNow%
ECHO          ^(YYYYMMDDHHmmss^)
ECHO Or:       %TodayNow%_CMOS_RTC_NOT_SET if CMOS clock not set
ECHO.
ECHO Sources:
ECHO http://mirror.href.com/thestarman/asm/debug/debug2.htm
ECHO http://www.plasma-online.de/textual/download/misc/cmos_registers.html
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
