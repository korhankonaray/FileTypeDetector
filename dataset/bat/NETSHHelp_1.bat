@ECHO OFF
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
IF NOT  "%~1"==""           GOTO Syntax

SETLOCAL ENABLEDELAYEDEXPANSION
FOR /F "tokens=5" %%A IN ('FILEVER %windir%\system32\netsh.exe') DO SET NETSHVer=%%A
ECHO NETSH, Version %NETSHVer%
ECHO.
NETSH /?
FOR /F "tokens=7 delims=' " %%A IN ('NETSH /? ^| FINDSTR /R /C:"netsh .* context."') DO (
	CALL :UpCase %%A
	ECHO.
	ECHO The following commands are available in the NETSH !context! context:
	ECHO.
	NETSH %%A /? | MORE +4 | FINDSTR /R /B /C:"[\?a-z][a-z ]*-"
)
ENDLOCAL
GOTO:EOF


:UpCase
SET context=%1
SET context=%context:a=A%
SET context=%context:b=B%
SET context=%context:c=C%
SET context=%context:d=D%
SET context=%context:e=E%
SET context=%context:f=F%
SET context=%context:g=G%
SET context=%context:h=H%
SET context=%context:i=I%
SET context=%context:j=J%
SET context=%context:k=K%
SET context=%context:l=L%
SET context=%context:m=M%
SET context=%context:n=N%
SET context=%context:o=O%
SET context=%context:p=P%
SET context=%context:q=Q%
SET context=%context:r=R%
SET context=%context:s=S%
SET context=%context:t=T%
SET context=%context:u=U%
SET context=%context:v=V%
SET context=%context:w=W%
SET context=%context:x=X%
SET context=%context:y=Y%
SET context=%context:z=Z%
GOTO:EOF


:Syntax
ECHO.
ECHO NETSHHelp.bat,  Version 1.00
ECHO Display help for NETSH and all its subcontexts
ECHO.
ECHO Usage:  NETSHHELP
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" EXIT /B 1
