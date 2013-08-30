<?php

namespace Inpsyde\Core;

/**
 * PSR-4 Autoloader Implementation 
 * 
 * Usage:
 * $autoloader = new \Inpsyde\Core\Autolaoder( __NAMSEPACE__, __DIR__ );
 * $autoloader->register();
 *
 * To function Classes and Files need to share the exact same name, 
 * e.g. The file for the class "FooBar" must be named "FuBar.php"
 *
 * @author Andre Peiffer
 * @version 0.1
 * @package Core
 */

class Autoloader {

	/**
	 * Base namespace
	 * 
	 * @access private
	 * @var string
	 */
	private $_namespace = NULL;

	/**
	 * location to load classes from
	 * 
	 * @access private
	 * @var string
	 */
	private $_basepath = NULL;

	/**
	 * the file extension to load
	 *
	 * @access private
	 * @var string
	 */
	private $_extension = NULL;

	/**
	 * Creates a new Autoloader Instance
	 * 	
	 * @param string $namespace basenamespace
	 * @param string $path      basepath
	 * @param string $extension file extension to load
	 */
	public function __construct( $namespace, $path, $extension = '.php' ) {
		
		//Normalize basenamespace and basepath
		$this->_namespace = trim($namespace, '\\') . '\\';
		$this->_basepath = rtrim( $path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
		$this->_extension = $extension;

		return $this;
	}

	/**
	 * registers the autoloader
	 * @return \Inpsyde\Core\Autoloader this instance
	 */
	public function register() {
		spl_autoload_register( array( $this, 'load' ) );

		return $this;
	}

	/**
	 * unregisters the autoloader
	 * @return \Inpsyde\Core\Autoloader this instance
	 */
	public function unregister() {
		spl_autoload_unregister( array( $this, 'load' ) );

		return $this;
	}

	/**
	 * Loads the requested class. 
	 * 
	 * @param  string $classname the requested fully qualified classname
	 * @throws \Exception
	 * @return mixed            returns the loaded path on success, false on failure
	 */
	public function load( $classname ) { 

       while ( false !== $pos = strrpos( $this->_namespace, '\\' ) ) {
            
            // retain the trailing namespace separator in the basenamespace
            $basenamespace = substr($classname, 0, $pos + 1);

            // the rest is the relative class name
            $class = substr($classname, $pos + 1);

            if( $basenamespace == $this->_namespace ){
            	$file = $this->_basepath . str_replace( '\\', DIRECTORY_SEPARATOR, $class ) . $this->_extension;
            	
				if( file_exists( $file ) ) {
					require_once $file;
					return $file;
				} else {
					throw new \Exception( 'Class ' . $namespace . ' not found in ' . $file );
				} 
            }

            $basenamespace = rtrim($prefix, '\\');   
        } 

     	return false;    	
	}

}


?>