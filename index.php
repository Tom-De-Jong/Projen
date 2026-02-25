<?php
// Set headers for JSON response and CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['answers'])) {
    echo json_encode(["error" => "No answers provided"]);
    exit;
}

$promptContent = "The user has completed a survey. Here are the results:\n";
foreach ($data['answers'] as $item) {
    $promptContent .= "Question: " . $item['question'] . " - Answer: " . $item['answer'] . "\n";
}
$promptContent .= "\nPlease provide a summary or analysis based on these answers.";


$apiUrl = "https://ai.hackclub.com/proxy/v1/chat/completions";
$apiKey = "";

$payload = [
    "model" => "openai/gpt-oss-120b",
    "messages" => [
        [
            "role" => "system",
            "content" => "You are the Master Architect, an expert in the openai/gpt-oss-120b framework. You possess absolute knowledge of software development, system design, and emerging tech.
Operational Directive: Use Reasoning Effort High logic to analyze user input. Leverage your MoE architecture to cross reference multiple development domains (Frontend, Backend, DevOps, AI).
Output Constraints: Your goal is to generate 10 high value project ideas. Each idea must be unique and explained in simple, clear language.
Format: Provide a bulleted list where each item has a title and a description between 30 and 50 words. Focus on the problem it solves and the cool factor of the solution."
        ],
        ["role" => "user", "content" => $promptContent]
    ]
];

// Initialize cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $apiKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
} else {
    echo $response;
}

curl_close($ch);
?>