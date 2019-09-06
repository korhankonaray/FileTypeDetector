@ECHO OFF
:: Open Windows 2000's REGEDIT.EXE in the "classic"
:: view instead of at the last accessed key.
::
:: Uses REGEDIT.VBS from the Windows Scripting Guide
:: http://www.winguides.com/scripting/
::
:: Place both files in %WinDir%\System32, or
:: somewhere else in the PATH before REGEDIT.EXE.

CSCRIPT //NoLogo "%~dpn0.vbs"
