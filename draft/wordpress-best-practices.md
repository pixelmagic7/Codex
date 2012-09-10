# WordPress spezifische Best Practices

Alle Hinweise in diesem Dokument gelten als Empfehlungen. Nichts ist verpflichtend, jedoch wird die Beachtung empfohlen.

## Allgemeines

- Statt `get_bloginfo()` sind die jeweiligen Wrapperfunktionen zu bevorzugen. Zum Beispiel `home_url()` statt `get_bloginfo( 'url' )`. Siehe http://codex.wordpress.org/Function_Reference/get_bloginfo#Parameters

## Vermeidung globaler Variablen

Wenn möglich, sollte auf die Verwendung globaler Variablen verzichtet werden. Das ist nicht immer möglich. Einige Tips folgen.

```php
<?php
global $post;
$post_id = $post->ID;

// besser:
$post_id = get_the_ID();
?>
```

## Plugin Dateistruktur

```
example-plugin
├── css
│   ├── admin.css
│   ├── admin.dev.css
│   ├── frontend.css
│   └── frontend.dev.css
├── example-plugin.php
├── images
│   └── inpsyde_logo.png
├── inc
│   └── features
├── js
│   ├── admin.dev.js
│   ├── admin.js
│   ├── frontend.dev.js
│   └── frontend.js
├── languages
└── lib
```

### `inc/` Ordner

Der `inc/` Ordner enthält den gesamten für das Plugin geschriebenen Code. Der Basis-Namespace ist `\Inpsyde\<Plugin Name>\`. Es können beliebige Subnamespaces angelegt werden. Jeder Subnamespace wird durch einen Ordner im Dateisystem repräsentiert.

### `inc/features/` Ordner

Der `features/` Ordner enthält Dateien, welche Features für die Pro-Version des Plugins bereitstellen. `features/` enthält nur Dateien, keine Ordner. Jeder dieser Dateien hat den Namespace `\Inpsyde\<Plugin Name>\Features`. Die Dateien dürfen Abhängigkeiten zu Methoden und Klassen aus `inc/` und `lib/` haben, aber nicht untereinander.

### `lib/` Ordner

Der `lib/` Ordner kann PHP Code aus externen Bibliotheken enthalten.

### .dev Assets

CSS und JavaScript Dateien werden als `<filename>.dev.<extension>` entwickelt. Darin sind Kommentare erlaubt und erwünscht.

Produktiv ausgeliefert wird eine von Kommentaren befreite und minifizierte `<filename>.<extension>`.

- http://jscompress.com/ (JS)
- http://refresh-sf.com/yui/ (JS & CSS)

## Keine `class_exists` Checks zur Kollisionsvermeidung

In PHP 5.2 Plugins ist es üblich, alle Klassen in ein `class_exists` zu wrappen. Das ist mit Namespaces nicht mehr notwendig, weshalb darauf verzichtet werden kann.

```
<?php
// PHP 5.2
if ( ! class_exists( 'Class_Name' ) ) {
    class Class_Name {
        // ...      
    }
}

// PHP 5.3 with namespaces
class Class_Name {
    // ...      
}
?>
```

## PHP 5.3 Plugin Vorlage

Wenn ein Plugin für PHP 5.3 entwickelt wird, sollte die Plugindatei wie im Beispiel aussehen. Das sorgt dafür, dass Nutzer mit einer zu alten PHP Version beim Aktivieren des Plugins eine ordentliche Fehlermeldung angezeigt bekommen anstatt z.B. eines Syntaxfehlers.

```php
<?php
/**
 * Plugin Name: Foo
 * Plugin URI:  http://marketpress.com/example-plugin/
 * Text Domain: foo
 * Domain Path: /languages
 * Description: A small description
 * Version:     0.0.1
 * Author:      Max Mustermann
 * Author URI:  http://inpsyde.com/
 * License:     GPLv3
 */

$correct_php_version = version_compare( phpversion(), '5.3', '>=' );

if ( ! $correct_php_version ) {
	echo "This Plugin requires <strong>PHP 5.3</strong> or higher.<br>";
	echo "You are running PHP " . phpversion();
	exit;
}

require_once 'plugin.php';

```