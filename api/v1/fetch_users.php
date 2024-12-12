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
    // Instantiate the Config class
    $config = new Config();

    // Fetch users from the database
    $users = $config->fetchUsers();

    // Check if users were found
    if (!empty($users)) {
        http_response_code(200); // HTTP 200 OK
        $response['data'] = $users;
    } else {
        http_response_code(404); // HTTP 404 Not Found
        $response['error'] = "No users found.";
    }
} else {
    http_response_code(405); // HTTP 405 Method Not Allowed
    $response['error'] = "Only GET requests are allowed.";
}

// Output the response in JSON format
echo json_encode($response, JSON_UNESCAPED_SLASHES);
