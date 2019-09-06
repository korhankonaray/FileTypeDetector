@ECHO OFF
ECHO o 70 10> Flop.dbg
ECHO i 71>>   Flop.dbg
ECHO q>>      Flop.dbg
DEBUG < Flop.dbg | FIND /V " " | DATE | FIND "):" > Temp.bat
ECHO SET FDDCfg=%%4>Enter.bat
CALL Temp.bat
FOR %%A IN (Temp.bat Enter.bat Flop.dbg) DO DEL %%A
IF "%FDDCfg%"=="00" ECHO Floppy Drive 0: None
IF "%FDDCfg%"=="00" ECHO Floppy Drive 1: None
IF "%FDDCfg%"=="01" ECHO Floppy Drive 0: None
IF "%FDDCfg%"=="01" ECHO Floppy Drive 1: 360K
IF "%FDDCfg%"=="02" ECHO Floppy Drive 0: None
IF "%FDDCfg%"=="02" ECHO Floppy Drive 1: 1.2M
IF "%FDDCfg%"=="03" ECHO Floppy Drive 0: None
IF "%FDDCfg%"=="03" ECHO Floppy Drive 1: 720K
IF "%FDDCfg%"=="04" ECHO Floppy Drive 0: None
IF "%FDDCfg%"=="04" ECHO Floppy Drive 1: 1.44M
IF "%FDDCfg%"=="10" ECHO Floppy Drive 0: 360K
IF "%FDDCfg%"=="10" ECHO Floppy Drive 1: None
IF "%FDDCfg%"=="11" ECHO Floppy Drive 0: 360K
IF "%FDDCfg%"=="11" ECHO Floppy Drive 1: 360K
IF "%FDDCfg%"=="12" ECHO Floppy Drive 0: 360K
IF "%FDDCfg%"=="12" ECHO Floppy Drive 1: 1.2M
IF "%FDDCfg%"=="13" ECHO Floppy Drive 0: 360K
IF "%FDDCfg%"=="13" ECHO Floppy Drive 1: 720K
IF "%FDDCfg%"=="14" ECHO Floppy Drive 0: 360K
IF "%FDDCfg%"=="14" ECHO Floppy Drive 1: 1.44M
IF "%FDDCfg%"=="20" ECHO Floppy Drive 0: 1.2M
IF "%FDDCfg%"=="20" ECHO Floppy Drive 1: None
IF "%FDDCfg%"=="21" ECHO Floppy Drive 0: 1.2M
IF "%FDDCfg%"=="21" ECHO Floppy Drive 1: 360K
IF "%FDDCfg%"=="22" ECHO Floppy Drive 0: 1.2M
IF "%FDDCfg%"=="22" ECHO Floppy Drive 1: 1.2M
IF "%FDDCfg%"=="23" ECHO Floppy Drive 0: 1.2M
IF "%FDDCfg%"=="23" ECHO Floppy Drive 1: 720K
IF "%FDDCfg%"=="24" ECHO Floppy Drive 0: 1.2M
IF "%FDDCfg%"=="24" ECHO Floppy Drive 1: 1.44M
IF "%FDDCfg%"=="30" ECHO Floppy Drive 0: 720K
IF "%FDDCfg%"=="30" ECHO Floppy Drive 1: None
IF "%FDDCfg%"=="31" ECHO Floppy Drive 0: 720K
IF "%FDDCfg%"=="31" ECHO Floppy Drive 1: 360K
IF "%FDDCfg%"=="32" ECHO Floppy Drive 0: 720K
IF "%FDDCfg%"=="32" ECHO Floppy Drive 1: 1.2M
IF "%FDDCfg%"=="33" ECHO Floppy Drive 0: 720K
IF "%FDDCfg%"=="33" ECHO Floppy Drive 1: 720K
IF "%FDDCfg%"=="34" ECHO Floppy Drive 0: 720K
IF "%FDDCfg%"=="34" ECHO Floppy Drive 1: 1.44M
IF "%FDDCfg%"=="40" ECHO Floppy Drive 0: 1.44M
IF "%FDDCfg%"=="40" ECHO Floppy Drive 1: None
IF "%FDDCfg%"=="41" ECHO Floppy Drive 0: 1.44M
IF "%FDDCfg%"=="41" ECHO Floppy Drive 1: 360K
IF "%FDDCfg%"=="42" ECHO Floppy Drive 0: 1.44M
IF "%FDDCfg%"=="42" ECHO Floppy Drive 1: 1.2M
IF "%FDDCfg%"=="43" ECHO Floppy Drive 0: 1.44M
IF "%FDDCfg%"=="43" ECHO Floppy Drive 1: 720K
IF "%FDDCfg%"=="44" ECHO Floppy Drive 0: 1.44M
IF "%FDDCfg%"=="44" ECHO Floppy Drive 1: 1.44M
GOTO End

:Syntax
ECHO.
ECHO FlopDOS.bat,  Version 1.00 for MS-DOS
ECHO Display the floppy drives configuration for the local computer
ECHO.
ECHO Usage:  FLOPDOS.BAT
ECHO.
ECHO This batch file uses DEBUG to read the floppy disk configuration from the CMOS.
ECHO More information can be found in PLASMA Online's CMOS Register Reference:
ECHO http://www.plasma-online.de/textual/download/misc/cmos_registers.html
ECHO and in The Starman's DEBUG Tutorial:
ECHO http://mirror.href.com/thestarman/asm/debug/debug2.htm
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
