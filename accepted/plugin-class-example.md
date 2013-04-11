# Inpsyde Codex

## Beispiel Plugin Klassen-Aufbau
Der Code zeigt eine Beispielklasse, wie sie genutzt werden kann und unsere Erfahrungen unterbringt.

#### Vorteile
 * Leerer Konstruktor für die Nutzung von Unit Tests
	* Unit Tests können neue Instanzen anlegen - ohne automatisches Erzeugen anderer Hooks
	* Kein Singleton
 * Vermeidung globaler Variablen
 * OOP 
 * Keine statischen Methoden
 * Einfach zu deaktivieren
 * Aufruf: `Inpsyde_Plugin_Class_Example::get_instance()`

#### Nachteile
 * Mehr code, ggf. schwerer lesbar

#### Source
```php
	add_action( 
		'plugins_loaded',
		array( Inpsyde_Plugin_Class_Example::get_instance(), 'plugin_setup' )
	);
	 
	class Inpsyde_Plugin_Class_Example {
	
		/**
		 * Plugin instance.
		 *
		 * @see   get_instance()
		 * @type  object
		 */
		protected static $instance = NULL;
	
		/**
		 * URL to this plugin's directory.
		 *
		 * @type  string
		 */
		public $plugin_url = '';
	
		/**
		 * Path to this plugin's directory.
		 *
		 * @type  string
		 */
		public $plugin_path = '';
	
		/**
		 * Access this plugin’s working instance
		 *
		 * @wp-hook plugins_loaded
		 * @since   02/12/1974
		 * @return  object of this class
		 */
		public static function get_instance() {
		
			NULL === self::$instance and self::$instance = new self;
		
			return self::$instance;
		}
	
		/**
		 * Used for regular plugin work.
		 *
		 * @wp-hook  plugins_loaded
		 * @since    02/12/1974
		 * @return   void
		 */
		public function plugin_setup() {
		
			$this->plugin_url    = plugins_url( '/', __FILE__ );
			$this->plugin_path   = plugin_dir_path( __FILE__ );
			$this->load_language( 'plugin_unique_name' );
		
			// more stuff: register actions and filters
		}
	
		/**
		 * Constructor.
		 * Intentionally left empty and public.
		 *
		 * @see    plugin_setup()
		 * @since  02/12/1974
		 */
		public function __construct() {}
	
		/**
		 * Loads translation file.
		 *
		 * Accessible to other classes to load different language files (admin and
		 * front-end for example).
		 *
		 * @wp-hook init
		 * @param   string $domain
		 * @since   02/12/1974
		 * @return  void
		 */
		public function load_language( $domain ) {
		
			load_plugin_textdomain(
				$domain,
				FALSE,
				$this->plugin_path . 'languages'
			);
		}
	
	} // end class
```
