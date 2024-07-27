<?php
session_start();

// Generate a random number if it doesn't exist
if (!isset($_SESSION['randomNumber'])) {
    $_SESSION['randomNumber'] = rand(1, 100);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guess = intval($_POST['guess']);
    $randomNumber = $_SESSION['randomNumber'];

    if ($guess < $randomNumber) {
        $message = "Too low! Try again.";
    } elseif ($guess > $randomNumber) {
        $message = "Too high! Try again.";
    } else {
        $message = "Congratulations! You guessed the number $randomNumber. <a href='?reset=1'>Play again</a>";
        unset($_SESSION['randomNumber']);
    }
}

// Handle game reset
if (isset($_GET['reset'])) {
    unset($_SESSION['randomNumber']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Number Guessing Game</title>
</head>
<body>
    <h1>Number Guessing Game</h1>
    <p>Guess a number between 1 and 100.</p>

    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="guess">Your Guess:</label>
        <input type="number" id="guess" name="guess" min="1" max="100" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
