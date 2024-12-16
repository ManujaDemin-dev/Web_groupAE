document.getElementById('playlistForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const playlistLink = document.getElementById('playlistLink').value;

    // Extract the playlist ID from the URL
    const playlistID = playlistLink.split('/playlist/')[1]?.split('?')[0];
    if (!playlistID) {
        alert('Invalid Spotify Playlist Link');
        return;
    }

    // Fetch playlist details from the backend
    fetch(`getPlaylist.php?playlistID=${playlistID}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                displayPlaylist(data);
            }
        });
});

function displayPlaylist(data) {
    document.getElementById('playlistTitle').textContent = data.name;
    const songList = document.getElementById('songList');
    songList.innerHTML = '';

    data.tracks.forEach(track => {
        const trackElement = document.createElement('div');
        trackElement.textContent = `${track.name} by ${track.artists.join(', ')}`;
        songList.appendChild(trackElement);
    });

    // Set the Spotify Embed Player
    const spotifyPlayer = document.getElementById('spotifyPlayer');
    spotifyPlayer.src = `https://open.spotify.com/embed/playlist/${data.id}`;
}
