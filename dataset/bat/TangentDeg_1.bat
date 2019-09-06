:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "tangentdeg angle" returns the tangent for the specified angle in degrees
@PHP -r print(tan(deg2rad(%~1)));
