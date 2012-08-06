# Code Style Richtlinien

Diese Sektion benennt allgemeine PHP Code Style Richtlinien. Sofern nicht anders benannt, gelten die Regeln als Pflicht und sind einzuhalten.

## Dateikonventionen

- Dateien beginnen mit `<?php`. Kurze Tags sind nie erlaubt.
- Dateien enden nie mit dem schließenden Tag, um versehentliche Leerzeichen zu verhindern.
- Dateien werden in UTF-8 enkodiert.
- Code wird mit 4 Leerzeichen eingerückt. Tabs sind nicht erlaubt.
- Es gibt kein erzwungenes Limit in der Zeilenlänge. Es soll jedoch angestrebt werden, 80 bzw. 120 Zeichen einzuhalten.

## Allgemeines

- Es ist nur genau eine Anweisung pro Zeile gestattet.

## Kontrollstrukturen

### if, then, else

### while

### for

### switch

## Klammersetzung

- Öffnende Klammern für Klassen, Methoden und Kontrollstrukturen stehen auf der selben Zeile wie der jeweilige Kopf.
- Schließende Klammern für Klassen, Methoden und Kontrollstrukturen stehen auf einer separaten Zeile.
- Nach einem Schlüsselwort folgt ein Leerzeichen. Nach den Namen von Fuktionen und Methoden steht nie ein Leerzeichen.

```php
<?php
// korrekt
function foo() {
    if ( true ) {
        bar();
    }
}

// falsch
function foo()
{
    if( true ) {
        bar ();
    }
}
?>
```

## Klassen, Properties und Methoden

### Deklaration

- Sichtbarkeit muss für alle Properties und Methoden explizit deklariert sein.
- Das Schlüsselwort `var` wird nicht verwendet.
- Property- und Methodennamen beginnen nicht mit einem Underscore.
- Dem Methodennamen folgt kein Leerzeichen.
- Es dürfen Methoden nur dann statisch aufgerufen werden, wenn diese auch explizit mit `static` als solche deklariert wurden.

### Aufruf

Zwischen dem Namen der Methode oder Funktion und der öffnenden Klammer darf kein Leerzeichen sein. In der Argumentliste folgt jedem Komma ein Leerzeichen. Vor einem Komma ist kein Leerzeichen.

> Ich überlege, die Leerzeichen nach öffnenden und vor schließenden runden Klammern generell optional zu gestalten.
> Ich glaube, im Moment sind sie Pflicht. Jedoch widerspricht das jeder PHP Richtlinie außerhalb des WordPressversums. Selbst der WordPress Core hält sich oft genug nicht daran ...

```php
<?php
bar();
$foo->bar($arg1);
Foo::bar($arg2, $arg3);
?>
```

Argumentlisten kônnen zur Verbesserung der Lesbarkeit auf mehrere Zeilen aufgeteilt werden. Dann werden alle Elemente um eine Ebene eingerückt, das erste Argument steht auf einer eigenen Zeile und es befindet sich genau ein Argument auf jeder Zeile. Auch die schließende Klammer befindet sich auf einer neuen Zeile.

```php
<?php
$foo->bar(
    $longArgument,
    $longerArgument,
    $muchLongerArgument
);
?>
```


