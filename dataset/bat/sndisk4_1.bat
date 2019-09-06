@ECHO OFF
:: Check Windows version: batch file not suited for DOS
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: No command line arguments allowed
IF NOT "%~1"=="" GOTO Syntax

:: Check if EGatherer 2.51.* is located in the same directory as this script
IF NOT EXIST "%~dp0egather2-2.51.*" GOTO Syntax

:: Enable delayed variable expansion
SETLOCAL ENABLEDELAYEDEXPANSION

:: Check if this is a 64-bit OS
SET OS=
FOR /F "tokens=2 delims==" %%A IN ('WMIC Path Win32_Processor Get AddressWidth /Format:list 2^>NUL') DO (
	IF "%%~A"=="64" (
		SET OS=-64OS
	)
)

:: Find the most recent EGatherer 2.51.* and extract its worker files
SET EG=
FOR %%A IN (egather2-2.51.*) DO SET EG=%%~fA
SET Started=0
START /B "" "!EG!"

:Loop1
TASKLIST /FI "IMAGENAME eq worker.exe" 2>NUL | FINDSTR /R /B /I /C:"worker\.exe " >NUL && SET Started=1
IF %Started%==1 (
	TASKKILL /FI "IMAGENAME eq worker.exe" >NUL 2>&1
) ELSE (
	PING 127.0.0.1 -n 1 -w 250 >NUL 2>&1
	GOTO Loop1
)

:: Run EGatherer silently
PUSHD C:\IBM_Support\Egatherer
START /B eg2.exe -silent %OS%

:: As long as the process is running, copy the contents of its temporary file
:Loop2
FOR %%A IN (ega*.tmp) DO (
	TYPE %%A >NUL
	COPY /Y %%A "%~dpn0.xml" >NUL 2>&1
)
TASKLIST /FI "IMAGENAME eq eg2.exe" 2>NUL | FINDSTR /R /B /I /C:"eg2\.exe " >NUL && GOTO Loop2

:: Clean up the mess
POPD
RD /S /Q C:\IBM_Support

:: Open the resulting XML file
START "" "%~dpn0.xml"

GOTO End


:Syntax
ECHO.
ECHO SNDisk4.bat,  Version 1.00 for Windows XP and later
ECHO Save a full inventory in XML using IBM's EGather2 Version 2.51
ECHO.
ECHO Usage:  SNDISK4
ECHO.
ECHO Notes:  All inventory details will be stored in sndisk4.xml
ECHO         in the same directory as this batch file.
ECHO         EGather2-2.51.*.exe must also be located in the same
ECHO         directory as this batch file.
ECHO         IBM's EGather2 can be found at (URL wrapped):
ECHO         http://www.ibm.com/systems/support/supportsite.wss
ECHO         /docdisplay?brandind=5000008^&lndocid=MIGR-4R5VKC
ECJO         Tested with EGather2-2.51.0374.exe on Windows 7 64-bit.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com


:End
IF "%OS%"=="Windows_NT" ENDLOCAL
