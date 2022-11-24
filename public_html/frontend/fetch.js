const fetchSongs = () => {
	fetch('http://songbook080122.local/api/song')
		.then(response => response.json())
		.then(data => console.log(data))
}

fetchSongs();