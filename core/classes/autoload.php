<?php
/**
 * Classloader
 * 
 * Fed lille funktion som sparer dig for en masse include helvede!
 * 
 * Bruger PHP's Standard Library (SPL) function spl_autoload_register
 * til at opsnappe en klasse når den kaldes og derefter kigge 
 * efter den og registrere den i en af core mapperne.
 * 
 * Funktionen betinger at dit klassenavn hedder det samme som din klassefil.
 * Eks. fil med klasse User skal hedder user.php
 */
spl_autoload_register(function ($class) {
	// Sætter array med stier til klassemapper
	$paths = array("classes", "userapp");

	// Looper array og inkludere fil hvis den eksisterer
	foreach($paths as $path) {
		//echo COREROOT . $path . "/" . strtolower($class). '.php<br>';
		$file = COREROOT . $path . "/" . strtolower($class). '.php';
		if(file_exists($file)) {
			require_once $file;
		}
	}
});