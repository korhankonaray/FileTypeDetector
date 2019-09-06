@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION

IF "%~2"=="" GOTO Syntax

:: Check Windows version (abort if not Vista or later)
FOR /F "tokens=*" %%A IN ('VER') DO (
	FOR %%B IN (%%A) DO (
		FOR /F "delims=[]." %%C IN ("%%~B") DO (
			SET Winver=%%C
		)
	)
)
IF %WinVer% LSS 6 GOTO Syntax

:: Initialize variables with valid options
SET Compatibility.OS=WIN95;WIN98;WIN4SP5;WIN2000;WINXPSP2;WINXPSP3;VISTARTM;VISTASP1;VISTASP2;WIN7RTM;WINSRV03SP1;WINSRV08SP1
SET Compatibility.Options=256COLOR;640X480;DISABLETHEMES;DISABLEDWM;HIGHDPIAWARE;RUNASADMIN
SET Compatibility.Set.Options=
SET Compatibility.Set.Count=0

:: Check validity of command line arguments
SET LoopCount=0
FOR %%A IN (%*) DO (
	SET /A LoopCount += 1
	IF !LoopCount! EQU 1 (
		REM First argument is program path
		IF EXIST "%%~A" (
			SET ProgPath=%%~fA
		) ELSE (
			GOTO Syntax
		)
	) ELSE (
		REM Second and following arguments are the options
		SET Found=!Compatibility.Set.Count!
		FOR %%B IN (%Compatibility.OS%;%Compatibility.Options%) DO (
			IF /I "%%~A"=="%%~B" (
				SET /A Compatibility.Set.Count += 1
			)
		)
		REM If the argument is not found in the
		REM list of OSs or Options, it is invalid
		IF !Found! EQU !Compatibility.Set.Count! GOTO Syntax
	)
)
:: At least 1 OS/Option must be specified
IF %Compatibility.Set.Count% EQU 0 GOTO Syntax

:: Check if (only 1) OS is specified
SET LoopCount=0
SET Compatibility.Set.Count=0
SET Compatibility.Set.Options=
FOR %%A IN (%*) DO (
	SET /A LoopCount += 1
	IF !LoopCount! NEQ 1 (
		FOR %%B IN (%Compatibility.OS%) DO (
			IF /I "%%~A"=="%%~B" (
				SET /A Compatibility.Set.Count += 1
				SET Compatibility.Set.Options=%%~B
			)
		)
	)
)
:: Abort if multiple OSs were specified
IF %Compatibility.Set.Count% GTR 1 GOTO Syntax

:: Format specified options (whitespace, no quotes)
SET Compatibility.Set.Count=0
FOR %%A IN (%*) DO (
	FOR %%B IN (%Compatibility.Options%) DO (
		IF /I "%%~A"=="%%~B" (
			SET /A Compatibility.Set.Count += 1
			SET Compatibility.Set.Options=!Compatibility.Set.Options! %%~B
		)
	)
)
:: Remove leading whitespace
IF "%Compatibility.Set.Options:~0,1%"==" " SET Compatibility.Set.Options=%Compatibility.Set.Options:~1%

:: If all went well, we can now write the options to the registry
IF Compatibility.Set.Count GTR 0 (
	REG.EXE Add "HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\AppCompatFlags\Layers" /V "%ProgPath%" /T REG_SZ /D "!Compatibility.Set.Options!" /F
)

ENDLOCAL
GOTO:EOF


:Syntax
IF "%OS%"=="Windows_NT" ENDLOCAL

:: Set codepage to properly display vertical line characters for DOS
IF NOT "%OS%"=="Windows_NT" CHCP 437

ECHO.
ECHO AppCompat.bat,  Version 1.01 for Windows 7
ECHO Add an Application Compatibility Layer for the specified program
ECHO.
IF NOT "%OS%"=="Windows_NT" GOTO NoEscape
ECHO Usage:  APPCOMPAT  program  [ os  ^|  screen  ^|  priv ]
GOTO Next
:NoEscape
:: ³ is ASCII character 179 (vertical line), used to emulate pipe symbol in DOS
ECHO Usage:  APPCOMPAT  program  [ os  ³  screen  ³  priv ]
:Next
ECHO.
ECHO Where:  program  is the fully qualified or relative path to the program
ECHO         os       is the optional operating system mode: WIN95, WIN98, WIN4SP5,
ECHO                  WIN2000, WINXPSP2, WINXPSP3, VISTARTM, VISTASP1, VISTASP2,
ECHO                  WIN7RTM, WINSRV03SP1 or WINSRV08SP1
ECHO         screen   is the optional restriction(s) for screen settings: 256COLOR,
ECHO                  640X480, DISABLETHEMES, DISABLEDWM and/or HIGHDPIAWARE
ECHO         priv     is the optional privilege level: RUNASADMIN
ECHO.
ECHO Notes:  At least one option must be specified; more allowed, but 1 OS maximum.
ECHO         Option values are for Windows 7; this batch file may (or may not)
ECHO         work in Vista (not tested), but with a limited set of values.
ECHO         The options for Windows 7 are described in more details on:
ECHO         http://www.verboon.info/index.php/2011/03/
ECHO         running-an-application-as-administrator-or-in-compatibility-mode/
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:: Errorlevel 1 without the need for EXIT /B
IF "%OS%"=="Windows_NT" COLOR 00
