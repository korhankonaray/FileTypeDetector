@ECHO OFF
SETLOCAL ENABLEEXTENSIONS
SETLOCAL ENABLEDELAYEDEXPANSION

SET _FIRST=%1
SET _SECOND=%2
CALL :ADD _FIRST _SECOND _ANSWER
ECHO !_ANSWER!

ENDLOCAL
ENDLOCAL
GOTO :END


:ADD
   ::ADD NUMBERS LARGER THAN 32-BITS
   ::SYNTAX: CALL ADD _VAR1 _VAR2 _VAR3
   ::VER 1.2
   ::hieyeque1@gmail.com - drop me a note telling me
   ::if this has helped you.  Sometimes I don't know if anyone uses my stuff
   ::Its free for the world to use.
   ::I retain the rights to it though, you may not copyright this
   ::to prevent others from using it, you may however copyright works
   ::as a whole that use this code.
   ::Just don't try to stop others from using this through some legal means.
   ::CopyRight Brian Williams 8/29/2009
   :: _VAR1 = VARIABLE FIRST NUMBER TO ADD
   :: _VAR2 = VARIABLE SECOND NUMBER TO ADD
   :: _VAR3 = VARIABLE NUMBER RETURNED
   SET _RESULT=
   SETLOCAL
   SET _NUM1=!%1!
   SET _NUM2=!%2!
   IF NOT DEFINED _NUM1 SET _NUM1=0
   IF NOT DEFINED _NUM2 SET _NUM2=0
   FOR /L %%A IN (1,1,2) DO (
      FOR /L %%B IN (0,1,9) DO (
         SET _NUM%%A=!_NUM%%A:%%B=%%B !
         )
      )
   FOR %%A IN (%_NUM1%) DO SET /A _NUM1CNT+=1 & SET _!_NUM1CNT!_NUM1=%%A
   FOR %%A IN (%_NUM2%) DO SET /A _NUM2CNT+=1 & SET _!_NUM2CNT!_NUM2=%%A
   SET _NUM1=%_NUM1: =%
   SET _NUM2=%_NUM2: =%
   SET /A _DIGITS=%_NUM1CNT% + %_NUM2CNT%
   IF %_DIGITS% LEQ 8 (
      SET /A _RESULT=%_NUM1% + %_NUM2%
      )
   IF DEFINED _RESULT (ENDLOCAL & SET %3=%_RESULT%& GOTO :EOF)
   IF %_NUM1CNT% GEQ %_NUM2CNT% (SET _MAXOPS=%_NUM1CNT%) ELSE (SET _MAXOPS=%_NUM2CNT%)
   SET /A _MAXOPS=%_MAXOPS% - 1
   IF %_NUM1CNT% GTR %_NUM2CNT% (
      SET /A _ZEROS=%_NUM1CNT% - %_NUM2CNT%
      FOR /L %%A IN (1,1,!_ZEROS!) DO SET _ZERO=!_ZERO!0
      SET _NUM2=!_ZERO!!_NUM2!
      )

   IF %_NUM2CNT% GTR %_NUM1CNT% (
      SET /A _ZEROS=%_NUM2CNT% - %_NUM1CNT%
      FOR /L %%A IN (1,1,!_ZEROS!) DO SET _ZERO=!_ZERO!0
      SET _NUM1=!_ZERO!!_NUM1!
      )

   FOR /L %%A IN (!_MAXOPS!,-1,0) DO (
      SET /A _TMP=!_NUM1:~%%A,1! + !_NUM2:~%%A,1! !_PLUS! !_CO!
      SET _CO=
      SET _PLUS=
      IF !_TMP! GTR 9 SET _CO=!_TMP:~0,1!& SET _TMP=!_TMP:~-1!& SET _PLUS=+
      SET _RETURN=!_TMP!!_RETURN!
      SET _TMP=
      )
   IF DEFINED _CO SET _RETURN=%_CO%%_RETURN%
   SET _RESULT=%_RETURN%
   IF DEFINED _RESULT (ENDLOCAL&SET %3=%_RESULT%)
   GOTO :EOF

:END
