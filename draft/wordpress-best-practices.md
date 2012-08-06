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
├── js
│   ├── admin.js
│   ├── admin.dev.js
│   ├── frontend.js
│   └── frontend.dev.js
├── languages
├── lib
└── inc
```

:question: Wie ist `lib` strukturiert, so dass Klassen Autoloading bei Namespaces am besten funktioniert?

:question: `lib` hat nur Fremdlibs inne, `inc` unsere eigenen Sachen bzw. erstelltes

:question: `.dev` nutze ich für die Erstellung der lesbarren Variante in js und css; ohne `.dev` ist minifiziert, ohne Kommentate, console.log() oder auch Sass etc.

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