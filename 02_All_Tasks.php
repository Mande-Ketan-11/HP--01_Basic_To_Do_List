<?php

    $tasksFile = '02_Tasks.txt';
    $tasks = array();

    if (file_exists($tasksFile)) 
    {
        $tasks = file($tasksFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $reversedtasks = array_reverse($tasks);
    } 
    else 
    {
        echo "Error: Tasks file not found.";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>All Tasks</title>
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
            .task-table 
            {
                max-width: 800px;
                margin: 50px auto;
                padding: 20px;
                background-color: #444;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                color: #ffffff;
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
            .back-button 
            {
                margin: 20px auto;
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
                color: blue;
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
        </style>
    </head>
    <body>
        <div class="navbar">
            <a href="02_Basic_To_Do_List.php">Home</a>
            <a href="02_All_Tasks.php">View All Tasks</a>
        </div>

        <div class="task-table">
            <h1 style="text-align: center; color: darkblue;">All Tasks</h1>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Task</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($reversedtasks as $index => $task) 
                        {
                            echo "<tr>";
                            echo "<td>" . ($index + 1) . "</td>";
                            echo "<td>" . htmlspecialchars($task) . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>

            <button class="back-button" onclick="window.location.href='02_Basic_To_Do_List.php'">Return</button>
        </div>
    </body>
</html>