@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT  "%~1"==""           GOTO Syntax
REG.EXE Add /? 2>NUL | FIND /I " /ve " >NUL || GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION
SET UNCList=
FOR /F "tokens=3" %%A IN ('NET USE ^| FINDSTR "[A-Z]:"') DO (
	SET UNC=%%A
	SET UNC=!UNC:\=\\!
	SET UNCList=!UNCList!!UNC!;file://!UNC!;
)
IF DEFINED UNCList (
	ECHO.
	ECHO [HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\HTMLHelp\1.x\ItssRestrictions]
	ECHO.
	REG Add   HKLM\SOFTWARE\Microsoft\HTMLHelp\1.x\ItssRestrictions /v MaxAllowedZone /t REG_DWORD /d         1 /f
	REG Query HKLM\SOFTWARE\Microsoft\HTMLHelp\1.x\ItssRestrictions /v MaxAllowedZone | FIND /I "MaxAllowedZone"
	ECHO.
	REG Add   HKLM\SOFTWARE\Microsoft\HTMLHelp\1.x\ItssRestrictions /v UrlAllowList   /t REG_SZ    /d %UNCList% /f
	REG Query HKLM\SOFTWARE\Microsoft\HTMLHelp\1.x\ItssRestrictions /v UrlAllowList   | FIND /I "UrlAllowList"
)
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO CHMFixUNC.bat,  Version 1.00 for Windows 7
ECHO Allow *.chm files to be opened from all currently mapped network drives
ECHO.
ECHO Usage:  CHMFIXUNC
ECHO.
ECHO Note:   This bath file sets the following registry values:
ECHO.
ECHO         [HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\HTMLHelp\1.x\ItssRestrictions]
ECHO         "MaxAllowedZone"=dword:00000001
ECHO         "UrlAllowList"="\\\\server1\\share1;file://\\\\server1\\share1;" etc.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" EXIT /B 1
