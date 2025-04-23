<?php
session_start();
require_once 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $username = trim($_POST['username'] ?? '');
   $password = trim($_POST['password'] ?? '');

   // Input validation
   if (empty($username) || empty($password)) {
      $error = 'All fields are required.';
   } else {
      // Fetch user from database
      try {
         $stmt = $db->prepare('SELECT username, password FROM users WHERE username = :username');
         $stmt->execute(['username' => $username]);
         $user = $stmt->fetch(PDO::FETCH_ASSOC);

         if ($user && password_verify($password, $user['password'])) {
            // Authentication successful
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['user'] = $user['username'];
            header('Location: welcome.php');
            exit;
         } else {
            $error = 'Invalid username or password.';
         }
      } catch (PDOException $e) {
         $error = 'An error occurred. Please try again later.';
      }
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <script src="https://cdn.tailwindcss.com"></script>
   <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gradient-to-br from-purple-600 via-indigo-500 to-blue-500 min-h-screen flex items-center justify-center">
   <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-xl p-8 max-w-md w-full shadow-2xl transform hover:scale-105 transition-transform duration-300">
      <h2 class="text-3xl font-bold text-white text-center mb-6">Login to Your Account</h2>
      <?php if ($error): ?>
         <p class="text-red-300 text-center mb-4"><?php echo $error; ?></p>
      <?php endif; ?>
      <form method="POST" class="space-y-4">
         <div>
            <input type="text" name="username" placeholder="Username" class="w-full p-3 rounded bg-gray-800 bg-opacity-50 text-white border border-gray-600 focus:outline-none focus:border-blue-400" required>
         </div>
         <div>
            <input type="password" name="password" placeholder="Password" class="w-full p-3 rounded bg-gray-800 bg-opacity-50 text-white border border-gray-600 focus:outline-none focus:border-blue-400" required>
         </div>
         <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white p-3 rounded font-semibold transition-colors">Login</button>
      </form>
      <p class="text-white text-center mt-4">New here? <a href="register.php" class="text-blue-400 underline">Register</a></p>
   </div>
</body>

</html>