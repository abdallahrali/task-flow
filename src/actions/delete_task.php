<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require "../db.php";

    try {
        $id = $_POST["id"];

        $pdo->prepare("DELETE FROM tasks WHERE id = ?")->execute([$id]);

    } catch (PDOException $e) {
        die("Could not delete task: " . $e->getMessage());
    }

    header("Location: ../../tasks.php");
    exit();
}