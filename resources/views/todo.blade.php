<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Application</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    @include('include.header')

    <div class="container">
        <h1>Todo Application</h1>

        <form id="addTaskForm">
            <div class="form-group">
                <label for="task">Task</label>
                <input type="text" class="form-control" id="task" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>

        <h2>Tasks</h2>
        <ul id="taskList" class="list-group">
            <!-- Task items will be appended here -->
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('addTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const task = document.getElementById('task').value;
            const userId = {{ auth()->user()->id }};

            fetch('/todo/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'API_KEY': 'helloatg'
                },
                body: JSON.stringify({ task, user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 1) {
                    const li = document.createElement('li');
                    li.textContent = `${data.task.task} - ${data.task.status}`;
                    li.className = 'list-group-item';
                    document.getElementById('taskList').appendChild(li);
                } else {
                    alert(data.message);
                }
            });
        });
    </script>
</body>
</html>
