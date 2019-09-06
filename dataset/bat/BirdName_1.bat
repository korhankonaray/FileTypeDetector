@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax


:: Enable delayed variable expansion
SETLOCAL ENABLEDELAYEDEXPANSION


:: Check command line argument(s)
IF "%~1"=="" GOTO Syntax
ECHO.%* | FIND "?" >NUL && GOTO Syntax


:: Check if FINDSTR is available
FINDSTR /? 2>&1 | FIND "/B" >NUL || GOTO Syntax

:: Check if WGetTxt.vbs is available
SET WGetTxt=
SET Download=
SET Search="%CD%;%PATH%"
SET Search=%Search:;=" "%
FOR %%A IN (%Search%) DO (
	IF "!WGetTxt!"=="" (
		IF NOT "%%~A"=="" (
			IF EXIST "%%~A.\WGetTxt.vbs" (
				PUSHD "%%~fA"
				SET WGetTxt="!__CD__!WGetTxt.vbs"
				POPD
			)
		)
	)
)
:: Prompt for download if WGetTxt is not found
IF "%WGetTxt%"=="" (
	ECHO This batch file requires the WGetTxt.vbs script.
	SET /P Download=Do you want to download it now? [y/N] 
)
:: Start download if confirmed
IF /I "%Download%"=="Y" (
	START /WAIT http://www.robvanderwoude.com/files/wget.zip
	ECHO.
	ECHO UnZIP WGetTxt.vbs from the downloaded ZIP file, either to the current
	ECHO directory or to a directory listed in the PATH; then try again.
)
:: Abort if WGetTxt.vbs is not available yet
IF "%WGetTxtAvailable%"=="No" GOTO End


SET BirdName.Dutch=%*
SET _BirdName.Dutch=%BirdName.Dutch: =_%
SET BirdName.Danish=
SET BirdName.English=
SET BirdName.French=
SET BirdName.German=
SET BirdName.Scientific=
FOR /F "tokens=2 delims=()" %%A IN ('CSCRIPT.EXE //NoLogo %WGetTxt% /U:http://nl.wikipedia.org/wiki/%_BirdName.Dutch% ^| FINDSTR /R /I /C:"%BirdName.Dutch% ([^^)]*) is"') DO (
	IF "!BirdName.Scientific!"=="" SET BirdName.Scientific=%%A
)
IF NOT DEFINED BirdName.Scientific (
	FOR /F "tokens=2 delims=()" %%A IN ('CSCRIPT.EXE //NoLogo %WGetTxt% /U:http://nl.wikipedia.org/wiki/%_BirdName.Dutch% ^| FINDSTR /R /I /C:"%BirdName.Dutch% ([^^)]*) behoort"') DO (
		IF "!BirdName.Scientific!"=="" SET BirdName.Scientific=%%A
	)
)
ECHO.%BirdName.Scientific% | FIND "," >NUL && FOR /F "delims=," %%A IN ("%BirdName.Scientific%") DO SET BirdName.Scientific=%%A
ECHO.%BirdName.Scientific% | FIND "[" >NUL && FOR /F "delims=[" %%A IN ("%BirdName.Scientific%") DO SET BirdName.Scientific=%%A
SET _BirdName.Scientific=%BirdName.Scientific: =_%
FOR /F "tokens=*" %%A IN ('CSCRIPT.EXE //NoLogo %WGetTxt% /U:http://da.wikipedia.org/wiki/%_BirdName.Scientific% ^| FIND /V "[CDATA[" ^| FIND /V "." ^| FIND /V ""') DO (
	IF "!BirdName.Danish!"=="" SET BirdName.Danish=%%A
)
FOR /F "tokens=*" %%A IN ('CSCRIPT.EXE //NoLogo %WGetTxt% /U:http://en.wikipedia.org/wiki/%_BirdName.Scientific% ^| FIND /V "[CDATA[" ^| FIND /V "." ^| FIND /V ""') DO (
	IF "!BirdName.English!"=="" SET BirdName.English=%%A
)
FOR /F "tokens=*" %%A IN ('CSCRIPT.EXE //NoLogo %WGetTxt% /U:http://fr.wikipedia.org/wiki/%_BirdName.Scientific% ^| FIND /V "[CDATA[" ^| FIND /V "." ^| FIND /V ""') DO (
	IF "!BirdName.French!"=="" SET BirdName.French=%%A
)
FOR /F "tokens=*" %%A IN ('CSCRIPT.EXE //NoLogo %WGetTxt% /U:http://de.wikipedia.org/wiki/%_BirdName.Scientific% ^| FIND /V "[CDATA[" ^| FIND /V "." ^| FIND /V ""') DO (
	IF "!BirdName.German!"=="" SET BirdName.German=%%A
)
SET BirdName.
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO BirdName.bat,  Version 0.31 beta
ECHO Get scientific and some translated names for a specified Dutch bird name
ECHO.
ECHO Usage:  BIRDNAME  dutch bird name
ECHO.
ECHO Notes:  Do NOT use quotes for the Dutch bird name.
ECHO         Specified bird names must be complete, e.g. "Middelste Zaagbek" instead
ECHO         of just "Zaagbek" (do NOT use the quotes on the command line).
ECHO         This batch file requires WGetTxt.vbs to get information from Wikipedia;
ECHO         if WGetTxt.vbs is not found, you will be prompted to download it.
ECHO         It also requires FINDSTR, which is not native in Windows NT 4.
ECHO         Translations include Danish, English, French, German and scientific;
ECHO         support for Spanish could not be included yet, because WikiPedia Spain
ECHO         uses the scientific name for the page title.
ECHO         This batch file will break when WikiPedia changes its page layout.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
IF "%OS%"=="Windows_NT" ENDLOCAL
IF "%OS%"=="Windows_NT" EXIT /B 1
