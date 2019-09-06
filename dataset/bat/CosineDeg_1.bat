:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "cosinedeg angle" returns the cosine for the specified angle in degrees
@PHP -r print(cos(deg2rad(%~1)));
