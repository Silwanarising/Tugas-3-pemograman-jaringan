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
    echo "<div class='container'>";
    echo "<h2 class='my-3'>Results:</h2>";
    echo "<div class='list-group'>";
    foreach ($filtered_pokemon as $pokemon) {
        $pokemon_name = $pokemon['name'];
        $pokemon_url = $pokemon['url'];
        $pokemon_id = explode('/', rtrim($pokemon_url, '/'))[count(explode('/', rtrim($pokemon_url, '/'))) - 1];
        echo "<a href='?id=$pokemon_id' class='list-group-item list-group-item-action'>$pokemon_name</a>";
    }
    echo "</div>";
    echo "</div>";
}

    else {
        echo "<div class='container'>";
        echo "<p class='my-3'>No results found.</p>";
        echo "</div>";
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
    $pokemon_image_front = $data['sprites']['front_default'];
    $pokemon_image_back = $data['sprites']['back_default'];
    $pokemon_image_front_shiny = $data['sprites']['front_shiny'];
    $pokemon_image_back_shiny = $data['sprites']['back_shiny'];

    // Display the name, ID, and types of the Pokémon
    echo "<div class='container'>";
    echo "<h1 class='my-3'>$pokemon_name</h1>";
    echo "<div class='card'>";
    echo "<div class='card-body'>";
    echo "<img class='img-thumbnail' src='$pokemon_image_front' alt='pokemon name'>";
    echo "<img class='img-thumbnail' src='$pokemon_image_back' alt='pokemon name'>";
    echo "<img class='img-thumbnail' src='$pokemon_image_front_shiny' alt='pokemon name'>";
    echo "<img class='img-thumbnail' src='$pokemon_image_back_shiny' alt='pokemon name'>";
    echo "<p class='card-text'>ID: $pokemon_id</p>";
    echo "<p class='card-text'>Type(s): ";
    foreach ($pokemon_types as $type) {
        echo $type['name'] . ' ';
    }
    echo "</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Search</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">Pokémon Search</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form method="post" class="form-inline justify-content-center">
                    <div class="form-group">
                        <label for="name" class="mr-2">Enter a Pokémon name:</label>
                        <input type="text" id="name" name="name" class="form-control mr-2">
                    </div>
                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
