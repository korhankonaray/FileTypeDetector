@ECHO OFF
REM No command line parameters required
IF NOT [%1]==[] GOTO Syntax

REM Check if BATCHMAN.COM is available
BATCHMAN MONTH
IF NOT ERRORLEVEL 1 GOTO Syntax

REM Check for valid DOS versions
BATCHMAN DOSVER
IF NOT ERRORLEVEL  96 GOTO Syntax
IF     ERRORLEVEL 130 GOTO Syntax

REM Query CPU type
SET CPU=
BATCHMAN CPU
IF ERRORLEVEL 1 SET CPU=8086
IF ERRORLEVEL 2 SET CPU=80286
IF ERRORLEVEL 3 SET CPU=80386
IF ERRORLEVEL 4 SET CPU=80486 or better
ECHO CPU type: %CPU%
SET CPU=

REM Query BIOS date
BATCHMAN CECHO BIOS date:
BATCHMAN ROMDATE

REM Show disk summary and available base memory
CHKDSK /V

REM Show available extended memory
BATCHMAN CECHO Extended memory (XMS):
BATCHMAN EXTMEM R

REM Show available expanded memory
BATCHMAN CECHO Expanded memory (EMS):
BATCHMAN EXPMEM R

REM Query video (text) mode
SET VID=
BATCHMAN VIDEOMODE
IF ERRORLEVEL  1 SET VID=MDA
IF ERRORLEVEL  2 SET VID=CGA
IF ERRORLEVEL  4 SET VID=EGA color
IF ERRORLEVEL  5 SET VID=EGA mono
IF ERRORLEVEL  6 SET VID=PGS
IF ERRORLEVEL  7 SET VID=VGA mono
IF ERRORLEVEL  8 SET VID=VGA color
IF ERRORLEVEL 11 SET VID=MCGA mono
IF ERRORLEVEL 12 SET VID=MCGA color
ECHO Video mode: %VID%
SET VID=

GOTO End

:Syntax
ECHO.
ECHO Hardware.bat,  Version 1.00 for MS-DOS 3.0 .. 4.01
ECHO Display a hardware summary
ECHO.
ECHO Usage:  HARDWARE
ECHO.
ECHO This batch file requires BATCHMAN.COM by Michael Mefford
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
