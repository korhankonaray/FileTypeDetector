@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT  "%~1"==""           GOTO Syntax

SETLOCAL
SET Fxc=%UserProfile%\Local Settings\Application Data\Mozilla\Firefox\Profiles
FOR /D %%A IN ("%Fxc%\*.*") DO (
	IF EXIST "%%~fA\Cache\*.*" DEL /F /Q "%%~fA\Cache\*.*" >NUL 2>&1
)
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO FlushFxC.bat,  Version 1.00 for Windows NT 4 and later
ECHO Flush Firefox's cache in the current user's Windows profile
ECHO.
ECHO Usage:  FLUSHFXC.BAT
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
