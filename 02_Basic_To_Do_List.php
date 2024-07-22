<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> To-Do List </title>
    <style>
        body 
        {
            font-family: 'Times New Roman', Times, serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: #2c2c2c; 
        }

        h1 
        {
            color: #ffffff; 
        }

        form 
        {
            margin-bottom: 20px;
        }

        input[type="text"] 
        {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }

        button 
        {
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            background-color: #4a4a4a;
            color: white;
            cursor: pointer;
        }

        button[type="submit"]:hover 
        {
            background-color: #5a5a5a; 
        }

        ul 
        {
            list-style-type: none;
            padding: 0;
        }

        li 
        {
            background-color: #000000; 
            color: #ffffff;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        li form 
        {
            margin: 0;
        }

        li button 
        {
            background-color: #4a4a4a;
        }

        li button:hover 
        {
            background-color: #5a5a5a; 
        }
    </style>
</head>
<body>
    <h1>To-Do List</h1>
    <form method="POST" action="">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit" name="add">Add Task</button>
    </form>

    <?php

        $tasks = [];

        if (file_exists('tasks.txt')) 
        {
            $tasks = unserialize(file_get_contents('tasks.txt'));
        }

        if (isset($_POST['add'])) 
        {
            $task = htmlspecialchars($_POST['task']);
            $tasks[] = $task;
            file_put_contents('tasks.txt', serialize($tasks));
        }

        if (!empty($tasks)) 
        {
            echo '<ul>';
            foreach ($tasks as $index => $task) 
            {
                echo "<li>$task <form method='POST' style='display:inline;'>
                <button type='submit' name='delete' value='$index'>Delete</button></form></li>";
            }
            echo '</ul>';
        }

        if (isset($_POST['delete'])) 
        {
            $index = $_POST['delete'];
            unset($tasks[$index]);
            $tasks = array_values($tasks); 
            file_put_contents('tasks.txt', serialize($tasks));
            header("Location: ".$_SERVER['PHP_SELF']);
        }
   ?>
</body>
</html>
