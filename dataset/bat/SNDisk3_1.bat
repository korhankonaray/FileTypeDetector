@ECHO OFF
:: Check Windows version: batch file not suited for DOS.
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: No command line arguments required.
IF NOT "%~1"=="" GOTO Syntax

:: Localaize variables
SETLOCAL

:: Check availability and version of IBM's E-Gatherer tool.
SET EGather2Available=
SET Download=
%COMSPEC% /C EGATHER2.EXE -help 2>&1 | FIND.EXE "2.37" >NUL || (
	SET EGather2Available=No
	ECHO This batch file requires IBM's E-Gatherer 2.37.
	SET /P Download=Do you want to download it now? [y/N] 
) >CON

:: Start download if requested.
IF /I "%Download:~0,1%"=="Y" (
	START "EGather2" "http://www.pc.ibm.com/qtechinfo/MIGR-4R5VKC.html"
	ECHO.
	ECHO Download EGATHER2.EXE and store it in the current directory or the PATH.
	ECHO.
	PAUSE
	START "EGather2Fix" "http://www.ibm.com/pc/support/site.wss/document.do?lndocid=MIGR-54588"
	ECHO Next download the latest IBM Access Support fix pack and follow
	ECHO IBM's installation instructions.
	ECHO.
	PAUSE
) >CON

:: Abort if EGATHER2.EXE still isn't available.
%COMSPEC% /C EGATHER2.EXE -help 2>&1 | FIND.EXE "2.37" >NUL && (SET EGather2Available=)
IF NOT "%EGather2Available%"=="" GOTO End

:: Run the test and display the result.
:: Remove "-probes IDE_DEVICE_INFORMATION SCSI_DEVICES" if
:: you want a full system summary instead of harddisks only.
:: Or run EGATHER2 -listprobes to list other available tests.
FOR /F "tokens=5*" %%A IN ('EGATHER2.EXE -batch -html -probes IDE_DEVICE_INFORMATION SCSI_DEVICES 2^>^&1 ^| FIND.EXE "Close HTML Output File"') DO START "HTML" "%%~B"
GOTO End


:Syntax
ECHO.
ECHO SNDisk3.bat,  Version 1.10 for Windows 2000 / XP / Server 2003
ECHO Display harddisk characteristics using IBM's EGather2 Version 2.37
ECHO.
ECHO Usage:  SNDISK3
ECHO.
ECHO Notes:  A HTML file will be stored in the current directory.
ECHO         IBM's EGather2 plus security patch can be downloaded at:
ECHO         http://www.pc.ibm.com/qtechinfo/MIGR-4R5VKC.html and
ECHO         http://www.ibm.com/pc/support/site.wss/document.do?lndocid=MIGR-54588
ECHO         This batch file will automatically prompt you for
ECHO         download if EGather2 is not available on your system.
ECHO         Read the comments if you want to modify this batch file
ECHO         to run a full inventory instead of just harddisks.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com


:End
IF "%OS%"=="Windows_NT" ENDLOCAL
