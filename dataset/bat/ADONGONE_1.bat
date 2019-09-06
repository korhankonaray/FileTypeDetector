@ECHO OFF
ECHO.
ECHO AdOnGone.bat,  Version 1.00 for Windows 2000 and later
ECHO Restore disappeared add-ons after a Firefox 2.*.* update
ECHO.
ECHO Usage with confirmation:  ADONGONE.BAT
ECHO.
ECHO Or without confirmation:  ECHO Y ³ ADONGONE.BAT
ECHO.
ECHO Notes: Firefox needs to be closed before running this batch file.
ECHO        In Windows XP, you will be asked to close Firefox if it is
ECHO        still running, in Windows 2000 no such check is done.
ECHO        In Windows XP, the command line without confirmation won't
ECHO        work if Firefox is still running.
ECHO.
ECHO Based on a blog entry Thomas Freudenberg
ECHO http://thomasfreudenberg.com/blog/archive/2007/09/20/
ECHO all-firefox-extensions-gone-after-upgrading-to-2-0-7.aspx
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF NOT "%OS%"=="Windows_NT" EXIT
IF NOT "%~1"=="" GOTO:EOF
VER | FIND "Windows NT" >NUL && GOTO:EOF

ECHO.
ECHO.

SETLOCAL ENABLEDELAYEDEXPANSION

VER | FIND.EXE /I "Windows 2000" >NUL
IF ERRORLEVEL 1 (
	TASKLIST.EXE /FI "IMAGENAME eq FIREFOX.EXE" 2>NUL | FIND /I "FIREFOX.EXE" >NUL
	IF NOT ERRORLEVEL 1 (
		ECHO Please close Firefox and press any key to continue . . .
		PAUSE > NUL
		TASKKILL.EXE /F /IM FIREFOX.EXE >NUL 2>&1
		ECHO.
	)
)
FOR /D %%A IN ("%AppData%\Mozilla\Firefox\Profiles\*.default") DO (
	SET Found=0
	FOR %%B IN (cache ini rdf) DO (
		IF EXIST "%%~fA\extensions.%%B" SET /A Found = !Found! + 1
	)
	IF !Found! GTR 0 (
		ECHO You are about to delete the following !Found! files:
		ECHO.
		FOR %%B IN (cache ini rdf) DO (
			IF EXIST "%%~fA\extensions.%%B" (
				ECHO "%%~fA\extensions.%%B"
			)
		)
		SET Answer=N
		ECHO.
		SET /P Answer=Do you want to continue? [y/N] 
		IF /I "!Answer:~0,1!"=="Y" (
			FOR %%B IN (cache ini rdf) DO (
				IF EXIST "%%~fA\extensions.%%B" (
					DEL "%%~fA\extensions.%%B"
				)
			)
			ECHO.
			ECHO Done.
		)
	)
)

ENDLOCAL
