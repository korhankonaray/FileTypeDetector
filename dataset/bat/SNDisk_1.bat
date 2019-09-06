@ECHO OFF
:: SNDisk.bat,  Version 2.10 for Windows 2000
:: Display harddisk characteristics using IBM's E-Gatherer tool.
::
:: IBM's E-Gatherer is used to gather and encode system information.
:: This batch file copies E-Gatherer's unencoded temporary file to a log
:: file which is then used to display some harddisk characteristics.
:: E-Gatherer can be downloaded here:
:: http://www.pc.ibm.com/qtechinfo/MIGR-4R5VKC.html
::
:: This batch file uses PSLIST.EXE from SysInternals' PSTools.
:: The PSTools can be downloaded here:
:: http://www.sysinternals.com/ntw2k/freeware/pstools.shtml
::
:: Written by Rob van der Woude
:: http://www.robvanderwoude.com

:: Initialize variable "not ready"
SET SNDISK=0

:: Go to this batch file's directory
CD /D "%~dp0"

:: Start gathering system information
TITLE Gathering info, please wait...
START /MIN CMD /C (ECHO Y^|GATHERER.EXE)

:Loop
:: Quit loop when ready
IF %SNDISK%==1 IF NOT EXIST *.TMP GOTO Done
PSLIST gatherer >NUL 2>&1
IF ERRORLEVEL 1 GOTO :Done
:: As long as the temporary file exists -- is being built -- copy
:: its contents to our own temporary log file; variable SNDISK is
:: set to 1 to signal being ready as soon as the temporary file is
:: deleted by GATHERER.
IF EXIST *.TMP (
	SET SNDISK=1
	TYPE *.TMP > SNDISK.LOG
)
:: Wait 0.2 second
IF %SNDISK%==1 PING 1.1.1.1 -n 2 -w 100 >NUL
:: Start loop procedure again
GOTO Loop

:Done
TITLE Processing info...

:: Delete the encoded and temporary files
IF EXIST *.GTH   DEL *.GTH   >NUL
IF EXIST *.TMP   DEL *.TMP   >NUL
IF EXIST SYS.GEL DEL SYS.GEL >NUL

:: Gather disk characteristics from the log file
FOR /F "tokens=1,7,8 delims=|" %%A IN ('TYPE SNDISK.LOG ^| FIND "DiskPeripheral"') DO (
	SET DiskType=%%A
	SET DiskSN=%%B
	SET DiskCap=%%C
)

:: Strip whitespace
SET DiskType=%DiskType:  =%
SET DiskSN=%DiskSN:  =%
SET DiskCap=%DiskCap:  =%

:: Strip leading space
SET DiskType=%DiskType:~1%
SET DiskSN=%DiskSN:~1%
SET DiskCap=%DiskCap:~1%

:: Display results
TITLE %~n0
ECHO.
ECHO Harddisk type     :  %DiskType%
ECHO Harddisk S/N      :  %DiskSN%
ECHO Harddisk capacity :  %DiskCap%
ECHO.
