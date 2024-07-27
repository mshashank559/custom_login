<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #eee;
            display: grid;
            justify-items: center;
            align-items: center;
        }

        header {
            width: 100%;
            top: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 100px;
            background: palevioletred;
            color: #fff;
        }

        .logo {
            color: #fff;
            text-decoration: none;
            font-size: 1.5em;
        }

        .navbar {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .navbar li {
            display: inline;
            margin-right: 10px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        #main-holder {
            width: 80%; /* Adjust width for responsiveness */
            max-width: 1200px; /* Set max-width to prevent it from being too wide */
            padding: 20px;
            background-color: palevioletred;
            border-radius: 7px;
            box-shadow: 0px 0px 5px 2px black;
            margin: 10px auto; /* Center horizontally */
            display: grid;
            justify-items: center;
            align-items: start; /* Align items to the start of the container */
        }

        .insert-tasks, .tasks-list, .dropdown, .btn-container, .tasksoutput {
            width: 100%; /* Full width within the pink box */
            max-width: 600px; /* Optional: set max-width for larger screens */
        }

        .insert-tasks {
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .insert-tasks h2 {
            text-align: center;
        }

        .insert-tasks ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        .insert-tasks ul input, .insert-tasks ul textarea {
            width: calc(100% - 22px); /* Adjust width to account for padding */
            margin-bottom: 10px;
        }

        .insert-tasks ul li {
            margin-bottom: 10px;
        }

        .tasks-list {
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btnz {
            color: palevioletred;
            background-color: white;
            cursor: pointer;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-container .btnz:hover {
            background-color: palevioletred;
            color: white;
        }

        .insert-btn {
            position: fixed;
            right: 30px;
            bottom: 30px;
            width: 50px;
            height: 50px;
            border: 0;
            border-radius: 50%;
            background: var(--grey);
            color: black;
            font-weight: 200;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .insert-btn:hover {
            background: palevioletred;
            color: white;
        }

        .insert-btn:active {
            background: black;
            color: white;
        }

        @media only screen and (max-width: 798px) {
            header {
                font-size: 3rem;
                padding: 11px 4%;
            }

            #main-holder {
                width: 90%;
                padding: 10px;
            }

            .insert-btn {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .insert-tasks ul input, .insert-tasks ul textarea {
                width: 100%;
                font-size: 1rem;
            }

            .tasksoutput > div {
                grid-template-columns: 1fr;
            }

            .x-btn {
                font-size: 1rem;
                width: 50px;
                height: 50px;
            }
        }

        .x-btn {
            background-color: red;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 5px;
        }

        .error {
            color: red;
        }

        .dropdown {
            margin: 20px 0;
        }

        .dropdown select {
            padding: 10px;
        }

        .btn {
            padding: 10px;
            margin: 5px;
            cursor: pointer;
        }

        .insert-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .insert-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body onload="reloadTasks(); loadTasks(); displayTasks();">
    <header class="header">
        <a href="#" class="logo">Dashboard</a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <ul class="navbar">
            <li><a href="/index.html">Home</a></li>
            <li><a href="/tasks.html">All Tasks</a></li>
            <li><a href="/account.html">Account</a></li>
        </ul>
    </header>

    <main id="main-holder">
        <!-- Tasks Page -->
        <div id="tasks">
            <div class="insert-tasks" id="insertasks">
                <h2>New Task:</h2>
                <ul>
                    <li>Title:</li>
                    <li><input type="text" class="title" id="title"></li>
                </ul>
                <ul>
                    <li>Content:</li>
                    <li><textarea id="contents" class="contents"></textarea></li>
                </ul>
                <ul>
                    <li>Assigned to:</li>
                    <li><input type="text" class="assignee" id="assignee"></li>
                </ul>
                <div class="wrapper-a">
                    <input type="button" class="btn" value="Insert" onclick="insert()">
                    <input type="button" class="btn" value="Cancel" onclick="hideinsertasks()">
                </div>
                <div class="error">
                    <span id="error"></span>
                </div>
            </div>

            <div class="tasks-list">
                <span class="tasksoutput" id="tasksoutput"></span>
            </div>
            <div class="dropdown">
                <select id="stats" name="status" size="1" onchange="changeStatus(this.value)">
                    <option value="All">All</option>
                    <option value="Pending">Pending</option>
                    <option value="Fixed">Fixed</option>
                    <option value="Blocked">Blocked</option>
                    <option value="Assigned">Assigned</option>
                </select>
            </div>

            <input type="button" class="btn deletebtn" id="standart-rem" value="Delete all Tasks" onclick="clearTasks();">

            <!-- Insert Task Button -->
            <input type="button" value="+" class="insert-btn" id="insertbtn" onclick="showInsertTasks();">
        </div>

        <!-- Task Filtering -->
        <div id="tasks-filter">
            <div class="btn-container">
                <button class="btnz" onclick="getTask('all')">All</button>
                <button class="btnz" onclick="getTask('Pending')">Pending</button>
                <button class="btnz" onclick="getTask('Fixed')">Fixed</button>
                <button class="btnz" onclick="getTask('Blocked')">Blocked</button>
                <button class="btnz" onclick="getTask('Assigned')">Assigned</button>
            </div>

            <div class="tasks-list">
                <span class="tasksoutput" id="tasksoutputs"></span>
            </div>
        </div>
    </main>

    <script>
        let Tasks = [];
        let tasksCount = 0;

        const tasksoutput = document.getElementById("tasksoutput");
        const insertasks = document.getElementById("insertasks");
        const content = document.getElementById("contents");
        const title = document.getElementById("title");
        const assignee = document.getElementById("assignee");
        const error = document.getElementById("error");
        const stats = document.getElementById("stats");

        function start(){
            hideinsertasks();
            error.innerHTML = '';
        }

        function hideinsertasks(){
            insertasks.style.display = 'none';
            error.innerHTML = '';
            title.value = '';
            content.value = '';
            assignee.value = '';
        }

        function showInsertTasks(){
            insertasks.style.display = 'block';
        }

        function insert() {
            if((content.value !== '') && (title.value !== '') && (assignee.value !== '')) {
                let task = new Task(title.value, content.value, assignee.value, tasksCount + 1);
                Tasks.push(task);
                saveTasks();
                title.value = '';
                content.value = '';
                assignee.value = '';
                error.style.color = 'black';
                insertasks.style.display = 'none';
            } else {
                error.innerHTML = 'Invalid Task';
                error.style.color = 'red';
            }
        }

        let Task = function(title, content, assignee, id, status = 'Pending') {
            this.title = title;
            this.content = content;
            this.assignee = assignee;
            this.id = id;
            this.status = status;
            var date = new Date();
            this.d = date.getDate();
            this.m = date.getMonth() + 1;
            this.y = date.getFullYear();
            tasksCount += 1;
        }

        function saveTasks() {
            for(var i = 0; i < Tasks.length; i++) {
                Tasks[i].id = i + 1;
            }
            localStorage.setItem('Tasks', JSON.stringify(Tasks));
            loadTasks();
        }

        function loadTasks() {
            let loadedTask = JSON.parse(localStorage.getItem('Tasks'));
            displayTasks();
        }

        function displayTasks() {
            try {
                let loadedTasks = JSON.parse(localStorage.getItem("Tasks"));
                if (loadedTasks != null && loadedTasks.length > 0) {
                    let output = "";

                    output += "<div>";

                    for (var a = 0; a < loadedTasks.length; a++) {
                        output += "<h2 id='heading'>" + loadedTasks[a].status + "</h2>";
                        output += "<span>";
                        output +=
                            '<input class="x-btn" type="button" value="X" onclick="clearTask(' +
                            loadedTasks[a].id +
                            ');">';
                        output += "<h2>" + loadedTasks[a].title + "</h2>";
                        output += "<p>" + loadedTasks[a].content + "</p>";
                        output += "<p><strong>Assigned to:</strong> " + loadedTasks[a].assignee + "</p>";
                        output += "<br>" + '<i id="small">' + loadedTasks[a].d + "/" + loadedTasks[a].m + "/" + loadedTasks[a].y + "</i>";
                        output += "</span>";
                    }
                    output += "</div>";
                    tasksoutput.innerHTML = output;
                } else {
                    tasksoutput.innerHTML = "No Tasks";
                }
            } catch (error) {}
        }

        function clearTasks() {
            Tasks = [];
            localStorage.removeItem('Tasks');
            location.reload();
        }

        function clearTask(id) {
            var newid = id - 1;
            Tasks.splice(newid, 1);
            saveTasks();
        }

        function reloadTasks() {
            try {
                let loadtasksafresh = JSON.parse(localStorage.getItem("Tasks"));
                if (loadtasksafresh != null && loadtasksafresh.length > 0) {
                    tasksCount = loadtasksafresh.length;
                    for (var i = 0; i < loadtasksafresh.length; i++) {
                        Tasks.push(loadtasksafresh[i]);
                    }
                } else {
                    tasksCount = 0;
                }
            } catch (error) {}
        }

        function changeStatus(statuses){
            try {
                if (statuses.toLowerCase() === "all") {
                    displayTasks();
                    return;
                }
                const filteredTask = JSON.parse(localStorage.getItem("Tasks")).filter(task => task.status.toLowerCase() === statuses.toLowerCase());
                if (filteredTask != null && filteredTask.length > 0) {
                    let output = "";

                    output += "<div>";

                    for (var a = 0; a < filteredTask.length; a++) {
                        output += "<h2>" + filteredTask[a].status + "</h2>";
                        output += "<span>";
                        output +=
                            '<input class="x-btn" type="button" value="X" onclick="clearTask(' +
                            filteredTask[a].id +
                            ');">';
                        output += "<h2>" + filteredTask[a].title + "</h2>";
                        output += "<p>" + filteredTask[a].content + "</p>";
                        output += "<p><strong>Assigned to:</strong> " + filteredTask[a].assignee + "</p>";
                        output +=
                            "<br>" +
                            '<i id="small">' +
                            filteredTask[a].d +
                            "/" +
                            filteredTask[a].m +
                            "/" +
                            filteredTask[a].y +
                            "</i>";
                        output += "</span>";
                    }

                    output += "</div>";
                    tasksoutput.innerHTML = output;
                } else {
                    tasksoutput.innerHTML = "No Tasks";
                }
            } catch (error) {
                console.log(error.message);
            }
        }

        const tasksoutputs = document.getElementsByClassName("tasksoutput")[0];

        const getTask = (type = "all") => {
            const allTask = (type.toLowerCase() === "all") ?
                JSON.parse(localStorage.getItem("Tasks"))
                : JSON.parse(localStorage.getItem("Tasks")).filter(
                    (task) => task.status.toLowerCase() === type.toLowerCase()
                );
            toDom(allTask);
        }

        const toDom = (filteredTask = null) => {
            try {
                if (filteredTask != null && filteredTask.length > 0) {
                    let output = "";

                    output += "<div>";

                    for (var a = 0; a < filteredTask.length; a++) {
                        output += "<h2>" + filteredTask[a].status + "</h2>";
                        output += "<span>";
                        output +=
                            '<input class="x-btn" type="button" value="X" onclick="clearTask(' +
                            filteredTask[a].id +
                            ');">';
                        output += "<h2>" + filteredTask[a].title + "</h2>";
                        output += "<p>" + filteredTask[a].content + "</p>";
                        output += "<p><strong>Assigned to:</strong> " + filteredTask[a].assignee + "</p>";
                        output +=
                            "<br>" +
                            '<i id="small">' +
                            filteredTask[a].d +
                            "/" +
                            filteredTask[a].m +
                            "/" +
                            filteredTask[a].y +
                            "</i>";
                        output += "</span>";
                    }

                    output += "</div>";
                    tasksoutputs.innerHTML = output;
                } else {
                    tasksoutputs.innerHTML = "No Tasks";
                }
            } catch (error) {
                console.log(error.message);
            }
        }

        getTask();
    </script>
</body>
</html>
