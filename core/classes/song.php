<?php
/**
 * Class Song med CRUD metoder
 */ 
class Song {
	/**
	 * Class properties
	 */
	public $id;
	public $title;
	public $content;
	public $artist_id;
	public $created_at;
	public $updated_at;
	private $db;

	/**
	 * Class Constructor
	 * Metode som kaldes automatisk når der kaldes en instans af klassen
	 * Constructoren globaliserer $db objektet og gør det tilgængeligt i sit scope.
	 * Derefter tildeles det til klassens egen db property
	 */
	public function __construct()
	{	
		global $db;
		$this->db = $db;
	}

	/**
	 * Metode til at hente alle sange
	 */
	public function list() {
		// Sætter sorteringsnøgle via GET vars - default nøgle er id
		$sortkey = isset($_GET['sortkey']) && !empty($_GET['sortkey']) ? $_GET['sortkey'] : 'id';
		// Sætter sorteringsretning via GET vars - default er ASC
		$dir = isset($_GET['dir']) && !empty($_GET['dir']) ? $_GET['dir'] : 'ASC';
		// Sætter begrænsning via GET vars - default alle
		$limit = isset($_GET['limit']) && !empty($_GET['limit']) ? (int)$_GET['limit'] : false;
		// Sætter felter via GET vars - default er id og title
		$attributes = isset($_GET['attributes']) && !empty($_GET['attributes']) ? $_GET['attributes'] : 'id, title';

		$sql = "SELECT $attributes  
				FROM song 
				ORDER BY $sortkey $dir";
		$sql .= ($limit) ? " LIMIT " . $limit : "";
		return $this->db->query($sql);
	}

	/**
	 * Metode til at hente sang detaljer
	 * @param id (int) Sangens id
	 */
	public function details($id) {
		$params = array(
			'id' => array($id, PDO::PARAM_INT)
		);

		$sql = "SELECT s.title, s.content, a.name, s.artist_id 
				FROM song s 
				JOIN artist a 
				ON s.artist_id = a.id 
				WHERE s.id = :id";
		return $this->db->query($sql, $params, Db::RESULT_SINGLE);
	}

	/**
	 * Metode til at oprette sang med
	 */
	public function create() {
		$params = array(
			'title' => array($this->title, PDO::PARAM_STR),
			'content' => array($this->content, PDO::PARAM_STR),
			'artist_id' => array($this->artist_id, PDO::PARAM_INT)
		);

		$sql = "INSERT INTO song(title, content, artist_id) 
				VALUES(:title, :content, :artist_id)";
		$this->db->query($sql, $params);
		return $this->db->lastInsertId();
	}

	/**
	 * Metode til at opdatere en sang med
	 * Skal have sangens id med i form body
	 */
	public function update() {
		$params = array(
			'id' => array($this->id, PDO::PARAM_INT),
			'title' => array($this->title, PDO::PARAM_STR),
			'content' => array($this->content, PDO::PARAM_STR),
			'artist_id' => array($this->artist_id, PDO::PARAM_INT)
		);

		$sql = "UPDATE song SET 
				title = :title,
				content = :content,
				artist_id = :artist_id 
				WHERE id = :id";

		return $this->db->query($sql, $params);
	}

	/**
	 * Metode til at slette en sang med
	 * @param id (int) Sangens id
	 */
	public function delete($id) {
		$params = array(
			'id' => array($id, PDO::PARAM_INT)
		);
		
		$sql = "DELETE FROM song 
				WHERE id = :id";
		return $this->db->query($sql, $params);
	}
}