@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
VER | FIND "Windows NT" >NUL
IF NOT ERRORLEVEL 1 GOTO Syntax
IF NOT [%1]==[] GOTO Syntax

SETLOCAL
REGEDIT /E "%Temp%.\SCSI.REG" "HKEY_LOCAL_MACHINE\HARDWARE\DEVICEMAP\Scsi"
FOR /F "tokens=3 delims=] " %%A IN ('TYPE "%Temp%.\SCSI.REG" ^| EGREP -i "\[HKEY_LOCAL_MACHINE\\HARDWARE\\DEVICEMAP\\Scsi\\Scsi Port [0-9]+\]"') DO CALL :EnumBus Port %%A
DEL "%Temp%.\SCSI.REG"
ENDLOCAL
GOTO:EOF

:EnumBus
FOR /F "tokens=5 delims=] " %%K IN ('TYPE "%Temp%.\SCSI.REG" ^| EGREP -i "\[HKEY_LOCAL_MACHINE\\HARDWARE\\DEVICEMAP\\Scsi\\Scsi Port %2\\Scsi Bus [0-9]+\]"') DO CALL :EnumId Port %2 Bus %%K
GOTO:EOF

:EnumId
FOR /F "tokens=7 delims=] " %%X IN ('TYPE "%Temp%.\SCSI.REG" ^| EGREP -i "\[HKEY_LOCAL_MACHINE\\HARDWARE\\DEVICEMAP\\Scsi\\Scsi Port %2\\Scsi Bus %4\\Target Id [0-9]+\]"') DO CALL :DriveType Port %2 Bus %4 ID %%X
GOTO:EOF

:DriveType
REGEDIT /E "%Temp%.\SCSIDRV.REG" "HKEY_LOCAL_MACHINE\HARDWARE\DEVICEMAP\Scsi\Scsi Port %2\Scsi Bus %4\Target Id %6"
FOR /F "tokens=1* delims==" %%A IN ('TYPE "%Temp%.\SCSIDRV.REG"') DO SET %%~A=%%~B
DEL "%Temp%.\SCSIDRV.REG"
IF "%Type%"=="CdRomPeripheral" (
	ECHO SCSI Port %2, Bus %4, ID %6, %DeviceName%=%Identifier%
) ELSE (
	ECHO SCSI Port %2, Bus %4, ID %6, %Type%=%Identifier%
)
GOTO:EOF

:Syntax
ECHO.
ECHO SCSI.bat,  Version 1.10 for Windows 2000 / XP
ECHO Enumerate SCSI drives
ECHO.
ECHO Usage:  SCSI
ECHO.
ECHO Uses EGREP.EXE, available at
ECHO http://unxutils.sourceforge.net/
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
