<?php
include 'db.php';
include 'openai.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $question = isset($_POST['question']) ? $_POST['question'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $temperature = isset($_POST['temperature']) ? $_POST['temperature'] : '';



    try {
        // Get response from OpenAI
        $response = get_openai_response($question, $content, $temperature);
          // Output for debugging
    echo "Question: " . htmlspecialchars($question) . "<br>";
    echo "Response: " . htmlspecialchars($response) . "<br>";

        // Insert interaction into database
        $stmt = $pdo->prepare("INSERT INTO interactions (question, response) VALUES (:question, :response)");
        $stmt->execute(['question' => $question, 'response' => $response]);

        // Redirect back to the main page
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        die('Database error: ' . $e->getMessage());
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
?>
