<?php
include 'config.php';

if (!isset($_GET['playlistID'])) {
    echo json_encode(['error' => 'No playlist ID provided']);
    exit;
}

$playlistID = $_GET['playlistID'];


$auth = base64_encode("$spotifyClientID:$spotifyClientSecret");
$options = [
    "http" => [
        "header" => "Authorization: Basic $auth\r\nContent-Type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query(['grant_type' => 'client_credentials']),
    ],
];
$context = stream_context_create($options);
$response = file_get_contents('https://accounts.spotify.com/api/token', false, $context);
$tokenData = json_decode($response, true);
$accessToken = $tokenData['access_token'] ?? null;

if (!$accessToken) {
    echo json_encode(['error' => 'Failed to fetch access token']);
    exit;
}


$apiURL = "https://api.spotify.com/v1/playlists/$playlistID";
$apiOptions = [
    "http" => [
        "header" => "Authorization: Bearer $accessToken\r\n",
    ],
];
$apiContext = stream_context_create($apiOptions);
$apiResponse = file_get_contents($apiURL, false, $apiContext);
$playlistData = json_decode($apiResponse, true);

if (isset($playlistData['error'])) {
    echo json_encode(['error' => $playlistData['error']['message']]);
    exit;
}

// Format response
$playlist = [
    'id' => $playlistData['id'],
    'name' => $playlistData['name'],
    'tracks' => array_map(function ($item) {
        return [
            'name' => $item['track']['name'],
            'artists' => array_map(fn($artist) => $artist['name'], $item['track']['artists']),
        ];
    }, $playlistData['tracks']['items']),
];

echo json_encode($playlist);
