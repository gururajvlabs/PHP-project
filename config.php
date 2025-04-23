<?php
try {
   $db = new PDO('pgsql:host=localhost;dbname=pirate_app', 'postgres', '12345');
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   die('Database connection failed: ' . $e->getMessage());
}
