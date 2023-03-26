<?php
// Define the API endpoint URL
$endpoint = 'https://pokeapi.co/api/v2/pokemon/';

// Check if the form has been submitted
if (isset($_POST['search'])) {
    // Get the name of the Pokémon to search for
    $name = $_POST['name'];

    // Build the URL to search for Pokémon with names similar to the user's input
    $url = $endpoint . '?limit=1281';

    // Make a request to the API to retrieve a list of all Pokémon
    $response = file_get_contents($url);

    // Decode the JSON response into a PHP array
    $data = json_decode($response, true);

    // Filter the list of Pokémon to include only those with names that contain the user's input
    $filtered_pokemon = array_filter($data['results'], function($pokemon) use ($name) {
        return strpos($pokemon['name'], $name) !== false;
    });

    // Display a list of Pokémon with names similar to the user's input
    if (count($filtered_pokemon) > 0) {
    echo "<h2>Results:</h2>";
    echo "<ul>";
    foreach ($filtered_pokemon as $pokemon) {
        $pokemon_name = $pokemon['name'];
        $pokemon_url = $pokemon['url'];
        $pokemon_id = explode('/', rtrim($pokemon_url, '/'))[count(explode('/', rtrim($pokemon_url, '/'))) - 1];
        echo "<li><a href='?id=$pokemon_id'>$pokemon_name</a></li>";
    }
    echo "</ul>";
}

    else {
        echo "<p>No results found.</p>";
    }
}

// Check if a specific Pokémon has been selected
if (isset($_GET['id'])) {
    // Get the ID of the selected Pokémon
    $id = $_GET['id'];

    // Build the URL for the specific Pokémon
    $url = $endpoint . $id;

    // Make a request to the API
    $response = file_get_contents($url);

    // Decode the JSON response into a PHP array
    $data = json_decode($response, true);

    // Extract the name, ID, and types of the Pokémon from the response
    $pokemon_name = $data['name'];
    $pokemon_id = $data['id'];
    $pokemon_types = array_column($data['types'], 'type');

    // Display the name, ID, and types of the Pokémon
    echo "<h1>$pokemon_name</h1>";
    echo "<p>ID: $pokemon_id</p>";
    echo "<p>Type(s): ";
    foreach ($pokemon_types as $type) {
        echo $type['name'] . ' ';
    }
    echo "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Search</title>
</head>
<body>
    <h1>Pokémon Search</h1>
    <form method="post">
        <label for="name">Enter a Pokémon name:</label>
        <input type="text" id="name" name="name">
        <input type="submit" name="search" value="Search">
    </form>
</body>
</html>
