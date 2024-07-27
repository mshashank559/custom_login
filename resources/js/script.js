$(document).ready(function() {
    // Add Task
    $('#add-task-form').on('submit', function(e) {
        e.preventDefault();
        const task = $('#task').val();

        $.ajax({
            url: '{{ route("tasks.add") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { task: task },
            success: function(response) {
                if (response.status === 1) {
                    $('#task-list').append(`<li class="list-group-item" data-task-id="${response.task.id}">
                        <span class="task-text">${response.task.task}</span>
                        (<span class="task-status">${response.task.status}</span>)
                        <button class="btn btn-danger btn-sm float-right delete-task" data-task-id="${response.task.id}">Delete</button>
                        <button class="btn btn-secondary btn-sm float-right update-task-status" data-task-id="${response.task.id}">
                            Mark as ${response.task.status === 'pending' ? 'Done' : 'Pending'}
                        </button>
                    </li>`);
                    $('#task').val('');
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Update Task Status
    $(document).on('click', '.update-task-status', function() {
        const taskId = $(this).data('task-id');
        const newStatus = $(this).siblings('.task-status').text() === 'pending' ? 'done' : 'pending';

        $.ajax({
            url: '/tasks/status',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { task_id: taskId, status: newStatus },
            success: function(response) {
                if (response.status === 1) {
                    $(`li[data-task-id="${taskId}"] .task-status`).text(newStatus);
                    $(`li[data-task-id="${taskId}"] .update-task-status`).text(`Mark as ${newStatus === 'pending' ? 'Done' : 'Pending'}`);
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Delete Task
    $(document).on('click', '.delete-task', function() {
        const taskId = $(this).data('task-id');

        $.ajax({
            url: `/tasks/${taskId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 1) {
                    $(`li[data-task-id="${taskId}"]`).remove();
                } else {
                    alert(response.message);
                }
                function redirectToDashboard() {
                    if (window.DashboardUrl) {
                        window.location.href = window.DashboardUrl;
                    }
                }
                
            }
        });
    });
});
