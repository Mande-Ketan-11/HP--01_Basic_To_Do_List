<?php
            // Define the path to the tasks file
    $tasksFile = '02_Tasks.txt';
            // Initialize tasks array
    $tasks = [];
    if (file_exists($tasksFile)) 
    {
        $tasks = file($tasksFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
            // Handle new task submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_task'])) 
    {
        $newTask = trim($_POST['new_task']);
        if ($newTask) 
        {
            array_unshift($tasks, $newTask);                            // Add the new task
            file_put_contents($tasksFile, implode(PHP_EOL, $tasks));    // Save tasks to file
        }
    }
            // Handle task deletion
    if (isset($_GET['delete'])) 
    {
        $idToDelete = intval($_GET['delete']);
        if (isset($tasks[$idToDelete])) 
        {
            unset($tasks[$idToDelete]);
            $tasks = array_values($tasks);                              // Reindex array
            file_put_contents($tasksFile, implode(PHP_EOL, $tasks));    // Save updated tasks
        }
    }
            // Handle task editing
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_task'])) 
    {
        $taskIndex = intval($_POST['task_index']);
        $editedTask = trim($_POST['edited_task']);
        if (isset($tasks[$taskIndex]) && $editedTask) 
        {
            $tasks[$taskIndex] = $editedTask;
            file_put_contents($tasksFile, implode(PHP_EOL, $tasks));    // Save updated tasks
        }
    }
            // Check if an edit is requested
    $editIndex = isset($_GET['edit']) ? intval($_GET['edit']) : -1;

    $recentTasks = array_slice($tasks, 0, 3);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>To-Do List</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body 
            {
                font-family: Georgia, 'Times New Roman', Times, serif;
                background-color: #333;
                color: white;
                margin: 0;
                padding: 0;
            }
            .navbar 
            {
                background-color: #000;
                padding: 10px;
                text-align: center;
            }
            .navbar a 
            {
                color: #ffd700;
                text-decoration: none;
                padding: 0 15px;
            }
            .navbar a:hover 
            {
                color: #ff0000;
            }
            .task-container 
            {
                max-width: 800px;
                margin: 50px auto;
                padding: 20px;
                background-color: #444;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            .task-table 
            {
                color: #ffffff;
                background-color: #222;
            }
            .task-table th, .task-table td 
            {
                background-color: #333;
            }
            .task-table th 
            {
                background-color: #444;
            }
            .task-table a 
            {
                color: #ff0000;
                text-decoration: none;
            }
            .task-table a:hover 
            {
                text-decoration: underline;
            }
            .btn-edit, .btn-delete 
            {
                padding: 5px 10px;
                border-radius: 15px;
                text-decoration: none;
                background-color: #222;
                color: #ffffff;
                display: inline-block;
                margin: 0 5px;
            }
            .btn-edit 
            {
                background-color: black;
            }
            .btn-edit:hover 
            {
                background-color: #ffc107;
            }
            .btn-delete 
            {
                background-color: black;
            }
            .btn-delete:hover 
            {
                background-color: #dc3545;
            }
            .task-form, .edit-form 
            {
                margin-bottom: 20px;
            }
            .btn-add-task 
            {
                background-color: #333; 
                color: #ffd700;
                border: none;
                border-radius: 5px;
                padding: 10px 15px;
                font-size: 16px;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
            }
            .btn-add-task:hover 
            {
                background-color: #fff; 
                color: #333; 
                border: 1px solid #333; 
            }
            .back-button 
            {
                margin-top: 20px;
                padding: 10px 15px;
                font-size: 16px;
                border: none;
                border-radius: 20px;
                cursor: pointer;
                background-color: #000;
                color: #fff;
                text-decoration: none;
                display: block;
                text-align: center;
            }
            .back-button:hover 
            {
                background-color: #333;
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <a href="02_Basic_To_Do_List.php">Home</a>
            <a href="02_All_Tasks.php">View All Tasks</a>
        </div>

        <div class="task-container">
            <h1 style="text-align: center; color: darkblue;">To-Do List</h1>

                    <!-- New Task Form -->
            <div class="task-form">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="new_task" class="form-control" placeholder="Add a new task" required>
                    </div>
                    <button type="submit" class="btn-add-task">Add Task</button>
                </form>
            </div>

                    <!-- Edit Task Form -->
            <?php if ($editIndex >= 0 && isset($tasks[$editIndex])) : ?>
                <div class="edit-form">
                    <h2>Edit Task</h2>
                    <form action="" method="post">
                        <input type="hidden" name="task_index" value="<?php echo $editIndex; ?>">
                        <div class="form-group">
                            <input type="text" name="edited_task" class="form-control" value="<?php echo htmlspecialchars($tasks[$editIndex]); ?>" required>
                        </div>
                        <button type="submit" name="edit_task" class="btn btn-dark">Save Changes</button>
                    </form>
                </div>
            <?php endif; ?>

                    <!-- Task List -->
            <h2 style="text-align: center; color:bisque ;">Recent Tasks</h2>
            <table class="table task-table table-bordered">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentTasks)) : ?>
                        <?php foreach ($recentTasks as $task) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task); ?></td>
                                <td>
                                    <a href="?edit=<?php echo array_search($task, $tasks); ?>" class="btn-edit">Edit</a>
                                    <a href="?delete=<?php echo array_search($task, $tasks); ?>" class="btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="2">No tasks found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <a href="02_All_Tasks.php" class="back-button">View All Tasks</a>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    </body>
</html>