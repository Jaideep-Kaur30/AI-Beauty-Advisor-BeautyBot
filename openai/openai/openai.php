<?php
function get_openai_response($question) {
    $api_key = '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';  // Replace with your OpenAI API key
    $url = 'https://api.openai.com/v1/chat/completions';
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a beauty advisor.'
            ],
            [
                'role' => 'user',
                'content' => $question
            ]
            ],
            "temperature"=> 0

    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data)
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return null;
    } else {
        $response_data = json_decode($response, true);
        curl_close($ch);
        return $response_data['choices'][0]['message']['content'];
    }
}
?>
