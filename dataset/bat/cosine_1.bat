@ECHO OFF
:: A not-too-serious attempt to calculate cosines using native batch
:: commands only by Rob van der Woude, http://www.robvanderwoude.com

:: Usage:  COSINE.BAT  angle

:: Angle must be specified in radians

:: Accuracy deteriorates fast with larger angles

:: cos(x) = 1 - x2/2! + x4/4! - x6/g! + x8/8! - ...
:: cos(x) = 1 - x2/2! + (x2/2!)*x2/(3*4) - (x4/4!)*x2/(5*6) + (x6/6!)*x2/(7*8) - ...
:: 100 * cos(x) = 100 - (100)*((100x)2/(100)2)/2! + (100*((100x)2/(100)2)/2!)*(100x)2/(3*4*(100)2) - ...


SETLOCAL ENABLEDELAYEDEXPANSION

:: pi/4 = 0,78539816339744830961566084581988
SET X=0.78539816339744830961566084581988
IF NOT "%~1"=="" SET X=%~1

:: The following sector converts the floating point value to
:: an integer of 10000 times its value (correctly rounded);
:: a lot of work to compensate for the lack of floating point
:: math in batch

:: Accuracy specifies how many digits will be used
SET Accuracy=3
SET Factor0=1
FOR /L %%A IN (1,1,%Accuracy%) DO SET /A Factor0 *= 10

ECHO.%x% | FIND "." >NUL
IF ERRORLEVEL 1 (
	SET /A  NewX = !X:~0,%Accuracy%! * %Factor0%
) ELSE (
	SET DotPos=
	SET /A NewDotPos = 10 + %Accuracy% + 1
	SET X=%X%000000000000
	FOR /L %%A IN (0,1,10) DO (
		IF NOT DEFINED DotPos (
			IF "!X:~%%A,1!"=="." (
				SET DotPos=%%A
			)
		)
	)
	SET /A NewDotPos = !DotPos! + %Accuracy% + 2
)
IF DEFINED NewDotPos (
	SET NewX=!X:~0,%NewDotPos%!
	SET NewX=!NewX:.=!
	SET /A NewX = "( 1!NewX! + 5 - ( 100 * %Factor0% ) ) / 10"
)

SET Cosine=%Factor0%
SET PrevFactor=%Factor0%
SET Sign=1
SET /A NewX2 = %NewX% * %NewX%

FOR /L %%A IN (2,2,12) DO (
	SET /A Sign *= -1
	IF !PrevFactor! LEQ 0 (
		SET PrevFactor=0
		SET Factor%%A=
	) ELSE (
		SET /A Factor%%A = "( !PrevFactor! * !NewX2! / %Factor0% ) / ( ( %%A - 1 ) * %%A * %Factor0% )"
		IF !Factor%%A! LEQ 0 (
			SET PrevFactor=0
			SET Factor%%A=
		) ELSE (
			SET /A Cosine = "!Cosine! + !Sign! * !Factor%%A!"
			SET PrevFactor=!Factor%%A!
		)
	)
)

IF %Cosine% LSS %Factor0% (
	SET Cosine=0000%Cosine%
	SET Cosine=0.!Cosine:~-%Accuracy%!
) ELSE (
	SET Cosine=1
)

ECHO cos^(%~1^)=%Cosine%

ENDLOCAL
