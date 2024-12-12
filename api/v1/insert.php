<?php

// Include your configuration file
include "../../config/config.php";

// Set appropriate headers for API response
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Initialize the response array
$response = [];

// Check if the request is a POST
// Check if the request is a POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the raw input and decode the JSON
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (!empty($inputData['name']) && !empty($inputData['desc']) && !empty($inputData['links'])) {
        // Sanitize inputs
        $name = htmlspecialchars(trim($inputData['name']));
        $desc = htmlspecialchars(trim($inputData['desc']));
        $links = $inputData['links'];

        // Check if the links are valid JSON
        if (is_array($links)) {
            // Instantiate the Config object
            $config = new Config();
            $isUserExist = $config->checkUserExists($name);
            if (!$isUserExist) {
                // Call the insertUser function to insert data into the database
                $res = $config->insertUser($name, $desc, $links);
                if ($res) {
                    http_response_code(201); // HTTP 201 - Created
                    $response['data'] = "User created successfully.";
                } else {
                    http_response_code(500); // HTTP 500 - Internal Server Error
                    $response['error'] = "User creation failed. Please try again.";
                }
            } else {
                http_response_code(409); // HTTP 409 - Conflict
                $response['error'] = "User with the same name already exists.";
            }
        } else {
            http_response_code(400); // HTTP 400 - Bad Request
            $response['error'] = "Invalid JSON format in 'links'.";
        }
    } else {
        http_response_code(400); // HTTP 400 - Bad Request
        $response['error'] = "Please fill in all required fields (name, description, links).";
    }
} else {
    http_response_code(405); // HTTP 405 - Method Not Allowed
    $response['error'] = "Only POST requests are allowed.";
}

// Output the response in JSON format
echo json_encode($response);
