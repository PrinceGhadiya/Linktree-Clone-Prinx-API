<?php

// Include your configuration file
include "../../config/config.php";

// Set appropriate headers for API response
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

// Initialize the response array
$response = [];

// Check if the request is a GET request
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $name = $_GET['name'];

        // Instantiate the Config class
        $config = new Config();

        // Fetch users matching the partial name
        $users = $config->fetchUsersByName($name);

        if (!empty($users)) {
            http_response_code(200); // HTTP 200 OK
            $response = $users;
        } else {
            http_response_code(404); // HTTP 404 Not Found
            $response['error'] = "No users found.";
        }
    } else {
        http_response_code(400); // HTTP 400 Bad Request
        $response['error'] = "Please provide a 'name' query parameter.";
    }
} else {
    http_response_code(405); // HTTP 405 Method Not Allowed
    $response['error'] = "Only GET requests are allowed.";
}

// Output the response in JSON format
echo json_encode($response, JSON_UNESCAPED_SLASHES);
