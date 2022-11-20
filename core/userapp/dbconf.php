<?php
/**
 * Class dbconf
 * Klasse med oplysninger til din database
 * - dbhost: Database host
 * - dbuser: Brugernavn til databasen
 * - dbpassword: Adgangskode til databasen
 * - dbnavn: Navnet på databasen
 * Nedarver db klassen og opretter forbindelse til database
 */
class dbconf extends db {
    function __construct() {
        $this->dbhost = "localhost";
	    $this->dbuser = "root";
        $this->dbpassword = "password";
        $this->dbname = "dbname";
        $db = parent::connect();
    }
}