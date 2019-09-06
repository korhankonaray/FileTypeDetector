@ECHO OFF
:: Not for Windows 9x nor MS-DOS
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Localize the environment variable used
SETLOCAL

:: Only 1 command line argument allowed
IF NOT "%~2"=="" GOTO Syntax

:: Windows XP only
VER | FIND "5.1." >NUL || GOTO Syntax

:: Command line argument can only be a valid computer name
ECHO.%~1 | FINDSTR /R /C:"[/?\*:;,@\\\+]" >NUL && GOTO Syntax
IF NOT "%~1"=="" (
	PING %1 -n 2 2>NUL | FIND "TTL=" >NUL
	IF ERRORLEVEL 1 (
		GOTO Syntax
	) ELSE (
		SET RemotePC=%~1
		SET RemotePC=%RemotePC:\=%
	)
)

:: Do NOT display the last user name at logon
:: REG Add "HKCU\SOFTWARE\Microsoft\Windows\CurrentVersion\Policies" /v DontDisplayLastUserName /t REG_DWORD /d 1 /f
REG Add "%RemotePC%HKLM\SOFTWARE\Microsoft\Windows\CurrentVersion\Policies" /v DontDisplayLastUserName /t REG_DWORD /d 1 /f

:: Require Ctrl+Alt+DEl at logon
REG Add "%RemotePC%HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" /v DisableCAD /t REG_DWORD /d 0 /f

:: Use "classic" login screen instead of XP Welcome screen
REG Add "%RemotePC%HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" /v LogonType  /t REG_DWORD /d 0 /f

:: Done
ENDLOCAL
GOTO:EOF


:Syntax
ECHO SecLogin.bat,  Version 1.00 for Windows XP
ECHO Make Windows XP's logon more secure by using the "classic" login dialog
ECHO instead of the welcome screen, disabling the display of the last user name
ECHO at logon, and requiring Ctrl+Alt+Del to logon
ECHO.
ECHO Usage:  SECLOGIN  [ remote ]
ECHO.
ECHO Where   remote    is an optional remote computer name to which the changes
ECHO                   should be applied (default is the local computer)
ECHO.
ECHO Note:   This batch file modifieds the registry, which is always risky.
ECHO         Use this batch file entirely at your own risk.
ECHO         Make sure you have a tested full backup and the appropriate restore
ECHO         software available before running this batch file.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" ENDLOCAL
