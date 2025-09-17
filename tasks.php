<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require "src/db.php";

$userId = $_SESSION['user_id'];
$filter = $_GET['filter'] ?? 'all'; 

$sql = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$userId];

switch ($filter) {
    case 'pending':
        $sql .= " AND is_completed = ?";
        $params[] = 0;
        break;
    case 'completed':
        $sql .= " AND is_completed = ?";
        $params[] = 1;
        break;
}

$sql .= " ORDER BY created_at DESC";

try {
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not retrieve tasks: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>To-Do App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="public/styles.css"/>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-light-subtle">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="public/icon.png" width="45px" alt="">
                <h3>TaskFlow</h3>
            </a>
            
              <?php if (isset($_SESSION['username'])): ?>
                <span class="me-2 username-scroll-container">Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</span>
              <?php endif; ?> 
            <a class="logout-btn" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
      <div class="row g-4">
        <div class="col-lg-5">
          <div class="card shadow-sm">
            <div class="card-header text-white"><h5 class="mt-2">Add New Task</h5></div>
            <div class="card-body">
              <form action="src/actions/add_task.php" method="POST">
                <div class="mb-3">
                  <label for="taskTitle" class="form-label fw-medium">Task Title</label>
                  <input
                    type="text"
                    name="title"
                    id="taskTitle"
                    class="form-control"
                    placeholder="Enter task title"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="taskDescription" class="form-label fw-medium">Task Description</label>
                  <textarea
                    name="description"
                    id="taskDescription"
                    placeholder="Enter task description"
                    class="form-control"
                    rows="3"
                  ></textarea>
                </div>
                <button
                  class="btn add-task-btn w-100"
                  type="submit"
                  name="addTask"
                >
                  Add Task
                </button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="card shadow-sm">
            <div class="card-header bg-light"><h5 class="mt-2">Task List</h5></div>
            <div class="card-body">
              <div class="filters mb-3">
                <a href="tasks.php?filter=all" class="btn btn-sm all-tasks-btn <?= ($filter == 'all') ? 'active-filter' : '' ?>">
                    All Tasks
                </a>
                <a href="tasks.php?filter=pending" class="btn btn-sm pending-btn <?= ($filter == 'pending') ? 'active-filter' : '' ?>">
                    Pending
                </a>
                <a href="tasks.php?filter=completed" class="btn btn-sm completed-btn <?= ($filter == 'completed') ? 'active-filter' : '' ?>">
                    Completed
                </a>
              </div>

              <?php foreach ($tasks as $task): ?>
                  <div class="task-card card mb-3 <?= $task['is_completed'] ? 'task-complete' : '' ?>">
                      <div class="card-body d-flex align-items-center p-2">
                          <form action="src/actions/complete_task.php" method="POST" class="me-3">
                              <input type="hidden" name="id" value="<?= $task['id'] ?>">
                              <input type="hidden" name="is_completed" value="<?= $task['is_completed'] ?>">
                              <input 
                                  class="form-check-input" 
                                  type="checkbox" 
                                  <?= $task['is_completed'] ? 'checked' : '' ?>
                                  onchange="this.form.submit()"
                                  title="Mark as <?= $task['is_completed'] ? 'pending' : 'complete' ?>"
                                  style="transform: scale(1.4);">
                          </form>
                          <div class="flex-grow-1">
                              <h6 class="card-title mb-0"><?= htmlspecialchars($task["title"]) ?></h6>
                              <p class="card-text small text-muted mb-0"><?= htmlspecialchars($task["description"]) ?></p>
                          </div>
                          <div class="task-actions ms-auto">
                              <button class="btn btn-warning btn-sm edit-btn"
                                      data-id="<?= $task["id"] ?>"
                                      data-title="<?= htmlspecialchars($task["title"]) ?>"
                                      data-description="<?= htmlspecialchars($task["description"]) ?>">
                                  Edit
                              </button>
                              <form action="src/actions/delete_task.php" method="POST" class="d-inline">
                                  <input type="hidden" name="id" value="<?= $task["id"] ?>">
                                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>
                          </div>
                      </div>
                  </div>
              <?php endforeach; ?>

              <?php if (empty($tasks)): ?>
                  <div class="text-center p-4 border rounded bg-light">
                      <p class="mb-0">No tasks found!</p>
                  </div>
              <?php endif; ?>
              </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "src/templates/edit-modal.html";?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="public/app.js"></script>
  </body>
</html>