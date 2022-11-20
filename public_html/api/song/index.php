<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/incl/init.php";

/**
 * Hent liste af sange (GET)
 */
Route::add('/api/song/', function() {
	$song = new Song;
	$result = $song->list();
	echo Tools::jsonParser($result);
});

/**
 * Hent en sangs detaljer ud fra id (GET)
 */
Route::add('/api/song/([0-9]*)', function($id) {
	$song = new Song;
	$result = $song->details($id);
	echo Tools::jsonParser($result);
});

/**
 * Opret en ny sang (POST)
 */
Route::add('/api/song/', function() {
	$song = new Song;
	$song->title = isset($_POST['title']) && !empty($_POST['title']) ? $_POST['title'] : null;
	$song->content = isset($_POST['content']) && !empty($_POST['content']) ? $_POST['content'] : null;
	$song->artist_id = isset($_POST['artist_id']) && !empty($_POST['artist_id']) ? (int)$_POST['artist_id'] : null;

	if($song->title && $song->content && $song->artist_id) {
		echo $song->create();
	} else {
		echo "Kan ikke oprette sangen.";
	}
}, 'post');

/**
 * Opdater en sang ud fra id (PUT)
 */
Route::add('/api/song/', function() {
	$data = file_get_contents("php://input");
	parse_str($data, $parsed_data);

	$song = new Song;
	$song->id = isset($parsed_data['id']) && !empty($parsed_data['id']) ? (int)$parsed_data['id'] : null;
	$song->title = isset($parsed_data['title']) && !empty($parsed_data['title']) ? $parsed_data['title'] : null;
	$song->content = isset($parsed_data['content']) && !empty($parsed_data['content']) ? $parsed_data['content'] : null;
	$song->artist_id = isset($parsed_data['artist_id']) && !empty($parsed_data['artist_id']) ? (int)$parsed_data['artist_id'] : null;

	if($song->id && $song->title && $song->content && $song->artist_id) {
		echo $song->update();
	} else {
		echo false;
	}
}, 'put');

/**
 * Slet sang ud fra id (DELETE)
 */
Route::add('/api/song/([0-9]*)', function($id) {
	$song = new Song;
	echo $song->delete($id);
}, 'delete');

Route::run('/');
?>