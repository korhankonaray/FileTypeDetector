@ECHO OFF
:: Country.bat, Version 3.01 for Windows NT 4
:: Displays several country related settings.
:: This version uses native NT 4 commands only.
:: Written by Rob van der Woude
:: http://www.robvanderwoude.com
:: Keyboard trick by Tom Lavedas
:: http://web.archive.org/web/20070222072741rn_1/members.cox.net/tglbatch/

:: Export International settings from registry to a temporary file
START /W REGEDIT /E %Temp%.\international.reg "HKEY_CURRENT_USER\Control Panel\International"
:: Read several lines from the temporary files
:: and store these settings as environment variables
FOR /F "tokens=1* delims==" %%A IN ('TYPE %Temp%.\international.reg ^| FIND "iCountry"') DO SET iCountry=%%B
SET iCountry=%iCountry:"=%
SET iCountry
FOR /F "tokens=1* delims==" %%A IN ('TYPE %Temp%.\international.reg ^| FIND "sCountry"') DO SET sCountry=%%B
SET sCountry=%sCountry:"=%
SET sCountry
FOR /F "tokens=1* delims==" %%A IN ('TYPE %Temp%.\international.reg ^| FIND "sLanguage"') DO SET sLanguage=%%B
SET sLanguage=%sLanguage:"=%
SET sLanguage
:: Remove temporary file
DEL %Temp%.\international.reg
:: The KEYB trick was posted to the alt.msdos.batch.nt newsgroup by Tom Lavedas
FOR /F "tokens=1* delims=:" %%A IN ('KEYB ^| FIND ":" ^| FIND /V "CON"') DO SET Keyboard=%%B
SET Keyboard=%Keyboard:~1%
SET Keyboard
:: Check code page used
FOR /F "tokens=1* delims=:" %%A IN ('CHCP') DO SET /A CodePage = %%B
SET CodePage
