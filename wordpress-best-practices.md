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

## PHP 5.3 Plugin Vorlage

Wenn ein Plugin für PHP 5.3 entwickelt wird, sollte die Plugindatei wie im Beispiel aussehen. Das sorgt dafür, dass Nutzer mit einer zu alten PHP Version beim Aktivieren des Plugins eine ordentliche Fehlermeldung angezeigt bekommen anstatt z.B. eines Syntaxfehlers.

```php
<?php
/*
Plugin Name: 
Plugin URI: 
Description: 
Version: 
Author: 
Author URI: 
License: 
*/

$correct_php_version = version_compare( phpversion(), "5.3", ">=" );

if ( ! $correct_php_version ) {
	echo "This Plugin requires <strong>PHP 5.3</strong> or higher.<br>";
	echo "You are running PHP " . phpversion();
	exit;
}

require_once 'plugin.php';
?>
```