@ECHO OFF
:: Check Windows version: batch file not suited for DOS
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Localize variables
SETLOCAL

:: Check Windows version again: batch file not suited for NT 4
VER | FIND.EXE /I "Windows NT" >NUL
IF NOT ERRORLEVEL 1 GOTO Syntax

:: No command line arguments required
IF NOT "%~1"=="" GOTO Syntax

:: Check availability and version of IBM's E-Gatherer tool
ECHO N^| EGATHER2.EXE 2>&1 | FIND.EXE "2.37" >NUL
IF ERRORLEVEL 1 GOTO Syntax

:: Check availability of SysInternals' PSList tool
PSLIST.EXE >NUL 2>&1
IF ERRORLEVEL 1 GOTO Syntax

:: Initialize variables
SET SNDisk=0
SET Counter=0

:: Start gathering system information
START /MIN /LOW "Gathering info..." CMD.EXE /C (ECHO Y^| EGATHER2.EXE)

:Loop
:: :: :: :: :: :: :: :: :: :: :: :: :: :: :: :: :: :: ::
::  Wait a quarter second.                            ::
::  Decrease the delay for really fast systems ! ! !  ::
::  This delay is far from accurate, so you may need  ::
::  to find other ways to generate a shorter delay.   ::
:: :: :: :: :: :: :: :: :: :: :: :: :: :: :: :: :: :: ::
PING 1.1.1.1 -n 1 -w 250 >NUL

:: Quit loop when ready
IF %SNDisk%==1 IF NOT EXIST *.TMP GOTO LoopDone
PSLIST.EXE egather2 >NUL 2>&1
IF ERRORLEVEL 1 GOTO LoopDone
:: As long as the temporary file exists -- is being built -- copy
:: its contents to our own set of temporary files; variable SNDisk
:: is set to 1 to signal being ready as soon as the temporary file
:: is deleted by EGATHER2.
IF EXIST egath*.tmp (
	SET SNDisk=1
	IF EXIST egath*.tmp FOR %%A IN (egath*.tmp) DO (COPY %%A %%~nA_%Counter%.xml >NUL 2>&1)
)
:: Increment counter and start loop procedure again
SET /A Counter += 1
GOTO Loop

:LoopDone
:: Select and save the largest temporary file, which
:: will ususally be the secondlast file created
FOR /F "tokens=*" %%A IN ('DIR /B /OS egath*.xml') DO SET ResultFile=%%~nxA
COPY %ResultFile% "%~dpn0.xml" >NUL 2>&1

:: Delete temporary files
FOR %%A IN (*.EG2 SYS.GEL EGATH*.XML) DO (
	IF EXIST "%%~A" DEL "%%~A"
) >NUL 2>&1

:: Display results
TYPE "%~dpn0.xml" | FIND.EXE "</GATHERED_DATA>" >NUL
IF ERRORLEVEL 1 (
	ECHO The XML file containing the results is truncated.
	ECHO Please make sure this system has as little as possible other processes
	ECHO running, then rerun this batch file to try again.
	ECHO If the problem persists, decrease this batch file's delay time (read the
	ECHO comments in the batch file to find out what to change) and try again.
) ELSE (
	START "XML" "%~dpn0.xml"
)
GOTO End

:Syntax
ECHO.
ECHO SNDisk2.bat,  Version 1.00 for Windows 2000 / XP / Server 2003
ECHO Display hardware characteristics using IBM's EGather2 tool
ECHO (this batch file has been tested with EGather2 version 2.37 only).
ECHO.
ECHO IBM's EGather2 2.37 is used to gather and encode system information.
ECHO This batch file copies EGather2's unencoded temporary file to an
ECHO XML file which is then used to display some harddisk characteristics.
ECHO.
ECHO EGather2 can be downloaded at:
ECHO http://www.pc.ibm.com/qtechinfo/MIGR-4R5VKC.html
ECHO.
ECHO This batch file uses PSList from SysInternals' PSTools.
ECHO The PSTools can be downloaded at:
ECHO http://www.sysinternals.com/ntw2k/freeware/pstools.shtml
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
IF "%OS%"=="Windows_NT" ENDLOCAL
