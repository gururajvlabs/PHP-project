<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Cosmic Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gradient-to-br from-purple-600 via-indigo-500 to-blue-500 min-h-screen flex items-center justify-center">
    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-8 max-w-md w-full shadow-2xl text-center">
        <h2 class="text-4xl font-bold text-white mb-4 animate-pulse">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <p class="text-gray-200 mb-6">You've arrived in the cosmic hub. Explore the stars!</p>
        <a href="logout.php" class="inline-block bg-red-600 hover:bg-red-700 text-white p-3 rounded font-semibold transition-colors">Logout</a>
    </div>
</body>
</html>