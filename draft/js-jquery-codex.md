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

## Einbindung

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

Wie in der aktuellen Strukturkonvention ist die Ordnerstruktur einfach und flach gehalten. jQuery-Erweiterungen müssen den Präfix jquery enthalten.

```
example-plugin | example-theme
├── js
│   ├── admin.min.js
│   ├── admin.js
│   ├── frontend.min.js
│   ├── frontend.js
│   ├── jquery.plugin.min.js
│   └── jquery.plugin.js
```

## Code-Styling

Diese Sektion benennt allgemeine JS Code Style Richtlinien. Sofern nicht anders benannt, gelten die Regeln als Pflicht und sind einzuhalten.

### Namenskonventionen

- Methodennamen und Funktionen werden in `lower_case_with_underscores()` deklariert.
- Klassennamen werden in `lower_case_with_underscores ` deklariert.
- Variablennamen werden in `lower_case_with_underscores ` deklariert.
- JavaScript [Schlüsselworte](http://www.quackit.com/javascript/javascript_reserved_words.cfm) sind klein zu schreiben.
- Booleans `true`, `false` und der Spezialwert `null` sind klein zu schreiben.

### Dateikonventionen

- Dateien werden in UTF-8 enkodiert.
- Es werden UNIX-Zeilenenden verwendet (`LF`)
- Code wird mit Tabs eingerückt.
- Es gibt kein erzwungenes Limit in der Zeilenlänge. Es soll jedoch angestrebt werden, 80 bzw. 120 Zeichen einzuhalten.

### Allgemeines

- Es ist nur genau eine Anweisung pro Zeile gestattet.
- Vor und nach folgenden Operatoren steht ein Leerzeichen: `!` `*` `/` `%` `+` `-` `.` `<<` `>>` `<` `<=` `>` `>=` `==` `!=` `===` `!==` `&` `^` `|` `&&` `||` `?` `:` `=` `+=` `-=` `*=` `/=` `.=` `%=` `&=` `|=` `^=` `<<=` `>>=` `and` `xor` `or` `,`
- In Vergleichsoperationen mit Konstanten ist die "intuitive" Reihenfolge zu verwenden, d.h. die Konstante steht rechts (`$i > 5`). "Yoda-Conditions" (`true == $the_force`) sind nicht erwünscht.

### Kontrollstrukturen

Im Kopf von Kontrollstrukturen finden keine Zuweisungen statt. Der JavaScript-Parser lässt dies auch nicht zu (Außer bei Schleifen).

```js
// richtig
var a = foo( b );
if ( a ) {
	// code
}
```

#### if, else, else if

Klammern sind Pflicht, außer bei einzelnen Anweisungen im Block. Beinhaltet mindestens ein Block mehr als eine Anweisung, müssen alle anderen Blöcke auch geklammert werden.

```js
// richtig
if ( c )
	return;

// richtig
if ( c ) {
	var foo = 3;
	return;
}

// falsch
if ( c ) return;

// richtig
if ( c ) {
	// code
} else {
	// code
}

// richtig
if ( c )
	return 'a';
else
	return 'b';

// falsch
if ( c )
	// code
else {
	// code
}

// falsch
if ( c ) {
	// code
} else
	// code
```

Der ternäre Operator `?:` ist erlaubt, darf aber nicht geschachtelt werden.

```js
// richtig
var a = ( 1 == 1 ) ? 'foo' : 'bar';

// falsch
var a = ( 1 == 1 ) ? ( ( 1 == 1 ) ? 42 : 23 ) : 'bar';
```

#### while

```js
while ( something_is_true ) {
	// code
}
```

#### for

##### Arrays
Die Reihenfolge bleibt erhalten.
Aus Performancegründen sollten die Schleifengrenzen vor der `for`-Schleife berechnet werden. 

```js
var i  = 0;
var length = foo.length;
for ( i; i < length; i++ ) { 
	// code
}
```

##### Objekte
Die Reihenfolge bleibt nicht erhalten.
Möchte man die geerbten Eigenschaften nicht berücksichtigen (Standardfall), nutzt man `hasOwnProperty`.

```js
for ( var foo in bar ) {
	if ( bar.hasOwnProperty( foo ) ) {
		// code
	}
}
```

#### foreach

Arbeiten wir jedoch mit jQuery können wir die [.each-Methode](http://api.jquery.com/jQuery.each/) nutzen.

```js 
var obj = {
	'flammable': 'inflammable',
	'duh': 'no duh'
};

$.each( obj, function( key, value ) {
  alert( key + ': ' + value );
} );
```

#### switch

Das bewusste Auslassen von `break` ist nicht erwünscht, da es Quelle schwer nachvollziehbarer Fehler sein kann.

```js
switch ( foo ) {
	case 'bar':
		// code
		break;
	default:
		// code
		break;
}
```

### Klammersetzung

- Öffnende Klammern für Klassen, Methoden und Kontrollstrukturen stehen auf der selben Zeile wie der jeweilige Kopf.
- Schließende Klammern für Klassen, Methoden und Kontrollstrukturen stehen auf einer separaten Zeile.
- Nach einem Schlüsselwort folgt ein Leerzeichen. Nach den Namen von Funktionen und Methoden steht nie ein Leerzeichen.

```js
// richtig
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
```

### Arrays und Objekte

Arrays und Objekte sollten durch die kurze Schreibweise definiert werden.

```js
// richtig
var foo = [ a, b, c ];

// falsch
var foo = new Array();
foo[ 0 ] = a;
foo[ 1 ] = b;
foo[ 2 ] = c;

// richtig
var bar = {
	a: 'foo',
	b: 'bar',
	c: 'baz'
};

// falsch
var bar = new Object();
bar[ a ] = 'foo';
bar[ b ] = 'bar';
bar[ c ] = 'baz';
```

Bei Zugriff auf Arrays sind in den eckigen Klammern, anders als im WordPress Codex, immer Leerzeichen zu setzen.

```js
var element = my_object[ 'foo' ][ bar ];
```

### Klassen

Arbeiten wir mit WordPress und jQuery nutzen wir eine allgemeine Pseudo-Klassenstruktur. In dieser Struktur gibt es eine init Methode, welche stets innerhalb des document-ready-Kontexts ausgeführt wird. Diese Init-Methode simuliert den bei PHP bekannten `__construct()` und darf keine konkreten Operationen enthalten, sondern nur aufrufe weiterer Subroutinen.

```js
( function( $ ) {
	var my_class_name = {
		init: function() {

			// my sub method
			my_class_name.my_sub_method();
		},

		my_sub_method: function() {

				// my code
		},
	};
	$( document ).ready( function( $ ) {
		my_class_name.init();
	} );
} )( jQuery );
```
