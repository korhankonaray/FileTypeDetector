@ECHO OFF
:: Check Windows version (NT 4 or later)
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Localize variables
SETLOCAL ENABLEDELAYEDEXPANSION

:: Check Windows version (XP or later)
VER | FIND "Windows NT"   >NUL && GOTO Syntax
VER | FIND "Windows 2000" >NUL && GOTO Syntax

:: Check if WMIC.EXE is available
WMIC.EXE Alias /?:Brief >NUL 2>&1 || GOTO Syntax

:: Check command line arguments: the first argument must be a file
:: (script or executable), which may or may not be specified with
:: an extension and/or a path, so we need to find the fully qualified
:: path and file name first
IF "%~1"=="" GOTO Syntax
SET Prog="%~1"
IF NOT EXIST %Prog% IF NOT EXIST "%~1.*" SET Prog="%~$PATH:1"
IF %Prog%=="" IF "%~x1"=="" (
	FOR %%A IN (%PathExt%) DO (
		FOR %%B IN ("%~1%%A") DO IF !Prog!=="" SET Prog="%%~$PATH:B"
	)
)
IF NOT EXIST %Prog%          GOTO Syntax
DIR /A-D %Prog% >NUL 2>&1 || GOTO Syntax
SET Check=0
FOR %%A IN (%PathExt%) DO (
	FOR %%B IN (%Prog%) DO (
		IF /I "%%~xB"=="%%~A" SET Check=1
	)
)
IF NOT "%Check%"=="1" GOTO Syntax

:: Variables to translate the returned BatteryStatus integer to a descriptive text
SET BatteryStatus.1=discharging
SET BatteryStatus.2=The system has access to AC so no battery is being discharged. However, the battery is not necessarily charging.
SET BatteryStatus.3=fully charged
SET BatteryStatus.4=low
SET BatteryStatus.5=critical
SET BatteryStatus.6=charging
SET BatteryStatus.7=charging and high
SET BatteryStatus.8=charging and low
SET BatteryStatus.9=charging and critical
SET BatteryStatus.10=UNDEFINED
SET BatteryStatus.11=partially charged

:: Read the battery status
FOR /F "tokens=*" %%A IN ('WMIC Path Win32_Battery Get BatteryStatus /Format:List ^| FIND "="') DO SET %%A

:: Check the battery status, and display a warning message if running on battery power
IF NOT "%BatteryStatus%"=="2" (
	> "%~dpn0.vbs" ECHO MsgBox vbLf ^& "The laptop is currently running on its battery." ^& vbLf ^& vbLf ^& "The battery is !BatteryStatus.%BatteryStatus%!." ^& vbLf ^& vbLf ^& "Connect the laptop to the mains voltage if possible." ^& vbLf ^& " "^, vbWarning^, "Battery Warning"
	CSCRIPT //NoLogo "%~dpn0.vbs"
	DEL "%~dpn0.vbs"
)

:: Run the command specified in the command line arguments, starting from its own directory
FOR %%A IN (%Prog%) DO PUSHD "%%~dpA"
START "" %*
POPD
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO BattRun.bat,  Version 1.00 for Windows XP Pro and later
ECHO Checks if the computer is running on batteries before starting a program.
ECHO Will display a warning message if the computer is running on battery power.
ECHO.
ECHO Usage:   BATTRUN  program  [ arguments ]
ECHO.
ECHO Where:   "program"    is the program to start after checking the battery status
ECHO          "arguments"  are the optional command line arguments for "program"
ECHO.
ECHO Example: BATTRUN CMD /C PAUSE
ECHO.
ECHO Notes:   The program will be started in its own parent directory.
ECHO          This batch file requires WMIC, which is available in Windows XP Pro,
ECHO          Windows Server 2003 and Windows Vista.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" ENDLOCAL
