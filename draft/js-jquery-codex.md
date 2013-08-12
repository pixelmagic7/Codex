# Inpsyde JS/jQuery Codex

Dieses Dokument soll bei Entwicklung mit JavaScript in Verbindung mit jQuery helfen. Dabei wird auf Strukturen und Code-Style eingegangen.

## Inhalt

* Allgemeine Verwendung
* Einbindung
* Lokalisierung
* Dateien und Ordner
* Code-Styling
* Beispiele

## Allgemeine Verwendung

WordPress selbst liefert schon eine Reihe von jQuery Scripten aus, sodass ein Großteil einfach implementiert werden kann. Es ist zu empfehlen auch diese Versionen zu verwenden, da es sonst zu Konflikten kommen kann.

# Einbindung

Die Scripte müssen immer über die entsprechenden Hooks geladen werden und vorher am System registriert werden. Dabei sollen diese in minifizierter Form ausgeliefert werden. Zusätzlich muss auf das Protokoll geachtet werden:

```php
// Frontend
$hook = 'wp_enqueue_scripts';
// Backend
$hook = 'admin_enqueue_scripts';
// Login
$hook = 'login_enqueue_scripts';

// Fire filter
add_filter( $hook, function() {
	
	// Check protocol
	$protocol = is_ssl() ? 'https' : 'http';
	
	// Check suffix
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	
	// Set script url
	$script_url = plugin_dir_url( __FILE__ ) . '../js/script' . $suffix . '.js';
	$script_url = str_replace( 'http', $protocol, $script_url );
	
	// register script
	wp_register_script(
		'myscript-key',			# slug
		$script_url,			# script url
		array( 'jquery' ),		# depencies
		'',						# script version usually empty
		TRUE					# show in footer (recommended)
	);

	// enqueue script
	wp_enqueue_script( 'myscript-key' );
} );
```

## Lokalisierung

Auch Ausgaben innerhalb von Javascript müssen Strings übersetzbar sein:

```php
// Fire filter
add_filter( $hook, function() {

	// [...] Plugin loading stuff
	
	// enqueue script
	wp_enqueue_script( 'myscript-key' );

	// localization
	// msk = MyScript-Key
	wp_localize_script( 'myscript-key', 'msk_vars', array(
		'my_string_a'	=> __( 'My String A', TEXTDOMAIN ),
		'my_string_b'	=> __( 'My String B', TEXTDOMAIN ),
		'my_string_c'	=> __( 'My String C', TEXTDOMAIN ),
	) );
} );
```

## Dateien und Ordner
## Code-Styling
## Beispiele
