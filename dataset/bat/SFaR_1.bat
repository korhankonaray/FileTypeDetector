:: http://www.robvanderwoude.com/batchphp.php
:: Usage:   SFAR.BAT  search  replace  subject
:: Example: SFAR.BAT  pin  needle "like searching a pin in a haystack"
@IF NOT "%~3"=="" PHP.EXE -r "print(str_replace(\"%~1\",\"%~2\",\"%~3\"));"
