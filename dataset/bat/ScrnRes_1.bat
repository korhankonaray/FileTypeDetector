@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Check command line arguments
IF "%~3"=="" GOTO Syntax
ECHO.%* | FIND.EXE "?" >NUL && GOTO Syntax
ECHO.%* | FIND.EXE "/" >NUL && GOTO Syntax
SET /A %2 >NUL 2>&1 || GOTO Syntax
SET /A %3 >NUL 2>&1 || GOTO Syntax

:: Check if remote PC is on-line, abort if not
PING %~1 2>NUL | FIND "TTL=" >NUL || ( ECHO Remote PC %1 is off-line& GOTO:EOF )

:: Change the resolution on the remote PC
PSEXEC -C -I -S \\%1 RESCHANGE.EXE -width=%2 -height=%3 -depth=16
GOTO:EOF

:Syntax
:: NT needs brackets to be "escaped" by an escape character
SET Esc=
IF "%OS%"=="Windows_NT" SET Esc=^^
:: Display script name only in help screen, without path or extension
SET Me=%~n0
:: Convert script name to upper case
SET Me=%Me:a=A%
SET Me=%Me:b=B%
SET Me=%Me:c=C%
SET Me=%Me:d=D%
SET Me=%Me:e=E%
SET Me=%Me:f=F%
SET Me=%Me:g=G%
SET Me=%Me:h=H%
SET Me=%Me:i=I%
SET Me=%Me:j=J%
SET Me=%Me:k=K%
SET Me=%Me:l=L%
SET Me=%Me:m=M%
SET Me=%Me:n=N%
SET Me=%Me:o=O%
SET Me=%Me:p=P%
SET Me=%Me:q=Q%
SET Me=%Me:r=R%
SET Me=%Me:s=S%
SET Me=%Me:t=T%
SET Me=%Me:u=U%
SET Me=%Me:v=V%
SET Me=%Me:w=W%
SET Me=%Me:x=X%
SET Me=%Me:y=Y%
SET Me=%Me:z=Z%
:: In Windows 9x, the previous code turns the variable into a mess,
:: so for Windows 9x we'll use the full %0 instead
IF NOT "%OS%"=="Windows_NT" SET Me=%0
ECHO.
ECHO ScrnRes.bat,  Version 1.02 for Windows NT 4 / 2000 / XP / Server 2003
ECHO Modify a remote PC's screen resolution
ECHO.
ECHO Usage:  %Me%   PC_name   H_res   V_res
ECHO.
ECHO Where:  PC_name = remote computer's host name
ECHO         H_res   = required horizontal resolution in pixels (640, 800, 1024)
ECHO         V_res   = required  vertical  resolution in pixels (480, 600,  768)
ECHO.
ECHO Notes:  1. Someone must be logged on to the remote computer while you are
ECHO            changing the resolution!
ECHO         2. This batch file requires PSEXEC from SysInternals' PSTools
ECHO            %Esc%(http://www.sysinternals.com/ntw2k/freeware/pstools.shtml%Esc%),
ECHO            12noon's Resolution Changer %Esc%(http://www.12noon.com/download.htm%Esc%)
ECHO            in the working directory, and administrator access on the remote PC.
ECHO         3. Resolution Changer will ignore unsupported H_res/V_res combinations.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
SET Escape=
SET Me=
