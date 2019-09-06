@echo off 
cls
:: ADMINGRP.BAT
::
:: Author - Kenneth C. Mazie
:: Kaiser Permanente National Server Operations - Walnut Creek, Ca
:: Date - 11-29-2000
:: Version - 3.0
::
:: This batch file is intended to remotely update the local administrators group on selected Windows NT
:: machines in a domain.  It can be altered to do othe things with a minimum of difficulty but it was 
:: written to update group membership.  The batch requires the USERTOGRP.EXE utility from the NT resource
:: kit.  Some variables must be set prior to the first run, this includes the domain, admin password, 
:: admin account name, group or user to add (user variable), and the group to add to.  

:: Process flow: The batch reads the domain and checks each entry against an exclusion file called 
:: "EXCLUDE.TXT".  The exclusion file is a flat text file that must reside in the same folder as this 
:: batch.  It conatins one entry per line and each entry should the name of a machine to bypass.  The 
:: last line in the exclusion file should be simply "The" since that is the last line outputed by the 
:: NET VIEW command. If the current machine is NOT one of the exclusion entries the group membership gets 
:: processed.  The process subroutine can be altered to perform anything you like on the remote PC like 
:: copy files or if SU is loaded other administrative operations can be done.  All actions are captured 
:: in a log file located in the same folder as this batch.  The one exception being off-line machines
:: which echo four error lines to the screen.   Note that the match variable preset should not be changed.

:: This batch is intended to be run on Windows NT.
::----------------------- batch code -----------------------

:variables
:: set all initial variables here
set user=domain desktop support
set group=Administrators
set password=
set domain=
set admin=administrator
set match=no   


:getdate
  FOR /F "TOKENS=1,2*" %%A IN ('DATE/T') DO SET TODAY=%%B
  SET TODAY=%TODAY:/=-%
  echo This run completed on %TODAY% >.\log.txt
  ::ren .\log.txt .\%TODAY%-log.txt

:getmachines
  FOR /F "skip=3 tokens=*" %%A IN ('NET VIEW /DOMAIN:%domain%') DO CALL :check %%A
  goto exit

:check
  set currentmachine=%1
  for /F %%i in (.\exclude.txt) do if %currentmachine%==%%i set match=yes
  if %match%==no call :process
  if %match%==yes call :bypass
  goto :EOF
  goto :EOF
  goto :exit 

:bypass 
  @echo Current system: %currentmachine% is on the exclude list, BYPASSING....... >>.\log.txt
  echo -===================================->>.\log.txt
  set match=no
  goto :EOF

:process
  @echo Current system: %currentmachine% is valid......Processing....... >>.\log.txt
  if exist .\temp.txt del /F /Q .\temp.txt
  echo domain: %currentmachine%>> .\temp.txt
  echo localgroup: %group%>> .\temp.txt
  echo %User%>> .\temp.txt

  echo %currentmachine%
  net use \\%currentmachine%\IPC$ /D 
  net use \\%currentmachine%\IPC$ /USER:%domain%\%admin% %password% >>.\log.txt

  Usrtogrp.exe .\temp.txt >>.\log.txt
  echo -===================================->>.\log.txt
  set match=no
  goto :EOF

:Exit
