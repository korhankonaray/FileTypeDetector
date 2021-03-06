@ECHO OFF
ECHO.
ECHO NoTrkIco.bat,  Version 1.00 for Windows (32-bit)
ECHO Disable "smart shortcuts" or "icon tracking" on the local PC
ECHO.
ECHO Icon tracking means shortcuts keep their original path in UNC format;
ECHO copying a shortcut file from one PC to another may lead to extremely
ECHO slow applications, because they are actually running on the computer
ECHO where the shortcut was created originally.
ECHO Individual shortcuts may be "restored" by using a utility called
ECHO "SCUT.EXE".
ECHO However, this batch file adds a registry setting that will cause
ECHO the computer to completely ignore the UNC path of ANY shortcut.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
ECHO Based on a tip by Sander Jousma
ECHO.
ECHO Press any key to disable icon tracking, or Ctrl+C to abort . . .
PAUSE >NUL

:: Create temporary .REG file
> "%Temp%.\_NoTrack.reg" ECHO REGEDIT4
>>"%Temp%.\_NoTrack.reg" ECHO.
>>"%Temp%.\_NoTrack.reg" ECHO [HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Policies\Explorer\LinkResolve]
>>"%Temp%.\_NoTrack.reg" ECHO "IgnoreLinkInfo"=dword:00000001
>>"%Temp%.\_NoTrack.reg" ECHO.

:: Add a dummy title for Windows NT 4 or 2000
SET Title=
IF "%OS%"=="Windows_NT" SET Title="Regedit"
:: Merge temporary .REG file
START /WAIT %Title% REGEDIT.EXE /S "%Temp%.\_NoTrack.reg"

:: Cleanup
DEL "%Temp%.\_NoTrack.reg"
SET Title=
