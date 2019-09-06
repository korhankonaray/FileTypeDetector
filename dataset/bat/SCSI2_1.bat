@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
VER | FIND "Windows NT" >NUL
IF NOT ERRORLEVEL 1 GOTO Syntax
IF NOT [%1]==[] GOTO Syntax

SETLOCAL
IF EXIST "%Temp%.\SCSI.REG" DEL "%Temp%.\SCSI.REG"
START /WAIT REGEDIT /E "%Temp%.\SCSI.REG" "HKEY_LOCAL_MACHINE\HARDWARE\DEVICEMAP\Scsi"
FOR /F "tokens=7,10-14 delims=]\ " %%A in ('TYPE "%Temp%.\SCSI.REG"') DO IF /I "%%C %%D"=="Target Id" IF "%%F"=="" CALL :DriveType Port %%A Bus %%B ID %%E
IF EXIST "%Temp%.\SCSI.REG" DEL "%Temp%.\SCSI.REG"
IF EXIST "%Temp%.\SCDR.REG" DEL "%Temp%.\SCDR.REG"
ENDLOCAL
GOTO:EOF

:DriveType
IF EXIST "%Temp%.\SCDR.REG" DEL "%Temp%.\SCDR.REG"
START /WAIT REGEDIT /E "%Temp%.\SCDR.REG" "HKEY_LOCAL_MACHINE\HARDWARE\DEVICEMAP\Scsi\Scsi Port %2\Scsi Bus %4\Target Id %6"
IF NOT EXIST "%Temp%.\SCDR.REG" GOTO:EOF
FOR /F "tokens=1* delims==" %%A IN ('TYPE "%Temp%.\SCDR.REG"') DO SET %%~A=%%~B
IF "%Type%"=="CdRomPeripheral" (
	ECHO SCSI Port %2, Bus %4, ID %6, %DeviceName%=%Identifier%
) ELSE (
	ECHO SCSI Port %2, Bus %4, ID %6, %Type%=%Identifier%
)
GOTO:EOF

:Syntax
ECHO.
ECHO SCSI.bat,  Version 2.10 for Windows 2000 / XP
ECHO Enumerate SCSI drives
ECHO.
ECHO Usage:  SCSI  [ /? ]
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
