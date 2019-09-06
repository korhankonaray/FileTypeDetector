@GOTO Run
o 70 10
i 71
q

:Run
@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT "%~1"=="" GOTO Syntax
SETLOCAL ENABLEDELAYEDEXPANSION
SET Drv.0=None
SET Drv.1=360K
SET Drv.2=1.2M
SET Drv.3=720K
SET Drv.4=1.44M
FOR /F %%A IN ('DEBUG ^< %~sf0 ^| FIND /V "-"') DO SET Drv=%%A
FOR %%A IN (0 1) DO CALL ECHO Floppy Drive %%A: %%Drv.!Drv:~%%A,1!%%
ENDLOCAL
GOTO:EOF

:Syntax
ECHO.
ECHO Floppy.bat,  Version 1.01 for Windows NT 4 and later
ECHO Display the floppy drives configuration for the local computer
ECHO.
ECHO Usage:  FLOPPY.BAT
ECHO.
ECHO This batch file uses DEBUG to read the floppy disk configuration from the CMOS.
ECHO More information can be found in PLASMA Online's CMOS Register Reference:
ECHO http://www.plasma-online.de/textual/download/misc/cmos_registers.html
ECHO and in The Starman's DEBUG Tutorial:
ECHO http://mirror.href.com/thestarman/asm/debug/debug2.htm
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
