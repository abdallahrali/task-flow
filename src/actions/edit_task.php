<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require "../db.php";

    try {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $description = $_POST["description"];

        $pdo->prepare("UPDATE tasks SET title = ?, description = ? WHERE id = ?")->execute([$title, $description, $id]);

    } catch (PDOException $e) {
        die("Could not update task: " . $e->getMessage());
    }

    header("Location: ../../tasks.php");
    exit();
}