@ECHO OFF
ECHO.

:: Check Windows version (XP Pro or later) and command line arguments (none)
IF NOT "%OS%"=="Windows_NT"    GOTO Syntax
IF NOT "%~1"==""               GOTO Syntax
WMIC.EXE Alias /? >NUL 2>&1 || GOTO Syntax

:: Retrieve drive info
FOR /F "tokens=1* delims==" %%A IN ('WMIC Path Win32_DiskPartition Where "BootPartition=true And PrimaryPartition=true" Get DeviceID /Format:list') DO IF NOT "%%~B"=="" SET BootPartition=%%B
FOR /F "tokens=1 delims=[]" %%A IN ('WMIC Path Win32_LogicalDiskToPartition Get Antecedent^,Dependent /Format:list ^| FIND /N "=" ^| FIND /I "%BootPartition%"') DO SET LineNum=%%A
SET /A LineNum+=1
FOR /F "tokens=3 delims=="  %%A IN ('WMIC Path Win32_LogicalDiskToPartition Get Antecedent^,Dependent /Format:list ^| FIND /N "=" ^| FINDSTR /B /L /C:"\[%LineNum%\]"') DO SET BootDrive=%%~A

:: Format output
FOR /F "tokens=1,2 delims=," %%A IN ("%BootPartition%") DO (
	SET BootDisk=%%A
	SET BootPartition=%%B
)
SET BootPartition=%BootPartition:~1%
SET BootDrive=%BootDrive:"=%

:: Display the results:
SET Boot

:: Done
GOTO:EOF


:Syntax
ECHO BootDisk.bat, Version 1.01 for Windows XP Pro and later
ECHO Displays boot disk, partition and drive letter.
ECHO.
ECHO Usage:  BOOTDISK
ECHO.
ECHO Notes:  The results are displayed on screen and stored in environment
ECHO         variables named BootDisk, BootDrive and BootPartition.
ECHO         This batch file uses WMIC, which is native in Windows XP
ECHO         Professional and all later Windows versions.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
ECHO.

:: Set errorlevel 1 in Windows NT 4 and later versions
IF "%OS%"=="Windows_NT" COLOR 00
