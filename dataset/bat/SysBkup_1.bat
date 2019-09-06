@ECHO OFF
:: This batch file will run and verify an unattended SystemState Backup.
:: The backup file name will be this batch file's name, followed by an
:: underscore, then the computername, and finally the ".bkf" extension.
:: The backup file will be saved in the directory where this batch file
:: is located.
:: Witten by Rob van der Woude
:: http://www.robvanderwoude.com

START /WAIT NTBACKUP Backup SystemState /J "%~n0 %ComputerName%" /F "%~dpn0_%ComputerName%.bkf" /V:yes /R:no /L:s
