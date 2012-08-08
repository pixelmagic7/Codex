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
- Vor und nach folgenden Operatoren steht ein Leerzeichen: `!` `*` `/` `%` `+` `-` `.` `<<` `>>` `<` `<=` `>` `>=` `==` `!=` `===` `!==` `&` `^` `|` `&&` `||` `?` `:` `=` `+=` `-=` `*=` `/=` `.=` `%=` `&=` `|=` `^=` `<<=` `>>=` `and` `xor` `or` `,`

## Kontrollstrukturen

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
?>
```

### if, else, elseif

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
?>
```

Der ternäre Operator `?:` ist erlaubt, darf aber nicht geschachtelt werden.

```php
<?php
// richtig
$a = ( $condition ) ? 'foo' : 'bar';

// falsch
$a = ( $condition ) ? ( ( $condition2 ) ? 42 : 23 ) : 'bar';
?>
```

### while

```php
<?php 
while ( $something_is_true ) {
	# code...
}
?>
```

### for

Aus Performancegründen sollten die Schleifengrenzen vor der `for`-Schleife berechnet werden. Wenn möglich, sollte `foreach` statt `for` benutzt werden.

```php
<?php 
$length = strlen( $foo );
for ( $i = 0; $i < $length; $i++ ) { 
	# code...
}
?>
```
### foreach

```php
<?php 
foreach ( $data as $key => $value ) {
	# code...
}
?>
```

### switch

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
?>
```

## Klammersetzung

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
?>
```

## Klassen, Properties und Methoden

### Deklaration

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
?>
```

### Aufruf

Zwischen dem Namen der Methode oder Funktion und der öffnenden Klammer darf kein Leerzeichen sein. In der Argumentliste folgt jedem Komma ein Leerzeichen. Vor einem Komma ist kein Leerzeichen.

> Ich überlege, die Leerzeichen nach öffnenden und vor schließenden runden Klammern generell optional zu gestalten.
> Ich glaube, im Moment sind sie Pflicht. Jedoch widerspricht das jeder PHP Richtlinie außerhalb des WordPressversums. Selbst der WordPress Core hält sich oft genug nicht daran ...
> Hier bin ich für Whitespace zu gunsten der Lesbarkeit. Oft fehlen die nur wegen Speed beim Schreiben, nicht wegen faktischer Gründe.

```php
<?php
bar();
$foo->bar( $arg1 );
Foo::bar( $arg2, $arg3 );
?>
```

Argumentlisten können zur Verbesserung der Lesbarkeit auf mehrere Zeilen aufgeteilt werden. Dann werden alle Elemente um eine Ebene eingerückt, das erste Argument steht auf einer eigenen Zeile und es befindet sich genau ein Argument auf jeder Zeile. Auch die schließende Klammer befindet sich auf einer neuen Zeile.

```php
<?php
$foo->bar(
    $longArgument,
    $longerArgument,
    $muchLongerArgument
);
?>
```

## Arrays

Wir orientieren uns hier am Codex und Core von WordPress, den wir ein bisschen erweitern. Denn bei uns bekommt jedes Element eine eigene Zeile, das Komma kommt an das Ende und die Klammern auf eigene Zeilen und die Zuweisungszeichen werden mit Tabs auf eine Spalte gebracht.:

```php
<?php
$my_array = array(
    'foo'    => $bar,
	'rab'    => $oof,
	'foobar' => $barfoo
);
?>
```

Mehrdimensionale Arrays schreibt man wie folgt, wobei das Array im Array immer ganz unten zu stehen hat:

```php
<?php
$my_array = array(
	'foo'   	=> $bar,
	'rab'		=> $oof,
	'foobar'	=> array(
		'bar'		=> $foo,
		'oof'		=> $rab,
		'barfoo'	=> $raboof
	),
);
?>
```

Mehrdimensionale Arrays mit mehr als fünf Parametern müssen ausgelagert werden:

```php
<?php
$labels = array(
	'name'			=> __( 'Foo', $this->get_textdomain() ),
	'add_new'		=> __( 'Add Foo', $this->get_textdomain() ),
	'new_item'		=> __( 'New Foo', $this->get_textdomain() ),
	'all_items'		=> __( 'All Foo', $this->get_textdomain() ),
	'view_item'		=> __( 'View Foo', $this->get_textdomain() ),
	'edit_item'		=> __( 'Edit Foo', $this->get_textdomain() ),
	'not_found'		=> __( 'No Foo added yet', $this->get_textdomain() ),
	'menu_name'		=> __( 'Foo', $this->get_textdomain() ),
	'add_new_item'		=> __( 'Add New Foo', $this->get_textdomain() ),
	'search_items'		=> __( 'Search Foo', $this->get_textdomain() ),
	'singular_name'		=> __( 'Foo', $this->get_textdomain() ),
	'parent_item_colon'	=> __( 'Parent Foo', $this->get_textdomain() ),
	'not_found_in_trash'	=> __( 'Nothing found in trash', $this->get_textdomain() ),
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
	'public'		=> TRUE,
	'labels'		=> $labels,
	'show_ui'		=> TRUE,
	'rewrite'		=> TRUE,
	'supports'		=> $support,
	'query_var'		=> TRUE,
	'has_archive'		=> TRUE,
	'hierarchical'		=> FALSE,
	'menu_position'		=> NULL,
	'capability_type'	=> 'post',
	'publicly_queryable'	=> TRUE
);
?>
```

Bei Zugriff auf Arrays sind in den eckigen Klammern, anders als im WordPress Codex, immer Leerzeichen zu setzen.

```php
<?php
$element = $field[ 'foo' ][ $bar ];
?>
```