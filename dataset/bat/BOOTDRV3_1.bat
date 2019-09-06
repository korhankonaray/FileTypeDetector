@ECHO off
IF not "%1"=="?" IF not "%1"=="/?" GOTO start
ECHO.
ECHO  BOOTDRV with no arguments will display drive letter.
ECHO  BOOTDRV with any argument will set bootdrv variable
ECHO  to drive letter specified by %%comspec%% variable.
ECHO  Laurence Soucy
ECHO  http://bigfoot.com/~batfiles/
GOTO end

:start
IF "%comspec%"=="" ECHO  comspec variable not set
IF "%comspec%"=="" GOTO end
IF "%1"=="" GOTO display only
ECHO %comspec%|choice.com/c%comspec%/n set bootdrv=>%temp%.\bootdrv$.bat
FOR %%c in (CALL DEL) do %%c %temp%.\bootdrv$.bat
GOTO end

:display only
ECHO %comspec%|choice.com/c:%comspec%/n " "

:end
