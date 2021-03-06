@ECHO OFF
ECHO.

:: Check command line parameter
IF NOT "%1"=="" IF /I NOT "%1"=="/V" GOTO Syntax

:: Check for correct Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Keep variables local
SETLOCAL

:: /V parameter set verbose display
IF /I "%1"=="/V" SET Verbose=1

:: Gather info from the registry
REGEDIT /E "%Temp%.\Hotfixes.dat" "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Hotfix"

:: Display header
ECHO Hotfixes installed on this PC:
ECHO.

:: Summarize all hotfixes gathered from registry
FOR /F "tokens=7 delims=\" %%a IN ('TYPE "%Temp%.\Hotfixes.dat" ^| FIND "[HKEY_"') DO FOR /F "tokens=1 delims=]" %%A IN ('ECHO.%%a ^| FIND "]"') DO CALL :Summarize "%%A"

:: Remove temporary file
IF EXIST "%Temp%.\Hotfixes.dat" DEL "%Temp%.\Hotfixes.dat"

:: Done
ENDLOCAL
GOTO:EOF

:Summarize
SETLOCAL
SET Hotfix=%~1
:: No more details required
IF NOT "%Verbose%"=="1" (
	ECHO.%Hotfix%
	GOTO:EOF
)
:: Gather more details from the registry
REGEDIT /E "%Temp%.\Hotfixes.dat" "HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Hotfix\%~1"
:: Retrieve the hotfix description from the temporary file we just created
FOR /F "tokens=1* delims==" %%a IN ('TYPE "%Temp%.\Hotfixes.dat" ^| FIND /I "Fix Description"') DO SET Description=%%~b
:: Escape brackets in the description, otherwise the ECHO command will fail
IF DEFINED Description SET Description=%Description:(=^^^(%
IF DEFINED Description SET Description=%Description:)=^^^)%
:: The whitespace in the following line is a tab
ECHO.%Hotfix%	%Description%
ENDLOCAL
GOTO:EOF

:Syntax
ECHO Hotfixes.bat,  Version 2.00 for Windows NT 4 / 2000
ECHO Displays a list of hotfixes installed locally
ECHO.
ECHO Usage:  HOTFIXES  [ /V ]
ECHO.
ECHO         /V  list both hotfix numbers and descriptions
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
GOTO:EOF
