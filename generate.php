<?php
$apiKey = "AIzaSyB7WB_ZPWoAQkdljRlO8z2l80vIPRVXJks"; // Replace with your real Gemini API key

$data = json_decode(file_get_contents("php://input"), true);
$contractType = $data["contractType"] ?? "contract";
$prompt = $data["prompt"] ?? "Generate a contract.";

$fullPrompt = "Generate a professional $contractType based on the following details:\n" . $prompt;

$headers = [
    'Content-Type: application/json'
];

$payload = json_encode([
    "contents" => [
        [
            "parts" => [
                ["text" => $fullPrompt]
            ]
        ]
    ]
]);

$url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key=$apiKey";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo "Request Error: " . curl_error($ch);
    exit;
}
curl_close($ch);

$result = json_decode($response, true);

// Output Gemini's response
if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    echo $result['candidates'][0]['content']['parts'][0]['text'];
} else {
    echo "❌ Gemini Error: " . ($result['error']['message'] ?? "Unknown error.");
}
?>