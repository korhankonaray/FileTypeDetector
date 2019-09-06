:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "sinedeg angle" returns the sine for the specified angle in degrees
@PHP -r print(sin(deg2rad(%~1)));
