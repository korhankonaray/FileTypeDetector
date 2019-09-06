@ECHO OFF
FOR /F "tokens=*" %%A IN ('TIME/T') DO SET Now=%%A
ECHO It's %Now% now
