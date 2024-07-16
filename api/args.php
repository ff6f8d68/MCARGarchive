<?php

// Define the file path to store ARG data
$file = '../data/args.json'; // Adjust the path as needed

// Check request method for GET (fetching data) or POST (creating data)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all ARGs
    $argsData = file_get_contents($file);
    header('Content-Type: application/json');
    echo $argsData;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle creating new ARG site
    $newSite = json_decode(file_get_contents('php://input'), true);

    // Validate input (you should add more robust validation as needed)
    if (!empty($newSite['name']) && !empty($newSite['icon']) && !empty($newSite['url'])) {
        // Read existing data
        $argsData = json_decode(file_get_contents($file), true);

        // Add new site
        $argsData[] = $newSite;

        // Write updated data back to file
        file_put_contents($file, json_encode($argsData, JSON_PRETTY_PRINT));

        // Respond with success
        echo json_encode(['message' => 'Site created successfully']);
    } else {
        http_response_code(400); // Bad request
        echo json_encode(['error' => 'Please fill out all fields.']);
    }
}
?>
