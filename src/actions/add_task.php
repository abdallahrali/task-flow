<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require "../db.php";

    try {
        $userId = $_SESSION['user_id'];
        $title = $_POST["title"];
        $description = $_POST["description"];

        $pdo->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)")->execute([$userId, $title, $description]);

    } catch (PDOException $e) {
        die("Could not add task: " . $e->getMessage());
    }
    
    header("Location: ../../tasks.php");
    exit();
}