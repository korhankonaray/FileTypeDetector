@ECHO OFF
REM Written by Willi Huber
REM w.huber@sonplas.de

REM  ----------------------------------------
REM  6. Windows XP FireWall: open Port 3306 for MySQL-database.

REM  skip Windows 2000
ver | find /I "Windows XP" > nul
if ERRORLEVEL 1 Goto Terminate

REM  ...in Windows XP SP1 firewall does not exist.
netsh.exe help | find /I "firewall" > nul
if errorlevel 1 Goto Terminate

REM  try to open the port
netsh.exe firewall add portopening protocol=TCP port=3306 name=MySQL > nul
if errorlevel 1 Goto Step6Error
ECHO Step 6 Windows XP FireWall: Port 3306 for MySQL-database opened.
Goto Terminate

REM  ErrorHandling
:Step6Error
ECHO Step 6 Windows XP FireWall: Error while opening Port 3306 for MySQL-database !
Goto Terminate

:Terminate
REM  ----------------------------------------
