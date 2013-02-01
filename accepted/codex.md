# Inpsyde Codex

## Code Style Richtlinien

Diese Sektion benennt allgemeine PHP Code Style Richtlinien. Sofern nicht anders benannt, gelten die Regeln als Pflicht und sind einzuhalten.

### Dateikonventionen

- Dateien beginnen mit `<?php`. Kurze Tags sind nie erlaubt.
- Dateien enden nie mit dem schließenden Tag, um versehentliche Leerzeichen zu verhindern.
- Dateien werden in UTF-8 enkodiert.
- Es werden UNIX-Zeilenenden verwendet (`LF`)
- Code wird mit Tabs eingerückt.
- Es gibt kein erzwungenes Limit in der Zeilenlänge. Es soll jedoch angestrebt werden, 80 bzw. 120 Zeichen einzuhalten.

### Allgemeines

- Es ist nur genau eine Anweisung pro Zeile gestattet.
- Vor und nach folgenden Operatoren steht ein Leerzeichen: `!` `*` `/` `%` `+` `-` `.` `<<` `>>` `<` `<=` `>` `>=` `==` `!=` `===` `!==` `&` `^` `|` `&&` `||` `?` `:` `=` `+=` `-=` `*=` `/=` `.=` `%=` `&=` `|=` `^=` `<<=` `>>=` `and` `xor` `or` `,`
- In Vergleichsoperationen mit Konstanten ist die "intuitive" Reihenfolge zu verwenden, d.h. die Konstante steht rechts (`$i > 5`). "Yoda-Conditions" (`true == $the_force`) sind nicht erwünscht.

### Kontrollstrukturen

Im Kopf von Kontrollstrukturen finden keine Zuweisungen statt.

```php
<?php
// richtig
$a = foo( $b );
if ( $a ) {
    // code
}

// falsch
if ( $a = foo( $b ) ) {
    // code
}

```

#### if, else, elseif

Klammern sind Pflicht, außer bei einzelnen Anwesungen im Block. Beinhaltet mindestens ein Block mehr als eine Anweisung, müssen alle anderen Blöcke auch geklammert werden.

```php
<?php
// richtig
if ( $c )
	return;

// richtig
if ( $c ) {
	$foo = 3;
	return;
}

// falsch
if ( $c ) return;

// richtig
if ( $c ) {
	# code...
} else {
	# code...
}

// richtig
if ( $c )
	return 'a';
else
	return 'b';

// falsch
if ( $c )
	# code...
else {
	# code...
}

// falsch
if ( $c ) {
	# code...
} else
	# code...

```

Der ternäre Operator `?:` ist erlaubt, darf aber nicht geschachtelt werden.

```php
<?php
// richtig
$a = ( $condition ) ? 'foo' : 'bar';

// falsch
$a = ( $condition ) ? ( ( $condition2 ) ? 42 : 23 ) : 'bar';

```

#### while

```php
<?php 
while ( $something_is_true ) {
	# code...
}

```

#### for

Aus Performancegründen sollten die Schleifengrenzen vor der `for`-Schleife berechnet werden. Wenn möglich, sollte `foreach` statt `for` benutzt werden.

```php
<?php 
$length = strlen( $foo );
for ( $i = 0; $i < $length; $i++ ) { 
	# code...
}

```
#### foreach

```php
<?php 
foreach ( $data as $key => $value ) {
	# code...
}

```

#### switch

Das bewusste Auslassen von `break` ist nicht erwünscht, da es Quelle schwer nachvollziehbarer Fehler sein kann.

```php
<?php 
switch ( $foo ) {
	case 'bar':
		# code...
		break;
	default:
		# code...
		break;
}

```

### Klammersetzung

- Öffnende Klammern für Klassen, Methoden und Kontrollstrukturen stehen auf der selben Zeile wie der jeweilige Kopf.
- Schließende Klammern für Klassen, Methoden und Kontrollstrukturen stehen auf einer separaten Zeile.
- Nach einem Schlüsselwort folgt ein Leerzeichen. Nach den Namen von Fuktionen und Methoden steht nie ein Leerzeichen.

```php
<?php
// korrekt
function foo() {
    
    if ( TRUE ) {
        bar();
    }
}

// falsch
function foo()
{
    if( TRUE ) {
        bar ();
    }
}

```

### Klassen, Properties und Methoden

#### Deklaration

- Sichtbarkeit muss für alle Properties und Methoden explizit deklariert sein.
- Das Schlüsselwort `var` wird nicht verwendet.
- Property- und Methodennamen beginnen nicht mit einem Underscore.
- Dem Methodennamen folgt kein Leerzeichen.
- Es dürfen Methoden nur dann statisch aufgerufen werden, wenn diese auch explizit mit `static` als solche deklariert wurden.
- Funktionen sind mit [PHPDoc](http://www.phpdoc.org/) zu dokumentieren

```php
<?php
/**
 * Class summary in one sentence.
 *
 * More documentation can go here.
 * Go into nitty gritty details if you like.
 *
 * @since   MM/DD/YYYY VERSION
 * @version MM/DD/YYYY
 * @author  eteubert
 */
class Class_Name {
	
	/**
	 * Method summary in one sentence.
	 *
	 * More documentation can go here.
	 * Go into nitty gritty details if you like.
	 *
	 * Examples:
	 *   // you may even provide usage examples if helpful
	 *   echo get_some_magic();
	 *
	 * [@since   MM/DD/YYYY] // (optional) first introduction
	 * [@version MM/DD/YYYY] // (optional) latest change
	 * [@author  eteubert]   // (optional) author, if different from class author
	 * [@wp-hook init]       // (optional) which hooks is this function connected to?
	 * [@uses    enchant]    // (optional)
	 *
	 * @param  boolean $sparkles Should it sparkle or not?
	 * @param  string  $spell    Name of the magic spell.
	 * @return string            Let magic happen.
	 */
	public function get_some_magic( $sparkles = TRUE, $spell = 'abrakadabra' ) {

		if ( $sparkles )
			$out = '*sparkle* ' . enchant( $spell ) . ' *sparkle*';
		else
			$out = $spell;

		return $out . '!';
	}

}

```

#### Aufruf

Zwischen dem Namen der Methode oder Funktion und der öffnenden Klammer darf kein Leerzeichen sein. In der Argumentliste folgt jedem Komma ein Leerzeichen. Vor einem Komma ist kein Leerzeichen.

```php
<?php
bar();
$foo->bar( $arg1 );
Foo::bar( $arg2, $arg3 );

```

Argumentlisten können zur Verbesserung der Lesbarkeit auf mehrere Zeilen aufgeteilt werden. Dann werden alle Elemente um eine Ebene eingerückt, das erste Argument steht auf einer eigenen Zeile und es befindet sich genau ein Argument auf jeder Zeile. Auch die schließende Klammer befindet sich auf einer neuen Zeile.

```php
<?php
$foo->bar(
    $long_argument,
    $longer_argument,
    $much_longer_argument
);

```

### Arrays

Wir orientieren uns hier am Codex und Core von WordPress, den wir ein bisschen erweitern. Denn bei uns bekommt jedes Element eine eigene Zeile, das Komma kommt an das Ende und die Klammern auf eigene Zeilen und die Zuweisungszeichen werden mit Tabs auf eine Spalte gebracht.:

```php
<?php
$my_array = array(
    'foo'    => $bar,
    'rab'    => $oof,
    'foobar' => $barfoo
);

```

Mehrdimensionale Arrays schreibt man wie folgt, wobei das Array im Array immer ganz unten steht:

```php
<?php
$my_array = array(
    'foo'    => $bar,
    'rab'    => $oof,
    'foobar' => array(
        'bar'    => $foo,
        'oof'    => $rab,
        'barfoo' => $raboof
    ),
);

```

Mehrdimensionale Arrays mit mehr als fünf Parametern müssen ausgelagert werden:

```php
<?php
$labels = array(
	'name'               => __( 'Foo', $this->get_textdomain() ),
	'add_new'            => __( 'Add Foo', $this->get_textdomain() ),
	'new_item'           => __( 'New Foo', $this->get_textdomain() ),
	'all_items'          => __( 'All Foo', $this->get_textdomain() ),
	'view_item'          => __( 'View Foo', $this->get_textdomain() ),
	'edit_item'          => __( 'Edit Foo', $this->get_textdomain() ),
	'not_found'          => __( 'No Foo added yet', $this->get_textdomain() ),
	'menu_name'          => __( 'Foo', $this->get_textdomain() ),
	'add_new_item'       => __( 'Add New Foo', $this->get_textdomain() ),
	'search_items'       => __( 'Search Foo', $this->get_textdomain() ),
	'singular_name'      => __( 'Foo', $this->get_textdomain() ),
	'parent_item_colon'  => __( 'Parent Foo', $this->get_textdomain() ),
	'not_found_in_trash' => __( 'Nothing found in trash', $this->get_textdomain() ),
);

$support = array(
	'title',
	'editor',
	'excerpt',
	'comments',
	'revision',
	'thumbnail',
	'custom-fields'
);

$args = array(
	'public'             => TRUE,
	'labels'             => $labels,
	'show_ui'            => TRUE,
	'rewrite'            => TRUE,
	'supports'           => $support,
	'query_var'          => TRUE,
	'has_archive'        => TRUE,
	'hierarchical'       => FALSE,
	'menu_position'      => NULL,
	'capability_type'    => 'post',
	'publicly_queryable' => TRUE
);

```

Bei Zugriff auf Arrays sind in den eckigen Klammern, anders als im WordPress Codex, immer Leerzeichen zu setzen.

```php
<?php
$element = $field[ 'foo' ][ $bar ];

```

## Namenskonventionen

- Konstanten und Klassenkonstanten werden in `UPPER_CASE_WITH_UNDERSCORES` deklariert.
- Methodennamen und Funktionen werden in `lower_case_with_underscores()` deklariert.
- Klassennamen und Namespaces werden in `Upper_Snake_Case` deklariert.
- Variablennamen werden in `$lower_case_with_underscores` deklariert.
- PHP [Schlüsselworte](http://php.net/manual/de/reserved.keywords.php) sind klein zu schreiben.
- Booleans `TRUE`, `FALSE` und der Spezialwert `NULL` sind groß zu schreiben.

### Dateinamen

- Klassendateinamen bekommen ein `class-` Präfix. Danach folgt der Klassenname in lowercase: `class-my_little_pony.php`
- Sonstige Dateinamen ebenfalls lowercase mit Underscores: `all_the_ponies.php`

## Namespaces

- Jede Klasse in einem Namespace hat die Form `\<Vendor Name>\<Plugin Name>(\<Namespace>)*<Class Name>`. In unserem Fall ist `<Vendor Name> = Inpsyde`.
- Namespaces bilden die Ordnerstruktur in `inc/` ab

- `\Inpsyde\Annihilator\Annihilator` => `/wp-content/plugins/annihilator/inc/class-annihilator.php`
- `\Inpsyde\Annihilator\Form\Builder` => `/wp-content/plugins/annihilator/inc/form/class-builder.php`

## HTML und Templates

Dieses Dokument bezieht sich auf Dateien oder Dateiabschnitte mit HTML-Anteil.

### HTML Style Guide

#### Doctype

Ein Doctype ist Pflicht. Im Normalfall sollte der `html5` Doctype verwendet werden.

```html
<!DOCTYPE html>
```

#### Richtlinien

- Shorttags werden in HTML5 schreibweise geschrieben:

```html
<link rel="stylesheet" type="text/css" href="style.css">
<meta name="description" content="Foo">
<br>
```

- Absätze sind in `<p>` Tags zu setzen. Aufeinanderfolgende `<br>` Tags sind zu vermeiden.
- Anführungszeichen um Attribte müssen zur besseren Lesbarkeit immer geschrieben werden.

```html
<span class="example">Dies ist ein Beispiel</span>
```

- Blockelemente sollten immer eingerückt werden. Inline-Elemente können eingerückt werden, um die Lesbarkeit zu verbessern.

```html
<!-- gut -->
<div class="vcard">
	<span class="fn n">
		<span class="given-name">John</span>
		<span class="family-name">Doe</span>
	</span>
	<div class="biography">
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit,
			sed do eiusmod tempor incididunt ut labore et dolore magna
			aliqua. Ut enim ad minim veniam.
		</p>
		<p>
			Cillum dolore eu fugiat nulla pariatur. Excepteur sint
			occaecat cupidatat non proident, sunt in culpa qui officia 
			deserunt mollit anim id est laborum.
		</p>
	</div>
</div>

<!-- schlecht -->
<div class="vcard">
	<span class="fn n"><span class="given-name">John</span><span class="family-name">Doe</span></span>
	<div class="biography"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p><p>Cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p></div>
</div>
```

- Das `style` Attribut ist zu vermeiden.
- Inline JavaScript (`onclick`, `onmouseover` usw.) ist nicht gestattet.

### Template Style Guide

Sobald in einem PHP-Abschnitt mehr als ein Tag ausgegeben wird, muss zur besseren Lesbarkeit Template-Schreibweise verwendet werden. Nur so können Editoren Syntax-Highlighting, Auto-Vervollständigung etc. anbieten.

```php
<?php 
function the_vcard_name( $first = NULL, $last = NULL ) {
	?>
	<span class="given-name"><?php echo $first; ?></span>
	<span class="family-name"><?php echo $last; ?></span>
	<?php
}

```

In HTML-Abschnitten ist die [Alternative Syntax für Kontrollstrukturen](http://php.net/manual/de/control-structures.alternative-syntax.php) zu verwenden.

```php
<div class="people">
	<?php foreach ( $people as $person ): ?>
		<div class="person">
			<?php if ( $person->has_avatar() ): ?>
				<div class="avatar"><?php echo $person->get_avatar(); ?></div>
			<?php endif; ?>
			<span class="given-name"><?php echo $person->first; ?></span>
			<span class="family-name"><?php echo $person->last; ?></span>
			<!-- more html ... -->
		</div>
	<?php endforeach; ?>
</div>
```

## WordPress spezifische Best Practices

Alle Hinweise in diesem Dokument gelten als Empfehlungen. Nichts ist verpflichtend, jedoch wird die Beachtung empfohlen.

### Allgemeines

- Statt `get_bloginfo()` sind die jeweiligen Wrapperfunktionen zu bevorzugen. Zum Beispiel `home_url()` statt `get_bloginfo( 'url' )`. Siehe http://codex.wordpress.org/Function_Reference/get_bloginfo#Parameters

### Vermeidung globaler Variablen

Wenn möglich, sollte auf die Verwendung globaler Variablen verzichtet werden. Das ist nicht immer möglich. Einige Tips folgen.

```php
<?php
global $post;
$post_id = $post->ID;

// besser:
$post_id = get_the_ID();
?>
```

### Plugin Dateistruktur

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

#### `inc/` Ordner

Der `inc/` Ordner enthält den gesamten für das Plugin geschriebenen Code. Der Basis-Namespace ist `\Inpsyde\<Plugin Name>\`. Es können beliebige Subnamespaces angelegt werden. Jeder Subnamespace wird durch einen Ordner im Dateisystem repräsentiert.

#### `inc/features/` Ordner

Der `features/` Ordner enthält Dateien, welche Features für die Pro-Version des Plugins bereitstellen. `features/` enthält nur Dateien, keine Ordner. Jeder dieser Dateien hat den Namespace `\Inpsyde\<Plugin Name>\Features`. Die Dateien dürfen Abhängigkeiten zu Methoden und Klassen aus `inc/` und `lib/` haben, aber nicht untereinander.

#### `lib/` Ordner

Der `lib/` Ordner kann PHP Code aus externen Bibliotheken enthalten.

#### .dev Assets

CSS und JavaScript Dateien werden als `<filename>.dev.<extension>` entwickelt. Darin sind Kommentare erlaubt und erwünscht.

Produktiv ausgeliefert wird eine von Kommentaren befreite und minifizierte `<filename>.<extension>`.

- http://jscompress.com/ (JS)
- http://refresh-sf.com/yui/ (JS & CSS)

### Keine `class_exists` Checks zur Kollisionsvermeidung

In PHP 5.2 Plugins ist es üblich, alle Klassen in ein `class_exists` zu wrappen. Das ist mit Namespaces nicht mehr notwendig, weshalb darauf verzichtet werden kann.

```php
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

```

### PHP 5.3 Plugin Vorlage

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
 * Author:      Inpsyde GmbH
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