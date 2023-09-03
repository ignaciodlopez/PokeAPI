<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeAPI Viewer</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Pokémon API Viewer</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- Class 'yellow-background' for div -->
                <div class="yellow-background">
                    <form method="post">
                        <div class="mb-3">
                            <label for="pokemon-name" class="form-label">Pokémon Name:</label>
                            <input type="text" name="pokemon-name" id="pokemon-name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <div id="pokemon-details" class="mt-3">
                        <?php
                        // Check if the form has been submitted using POST
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Check if the 'pokemon-name' field is set in the POST data
                            if (isset($_POST['pokemon-name'])) {
                                // Get the user-entered Pokémon name and convert it to lowercase
                                $pokemonName = strtolower($_POST['pokemon-name']);
                                // Construct the API URL
                                $apiUrl = "https://pokeapi.co/api/v2/pokemon/{$pokemonName}";
                                // Make a request to the PokeAPI and suppress errors with '@'
                                $response = @file_get_contents($apiUrl);

                                // Check if the response is false, indicating a failed request
                                if ($response === false) {
                                    // Display an error message
                                    echo '<div class="alert alert-danger" role="alert">Pokemon not found.</div>';
                                } else {
                                    // Attempt to decode the JSON response
                                    $data = json_decode($response);

                                    // Check if the JSON decoding was successful
                                    if ($data) {
                                        // Convert height from decimeters to meters
                                        $heightInMeters = $data->height / 10;
                                        // Convert weight from hectograms to kilograms
                                        $weightInKilograms = $data->weight / 10;

                                        // Display Pokémon details in meters and kilograms
                                        echo '<h2 class="mt-3">Details of ' . ucfirst($data->name) . '</h2>';
                                        echo '<img src="' . $data->sprites->front_default . '" alt="' . ucfirst($data->name) . '" class="img-fluid">';
                                        echo '<p><strong>Height:</strong> ' . $heightInMeters . ' meters</p>';
                                        echo '<p><strong>Weight:</strong> ' . $weightInKilograms . ' kilograms</p>';
                                    } else {
                                        // Display an error message for invalid JSON response
                                        echo '<div class="alert alert-danger" role="alert">Invalid response from PokeAPI.</div>';
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <div style="text-align: center;">
        <a href="https://github.com/ignaciodlopez" target="_blank">Ignacio D. López</a>
    </div>
</footer>
</html>