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
```