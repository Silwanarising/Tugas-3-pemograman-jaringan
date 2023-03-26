<?php
// Set API Key and API endpoint
$api_key = 'AIzaSyC70CTPaOhkEE1Y4Gm4MMWwqqv4dIWG8JU';
$api_endpoint = 'https://www.googleapis.com/youtube/v3/search';

// Set search parameters
$search_params = array(
    'q' => '',
    'type' => 'video',
    'order' => 'viewCount',
    'videoDefinition' => 'high',
    'videoEmbeddable' => 'true',
    'maxResults' => 50,
    'key' => $api_key
);

// Build query string
$query_string = http_build_query($search_params);

// Make API request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_endpoint . '?' . $query_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decode API response
$data = json_decode($response);

// Filter videos with view count below a certain threshold
$videos = array_filter($data->items, function($item) {
    return $item->statistics->viewCount < 1000;
});

// Select a random video from the filtered list
$random_video = $videos[array_rand($videos)];

// Build URL for selected video
$video_url = 'https://www.youtube.com/watch?v=' . $random_video->id->videoId;

// Output recommended video URL
echo $video_url;
?>
