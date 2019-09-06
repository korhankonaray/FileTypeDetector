@ECHO OFF
:: Check Windows version
IF "%OS%"=="Windows_NT" (SETLOCAL) ELSE (GOTO Syntax)
VER | FIND "Windows NT" >NUL && GOTO Syntax

:: Check command line argument - none required
IF NOT "%~1"=="" GOTO Syntax

:: Warning message and confirmation
CLS
ECHO.
ECHO Warning: You are about to make changes to the Windows registry.
ECHO          Changing the registry is not without risk!
ECHO          Continuing could lead to loss of data, and even a "dead" PC.
ECHO          The author cannot be held responsible for any damage, neither
ECHO          direct nor consequential, caused by using this script.
ECHO          Use this script entirely at your own risk.
ECHO.
ECHO          Type YES and press Enter if you understand the risk and
ECHO          accept full responsibility...
SET /P Answer=
IF /I NOT "%Answer%"=="YES" (
	ECHO Aborted by user...
	GOTO End
)

:: Create temporary .REG file
SET RegFile="%Temp:"=%.\RegDLL.dat"
>  %RegFile% ECHO REGEDIT4
>> %RegFile% ECHO.
>> %RegFile% ECHO [HKEY_CLASSES_ROOT\dllfile\shell]
>> %RegFile% ECHO.
>> %RegFile% ECHO [HKEY_CLASSES_ROOT\dllfile\shell\Register DLL]
>> %RegFile% ECHO.
>> %RegFile% ECHO [HKEY_CLASSES_ROOT\dllfile\shell\Register DLL\command]
>> %RegFile% ECHO @="\"regsvr32.exe\" %%1"
>> %RegFile% ECHO.
>> %RegFile% ECHO [HKEY_CLASSES_ROOT\dllfile\shell\Unregister DLL]
>> %RegFile% ECHO.
>> %RegFile% ECHO [HKEY_CLASSES_ROOT\dllfile\shell\Unregister DLL\command]
>> %RegFile% ECHO.@="\"regsvr32.exe\" /u %%1"
>> %RegFile% ECHO.

:: Export current registry settings to undo file
ECHO.
ECHO Creating Undo and Restore files...
START /WAIT REGEDIT /E RegDLL_Restore.reg "HKEY_CLASSES_ROOT\dllfile"
>  RegDLL_Remove.reg ECHO REGEDIT4
>> RegDLL_Remove.reg ECHO.
>> RegDLL_Remove.reg ECHO [-HKEY_CLASSES_ROOT\dllfile\shell]
>> RegDLL_Remove.reg ECHO.

:: Import registry settings from temporary .REG file
ECHO.
ECHO Modifying registry settings for DLL files...
START /WAIT REGEDIT /S %RegFile%

:: Remove temporary .REG file
DEL %RegFile%

:: Exit message
ECHO.
ECHO You can now register and unregister DLL files in Explorer.
ECHO Right-clicking a DLL file will show 2 new menu entries:
ECHO     Register DLL
ECHO     Unregister DLL
ECHO.
ECHO To uninstall this option, doubleclick ^(and confirm^)
ECHO RegDLL_Remove.reg first, followed by RegDLL_Restore.reg.
ECHO Both are stored in the current directory.
GOTO End

:Syntax
ECHO.
ECHO RegDLL.bat,  Version 1.01 for Windows 2000 / XP
ECHO Register and unregister DLL files in Explorer
ECHO.
ECHO Based on an article on The Code Project's website
ECHO http://www.codeproject.com/w2k/regdllxp.asp
ECHO.
ECHO Usage:  REGDLL
ECHO.
ECHO After running this script, right-clicking a DLL file will show 2
ECHO new menu entries:   Register DLL
ECHO                     Unregister DLL
ECHO.
ECHO To uninstall this option, doubleclick (and confirm)
ECHO RegDLL_Remove.reg first, followed by RegDLL_Restore.reg.
ECHO Both are created in the current directory when running this script.
ECHO.
ECHO Note:   Unless you are a power user or administrator, restrictions
ECHO         on your computer may prevent you from modifying the registry.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
IF "%OS%"=="Windows_NT" ENDLOCAL
