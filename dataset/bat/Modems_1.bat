@ECHO OFF
:: Check Windows version and command line arguments
IF NOT "%~1"=="" GOTO Syntax
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
VER | FIND "Windows NT" >NUL
IF NOT ERRORLEVEL 1 GOTO Syntax

:: Use local environment copy
SETLOCAL

:: Check if DEVCON.EXE is available and if not, offer to download it
SET Download=N
DEVCON.EXE /? >NUL 2>&1
IF ERRORLEVEL 1 (
	ECHO This batch file requires Microsoft's DEVCON untility.
	SET /P Download=Do you want to download it now? [y/N] 
)

:: Start either download or use DEVCON.EXE to display installed modems
IF /I "%Download%"=="Y" (
	START "DevCon" "http://support.microsoft.com/default.aspx?scid=kb;EN-US;Q311272"
) ELSE (
	ECHO.
	DEVCON.EXE resources =modem 2>NUL | FIND ": "
)
ENDLOCAL
GOTO:EOF

:Syntax
ECHO.
ECHO Modems.bat,  Version 1.01 for Windows 2000 / XP
ECHO Display locally installed modems and the resources they use
ECHO.
ECHO Usage:  MODEMS
ECHO.
ECHO This batch file uses DEVCON, a command line utility by Microsoft,
ECHO used to list, install or remove devices, or change their settings.
ECHO This batch files demonstrates how to simply list all available modems.
ECHO The actual command to list modems is: DEVCON.EXE resources =modem
ECHO If DEVCON is not found on the computer, you will be prompted to download
ECHO it at http://support.microsoft.com/default.aspx?scid=kb;EN-US;Q311272
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
