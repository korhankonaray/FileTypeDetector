@ECHO off
:: By Laurence Soucy
:: http://bigfoot.com/~batfiles/
::
:: To place drive letter into variable
ECHO %comspec%|choice.com/n/c%comspec% set bootdrv=>%temp%.\bootdrv$.bat
FOR %%c in (CALL DEL) do %%c %temp%.\bootdrv$.bat
ECHO "%bootdrv%"
