# Inpsyde Theme Codex

Dieses Dokument soll bei Entwicklung von Themes helfen. Es listet diverse Themen, die das bestmögliche Erstellen von WordPress Themes zum Ziel hat. Dabei werden Themen wie Sicherheit, Plugin vs. Theme und die Unterstützung von dynamisch erstellten Inhalten berücksichtigt.

## Inhalt
 * [Escaping](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#escaping)
 * [Internationalisierung](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#internationalisierung)
 * [Enqueues](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#enqueues)
 * [Scripte](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#scripte)
 * [Stylesheets](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#stylesheets)
 * [Queries](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#queries)
 * [Theme vs. Plugin](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#theme-vs-plugin)
 * [Theme Check Liste](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#theme-check-liste)
 * [Beispiele](https://github.com/inpsyde/Codex/blob/master/draft/theme-codex.md#beispiele)

## Escaping
 * Alle dynamischen Daten sichern mit `esc_attr()` bevor sie in html gerändert werden
 * Alle dynamischen URLs sichern mit `esc_url()`
 * Wenn dyn. js-Daten in html verwendet werden, dann sichern mit `esc_js()`
 * SQL Statements mit `$wpdb->prepare()` sichern
 
## Internationalisierung
 * Alle für Benutzer sichtbaren Texte müssen übersetzbar sein, Verwendung von `__()`, `_e()` etc. (Ausnahme: Kundenwunsch)
 * HTML innerhalb von Zeichenketten vermeiden
 * Die Ausgebe von `sprintf()` muss gesichert werden, siehe [Escaping](#escaping)
 * `printf()` Platzhalter müssen gesichert werden
 * Kontexte bei Platzhaltern beachten `_x( 'Comment %s', '%s = Counter of comment to this post', 'textdomain' )`, siehe [WP Codex][codex_context]
	 * Übersetzungen sind damit einfacher zu erstellen, da der String im Kontext erklärt wird
	 * Weiteres Beispiel in [Issue #21](https://github.com/inpsyde/Codex/issues/21)
 * Anti Patterns vermeiden, siehe [WP Codex][codex_antipattern]
 
```php
// bad examples
__( '', 'textdomain' ); // Empty strings.
__( $variable, 'textdomain' ); // Single variables.
printf( __( '%s' ), $var ); // Single placeholders
__( mytheme_function(), 'textdomain' ); // Single functions
```

## Enqueues
 * Die richtigen Hooks verwenden, für Scripte und Stylesheets
	* Frontend:			`wp_enqueue_scripts`
	* Backend:			`admin_enqueue_scripts` 
	* Login:			`login_enqueue_scripts`
	* Spezielle Seiten:	`admin_print_styles-{$hook_suffix}` und `admin_print_scripts-{$hook_suffix}`

 * Protokoll beachten

```php
$protocol = is_ssl() ? 'https' : 'http';
wp_enqueue_style( 'mytheme-opensans', "$protocol://fonts.googleapis.com/css?family=Open+Sans" );
```

 * Suffix beachten

```php
$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '.dev' : '';
wp_register_script(
	'Key', 
	plugins_url( '/js/script' . $suffix. '.js', plugin_basename( __FILE__ ) ), 	
	array( 'jquery' ),
	'',
	TRUE
);
```

## Scripte
 * Scripte aus dem Core bevorzugen
 * Scripte als lesbare und minifizierte Version ausliefern; siehe [Suffix beachten](#enqueues)

## Stylesheets
 * Alle Stylesheets via "[Enqueue](#escaping)" einreihen
 * Vermeide `overflow: hidden;`, Alternative [micro clearfix](http://nicolasgallagher.com/micro-clearfix-hack/)
 * Vermeide `!important`
 * Vermeide Inline Styles

## Queries
 * Vermeide SQL Selects, wenn möglich und nutze besser ein WP_Query Object
 * Vermeide unendliche Queries. In der Regel heißt das, dass `post_per_page` oder `numberposts` einen Wert bekommen, nicht `-1`.
 * Verwende Transients für das Cachen von Queries
 * Vermeide `query_posts()`! Wenn der Main Query verändert werden soll, dann nutze den Filter `pre_get_posts` oder erstelle eine neues `WP_Query` Objekt.
 * Leere Werte auf `post__in` verhindern, da dies auf Fehler läuft. Wird der Parameter dynamisch befüllt, so muss er im Vorfeld geprüft werden. 
 
```php
if ( ! empty( $my_post_ids ) ) {
	$my_posts = new WP_Query( array(
		'post__in'       => $my_post_ids,
		'post_status'    => 'publish',
		'posts_per_page' => 10,
		'no_found_rows'  => TRUE,
	) );
}
```

 * Laufzeit Queries (Bspw. Taxonomien) sollten über eine große Menge getestet werden um Fehler zu identifizieren ~10.000

## Theme vs. Plugin

**Theme oder Plugin &mdash; Präsentation von Inhalt oder das Erstellen, die Verwaltung von Inhalt**
 
 * Funktion &mdash; Plugin
 * Design &mdash; Theme, Child Theme

Denke über die Einbindung von Funktionen nach, die ggf. nicht für die Darstellung im Theme gebraucht werden.

## Theme Check Liste
 * Anforderungen dem Theme beilegen; bevorzugt in der `readme.md` im Repo
 * PHP Kommentare prüfen

```php
/**
 * Theme Name:  Name Mustermann
 * Description: A small Theme for <customer x>
 * Version:     mm/dd/yyyy  2.3.0
 * Author:      Inpsyde GmbH
 * Author URI:  http://inpsyde.com/
 * License:     GPLv3
 * License URI: assets/license.txt
 */
```
 * Codex prüfen
 * Daten auf Basis [WP Theme Unit Test](http://codex.wordpress.org/Theme_Unit_Test) oder [wptest.io](http://wptest.io/) prüfen
 * Dateien prüfen
	 * `index.php`
	 * `404.php`
	 * `style.css`
	 * `screenshot.png` - 600 x 450px (HiDPI Ready)
	 * `readme.md`
	 * `license.txt`
 * `functions.php` vorhanden
	 * Einbindung der Funktionen via Hook, min. `after_setup_theme`
	 * Codex für PHP beachten
 * Internationalisierung beachten, siehe [Internationalisierung](#internationalisierung)
	 * Unterordner `languages`
	 * `de_DE.pot`
	 * `de_DE.po` und `de_DE.mo`
	 * Initialisierung in der `functions.php`
 * Template Parts im Unterordner `parts` ablegen
 * Struktur für js, css, scss, etc. beachten
 * Suffix beachten
 * Prüfung via Plugin "[Log Deprecated Notices](http://wordpress.org/extend/plugins/log-deprecated-notices/)"
	 * Nützliche Erweiterung [Extender](http://wordpress.org/extend/plugins/log-deprecated-notices-extender/)
 * [Theme Check](http://wordpress.org/extend/plugins/theme-check/) plugin (nicht schön, aber nützlich)
	 * Ggf. [Theme Mentor](https://github.com/mpeshev/Theme-Mentor)
 * Browsertest - Anforderungen des Kunden beachten
 * Frontend Sicht-Prüfung
 * Funktionsprüfung, manuell
 * Prüfung Code
	 * Javascripts im Footer (ggf. Ausnahmen)
	 * Minifizierte Stylesheets und Scripte für die Liveversion
	 * HTML Validator
	 * CSS Validator
	 * Console Webinspecter o.ä. beachten

## Beispiele
 * [inTheme](https://github.com/inpsyde/intheme)
 * [WordPress-Basis-Theme](https://github.com/bueltge/WordPress-Basis-Theme)

[codex_context]: http://codex.wordpress.org/I18n_for_WordPress_Developers#Disambiguation_by_context
[codex_antipattern]: http://developer.wordpress.com/themes/i18n/#anti-patterns
