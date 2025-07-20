<?php
require_once "config.php";
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
$userMessage = $input['message'] ?? '';

if (!$userMessage) {
  echo json_encode(['reply' => '❗Please enter a message.']);
  exit;
}

$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . GEMINI_API_KEY;
$postData = [
  "contents" => [
    ["parts" => [ ["text" => $userMessage] ]]
  ]
];

$options = [
  'http' => [
    'method'  => 'POST',
    'header'  => "Content-Type: application/json\r\n",
    'content' => json_encode($postData)
  ]
];
$response = file_get_contents($apiUrl, false, stream_context_create($options));
$data = json_decode($response, true);
$reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? "⚠️ No reply generated.";

echo json_encode(["reply" => $reply]);