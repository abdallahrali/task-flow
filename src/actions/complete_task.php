<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require "../db.php";

    try {
        $id = $_POST['id'];
        $new_status = $_POST['is_completed'] ? 0 : 1; 

        $pdo->prepare("UPDATE tasks SET is_completed = ? WHERE id = ?")->execute([$new_status, $id]);

    } catch (PDOException $e) {
        die("Could not update task status: " . $e->getMessage());
    }

    header("Location: ../../tasks.php");
    exit();
}