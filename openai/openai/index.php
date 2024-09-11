<?php
include 'db.php';

// Fetch default values from system_setting table
$stmt_settings = $pdo->query("SELECT prompt, temperature FROM system_settings");
$settings = $stmt_settings->fetch(PDO::FETCH_ASSOC);

// Default values
$default_content = htmlspecialchars($settings['prompt'] ?? '');
$default_temperature = $settings['temperature'] ?? 0.2; // Assuming a default if not found in DB

// Fetch interactions
$stmt_interactions = $pdo->query("SELECT * FROM interactions ORDER BY created_at DESC");
$interactions = $stmt_interactions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OpenAI Project</title>
</head>
<body>
    <h1>Ask a Question</h1>
    <form action="handle_form.php" method="POST">
        <label for="question">Question:</label>
        <input type="text" id="question" name="question" required>
        <br>
        <label for="content">System Message (Content):</label>
        <input type="text" id="content" name="content" value="<?= $default_content ?>" required>
        <br>
        <label for="temperature">Temperature:</label>
        <input type="number" id="temperature" name="temperature" step="0.1" min="0" max="1" value="<?= $default_temperature ?>" required>
        <br>
        <button type="submit">Submit</button>
    </form>

    <h2>Previous Interactions</h2>
    <ul>
        <?php foreach ($interactions as $interaction): ?>
            <li>
                <strong>Question:</strong> <?= htmlspecialchars($interaction['question']) ?><br>
                <strong>Response:</strong> <?= htmlspecialchars($interaction['response']) ?><br>
                <em>Asked on <?= $interaction['created_at'] ?></em>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
