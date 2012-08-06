# Namenskonventionen

- Konstanten und Klassenkonstanten werden in `UPPER_CASE_WITH_UNDERSCORES` deklariert.
- Methodennamen und Funktionen werden in `lower_case_with_underscores()` deklariert.
- Klassennamen werden in `Upper_Snake_Case` deklariert.
- Variablennamen werden in `$lower_case_with_underscores` deklariert.
- PHP [Schlüsselworte](http://php.net/manual/de/reserved.keywords.php) sind klein zu schreiben.
- Booleans `TRUE`, `FALSE` und der Spezialwert `NULL` sind groß zu schreiben.

> Wirklich? `var_dump((bool) 1);` gibt `bool(true)` aus. Ist letztlich aber eine Frage des Geschmacks.

> Dateinamen, insbesondere bei Klassen `class-upper_snake_case.php` und bei Funktionen ohne Klasse, gern mit Namespace `lower_case_with_underscores.php`