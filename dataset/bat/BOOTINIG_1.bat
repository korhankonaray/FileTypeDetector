@ECHO OFF
:: Use this batch file to edit NT 4's BOOT.INI values in GUI mode
:: Written by Rob van der Woude
:: http://www.robvanderwoude.com
::
:: Disclaimer: Changing BOOT.INI may cause system failures!
::             Use this batch file entirely at your own risk.
::             Do not change any values unless you understand the
::             consequences.
::             Always make a full backup before changing any system settings.

START "Boot.ini" RUNDLL32 SHELL32,Control_RunDLL "sysdm.cpl",,3
GOTO:EOF
