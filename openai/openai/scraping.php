<?php
function fetch_web_page($url) {
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Execute cURL request
    $html = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return null;
    }

    // Close cURL session
    curl_close($ch);

    return $html;
}

function parse_html($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $xpath = new DOMXPath($dom);
    $query = '//article'; // Adjust this query based on the structure of the target website
    $entries = $xpath->query($query);

    $data = [];
    foreach ($entries as $entry) {
        $title = $xpath->query('.//h2', $entry)->item(0)->nodeValue;
        $content = $xpath->query('.//p', $entry)->item(0)->nodeValue;
        $data[] = ['title' => $title, 'content' => $content];
    }

    return $data;
}

function fetch_and_parse($url) {
    $html = fetch_web_page($url);
    if ($html) {
        return parse_html($html);
    }
    return [];
}
?>
