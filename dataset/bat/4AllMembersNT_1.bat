@ECHO OFF
VER | FIND "Windows NT" >NUL
IF ERRORLEVEL 1 GOTO Syntax

:: Parameter check
IF [%2]==[] GOTO Syntax
NET GROUP %1 /DOMAIN >NUL 2>NUL
IF ERRORLEVEL 1 GOTO Syntax

:: Main command
FOR /F "skip=8 tokens=*" %%A IN ('NET GROUP %1 /DOMAIN ^| FIND /V "The command"') DO FOR %%? IN (%%A) DO CALL :Command %%? %*
GOTO End


:Command
SETLOCAL
SET user$=%1
SHIFT
:Loop
SHIFT
IF [%1]==[] GOTO Continue
IF %1==#   SET command$=%command$% %user$%
IF %1=="#" SET command$=%command$% %user$%
IF NOT %1=="#" IF NOT %1==# SET command$=%command$% %1
GOTO Loop
:Continue
IF "%command$%"==" " GOTO Syntax
CALL %command$%
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO 4AllMembers,  Version 1.10 for Windows NT
ECHO Written by Rob van der Woude
ECHO Execute a command once for each member of a global group
ECHO.
ECHO Usage:  4AllMembers  ^<global_group^>  ^<command^>  [ ^<parameters^> ]
ECHO.
ECHO Command will be executed once for each member of global_group
ECHO Command line parameter(s) "#" will be substituted by user ID

:End
