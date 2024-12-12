<?php

// Include your configuration file
include "../../config/config.php";

// Set appropriate headers for API response
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");

// Initialize the response array
$response = [];

// Check if the request is a DELETE request
if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Get the input data (for DELETE, inputs typically come via the query string or request body)
    parse_str(file_get_contents("php://input"), $input);

    if (isset($input['id']) && !empty($input['id'])) {
        $id = intval($input['id']);

        // Instantiate the Config class
        $config = new Config();

        // Call the deleteUser method to delete the user by ID
        $result = $config->deleteUser($id);

        if ($result === false) {
            // User not found or failed to delete
            http_response_code(404); // HTTP 404 Not Found
            $response['error'] = "User with ID {$id} not found.";
        } else {
            // Successful deletion
            http_response_code(200); // HTTP 200 OK
            $response['message'] = "User deleted successfully.";
        }
    } else {
        http_response_code(400); // HTTP 400 Bad Request
        $response['error'] = "Please provide a valid user ID.";
    }
} else {
    http_response_code(405); // HTTP 405 Method Not Allowed
    $response['error'] = "Only DELETE requests are allowed.";
}

// Output the response in JSON format
echo json_encode($response, JSON_UNESCAPED_SLASHES);
