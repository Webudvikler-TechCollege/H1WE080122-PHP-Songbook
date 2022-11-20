<?php
/**
 * Db klasse til at håndtere sql forespørgsler med
 * Klassen bruger PHP's PDO api
 * Database credentials skal skrives i den udvidede klasse core/userapp/dbconf.php
 * 
 * Eksemepel på connect:
 * $db = new dbconf();
 * 
 * Forespørgsler håndteres med metoden query.
 * Query metoden håndterer prepare(), bindParams() og execute().
 * 
 * Eksempel på forespørgsel uden variable argumenter:
 * 
 * $sql = "SELECT * FROM foo";
 * $array = $db->query($sql);
 * 
 * Eksempel på forespørgsel med variable argumenter:
 * 
 * Variabler defineres i et array med navn, variabel og datatype:
 * $params = array(
 * 		"name" => array($name, PDO::PARAM_STR),
 * 		"zip" => array($zip, PDO::PARAM_INT)
 * )
 * 
 * Dynamiske værdier i SQL skrives med kolon (:) og variable 
 * navne som markers for variabler:
 * $sql = "SELECT * FROM foo WHERE name = :name AND zip = :zip";
 * 
 * Query kaldes med sql og parametre
 * $array = $db->query($sql, $params);
 */
class Db {
	protected $pdo;
	protected $dbhost;
	protected $dbname;
	protected $dbuser;
	protected $dbpassword;
	protected $dbport;
	protected $sql;
    protected $sth;
	
	public const RESULT_MULTIPLE = 1; // Konstant til resultat med mange records
	public const RESULT_SINGLE = 2; // Konstant til resultat med en enkelt række
	public const RESULT_VALUE = 3; // Konstant til resultat med en enkelt værdi

	/**
	 * DB Constructor
	 * Constructor kaldes med database oplysninger som argumenter
	 * Port er sat til 3306 som default
	 */
	public function __construct($dbhost, $dbname, $dbuser, $dbpassword, $dbport = 3306) {
		$this->dbhost = $dbhost;
		$this->dbname = $dbname;
		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbport = $dbport;
		$this->connect();
	}

	/**
	 * DB Connector
	 * Metode til at oprette forbindelse til en database
	 */
	protected function connect() {
		try {
			$this->pdo = new PDO('mysql:' .
					'host=' . $this->dbhost . ';' .
					'dbname=' . $this->dbname . ';' .
					'port=' . $this->dbport . ';' .
					'charset=utf8',
					$this->dbuser,
					$this->dbpassword,
					array(
						PDO::ATTR_PERSISTENT => true,
						PDO::ATTR_ERRMODE => true,
						PDO::ERRMODE_EXCEPTION => true
					)
			);
		} catch (PDOException $e) {
			print $e->getMessage();
		}
	}

	/**
	 * DB Query
	 * Metode der kan håndtere forespørgsler (queries)
	 * @param $sql - SQL statement
	 * @param null $vars - Array med eventuelle variabler som skal bindes til forespørgslen 
	 * @param int $result_type - Type af resultat. Bruger en af klassens konstanter. Default er multiple.
	 * @param int $flag - Indstilling til form på array index. Standard er associeret value (feltnavne)
	 * @return mixed
	 */
	public function query($sql, $vars = null, $result_type = self::RESULT_MULTIPLE, $flag = PDO::FETCH_ASSOC) {
		// Fjern ydre whitespaces fra sql statement
		$this->sql  = trim($sql);
		// Klargør forespørgsel og sæt statement objekt 
		$this->sth = $this->pdo->prepare( $this->sql );
		// Loop og bind variabler til de respektive markers (:id, :name m.m.)
		if(is_array($vars)) {
			foreach($vars as $key => $arr_val) {
				$this->sth->bindParam(':' . $key, $arr_val[0], $arr_val[1]);
			}
		}
		// Eksekver statement
		$this->sth->execute();

		// Split sql sætning til et array og tildel index 0 til var statement
		$statement = explode(" ", $this->sql)[0];

		// Switch statement og definer metode og return value
		// Dette bruges til at differenciere mellem kommandoer der henter data 
		// og kommandoer der indsætter, opdaterer eller sletter.
		switch(strtoupper($statement)) {
			default:
			case "INSERT":
			case "UPDATE":
			case "DELETE":
				return $this->sth->rowCount();
				break;

			case "SELECT":
			case "SHOW":
				switch($result_type) {
					default:
					case self::RESULT_MULTIPLE:
						$row = $this->sth->fetchAll( $flag );
						break;
					case self::RESULT_SINGLE:
						$row = $this->sth->fetch( $flag );
						break;
					case self::RESULT_VALUE:
						$row = $this->sth->fetch( $flag );
						$row = reset($row);
						break;
				}
				return $row;
				break;
		}
	}
	/**
	 * DB LastInsertID
	 * Metode til at hente sidste oprettede id
	 * @return mixed
	 */
	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
	/**
	 * DB Close
	 * Metode til at lukke forbindelsen med
	 */
	public function close()
	{
		$this->pdo = null;
	}
}