<?php
session_start();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        // Load users
        $users = json_decode(file_get_contents('users.json'), true);
        // Check if username or email exists
        $exists = array_filter($users, fn($u) => $u['username'] === $username || $u['email'] === $email);
        if ($exists) {
            $error = 'Username or email already taken.';
        } else {
            // Add new user
            $users[] = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
            file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
            $success = 'Registration successful! <a href="index.php" class="text-blue-400 underline">Login here</a>.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cosmic Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gradient-to-br from-purple-600 via-indigo-500 to-blue-500 min-h-screen flex items-center justify-center">
    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-8 max-w-md w-full shadow-2xl transform hover:scale-105 transition-transform duration-300">
        <h2 class="text-3xl font-bold text-white text-center mb-6">Join the Cosmos</h2>
        <?php if ($error): ?>
            <p class="text-red-300 text-center mb-4"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="text-green-300 text-center mb-4"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <input type="text" name="username" placeholder="Username" class="w-full p-3 rounded bg-gray-800 bg-opacity-50 text-white border border-gray-600 focus:outline-none focus:border-blue-400" required>
            </div>
            <div>
                <input type="email" name="email" placeholder="Email" class="w-full p-3 rounded bg-gray-800 bg-opacity-50 text-white border border-gray-600 focus:outline-none focus:border-blue-400" required>
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" class="w-full p-3 rounded bg-gray-800 bg-opacity-50 text-white border border-gray-600 focus:outline-none focus:border-blue-400" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white p-3 rounded font-semibold transition-colors">Register</button>
        </form>
        <p class="text-white text-center mt-4">Already registered? <a href="index.php" class="text-blue-400 underline">Login</a></p>
    </div>
</body>
</html>