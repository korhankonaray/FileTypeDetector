@ECHO OFF
SET Time.Marker=%Time%
FOR /F "tokens=1-4 delims=.,:-" %%A IN ("%Time.Marker%") DO (
	SET Time.Marker.Hours=%%A
	SET Time.Marker.Minutes=%%B
	SET Time.Marker.Seconds=%%C
	SET Time.Marker.Hundredths=%%D
)
IF 1%Time.Marker.Hours% LSS 20 SET Time.Marker.Hours=0%Time.Marker.Hours%
SET Time.Marker
