# HTML und Templates

Dieses Dokument bezieht sich auf Dateien oder Dateiabschnitte mit HTML-Anteil.

## HTML Style Guide

### Doctype

Ein Doctype ist Pflicht. Im Normalfall sollte der `html5` Doctype verwendet werden.

```html
<!DOCTYPE html>
```

### Richtlinien

- Absätze sind in `<p>` Tags zu setzen. Aufeinanderfolgende `<br/>` Tags sind zu vermeiden.
- Anführungszeichen um Attribte müssen zur besseren Lesbarkeit immer geschrieben werden.

```html
<span class="example">Dies ist ein Beispiel</span>
```

- Blockelemente sollten immer eingerückt werden. Inline-Elemente können eingerückt werden, um die Lesbarkeit zu verbessern.

```html
<!-- gut -->
<div class="vcard">
	<span class="first_name">John</span>
	<span class="last_name">Doe</span>
	<div class="bio">
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
	<span class="first_name">John</span><span class="last_name">Doe</span>	
	<div class="bio"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p><p>Cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p></div>
</div>
```

- Das `style` Attribut ist zu vermeiden.
- Inline JavaScript (`onclick`, `onmouseover` usw.) ist nicht gestattet.

## Template Style Guide

Sobald in einem PHP-Abschnitt mehr als ein Tag ausgegeben wird, muss zur besseren Lesbarkeit Template-Schreibweise verwendet werden. Nur so können Editoren Syntax-Highlighting, Auto-Vervollständigung etc. anbieten.

```php
<?php 
function the_vcard_name( $first, $last ) {
	?>
	<span class="first_name"><?php echo $first; ?></span>
	<span class="last_name"><?php echo $last; ?></span>
	<?php
}
?>
```