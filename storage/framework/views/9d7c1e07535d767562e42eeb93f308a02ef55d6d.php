<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{background:#f6f8fa}
        .task-completed{ text-decoration:line-through; opacity:.6; transition:.2s}
        #taskList li+li{margin-top:.5rem}
    </style>
</head>
<body class="py-5">

<div class="container-sm">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-check2-square me-2"></i>Task Manager</h4>
                </div>

                <div class="card-body">

                    
                    <div class="input-group mb-3">
                        <input id="taskInput" type="text" class="form-control" placeholder="Enter a new task">
                        <button id="addTaskBtn" class="btn btn-success">
                            Add Task
                        </button>
                        <button id="showAllBtn" class="btn btn-outline-secondary">Show All</button>
                    </div>

                    
                    <ul id="taskList" class="list-unstyled mb-0"></ul>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delete task?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete:
            <strong id="taskNamePreview"></strong> ?
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
        </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const csrf = $('meta[name="csrf-token"]').attr('content');
    let deleteId = null;   // remembers which task we’re deleting

    /* -------- helpers -------- */
    const renderTask = t => `
      <li class="d-flex align-items-center" data-id="${t.id}" data-name="${t.name}">
        <input class="form-check-input me-2 complete-task" type="checkbox" ${t.is_completed ? 'checked':''}>
        <span class="flex-grow-1 ${t.is_completed ? 'task-completed':''}">${t.name}</span>
        <button class="btn btn-sm btn-outline-danger delete-task">
            <i class="bi bi-trash"></i>
        </button>
      </li>`;

    const loadTasks = () =>
        $.get('/tasks/all', tasks => $('#taskList').html(tasks.map(renderTask).join('')));

    /* -------- init -------- */
    $(function () {
        loadTasks();

        /* add task */
        $('#addTaskBtn').click(() => {
            const name = $('#taskInput').val().trim();
            if (!name) return;
            $.post({
              url:'/tasks',
              headers:{'X-CSRF-TOKEN':csrf},
              data:{name}
            }).done(task=>{
                $('#taskList').prepend(renderTask(task));
                $('#taskInput').val('').focus();
            }).fail(()=>{
                alert('Task already exists or invalid input.');
            });
        });

        /* toggle complete */
        $(document).on('click','.complete-task',function(){
            const id = $(this).closest('li').data('id');
            $.post(`/tasks/${id}/toggle`, {_token:csrf}, loadTasks);
        });

        /* open delete modal */
        $(document).on('click','.delete-task',function(){
            const li   = $(this).closest('li');
            deleteId   = li.data('id');
            $('#taskNamePreview').text(li.data('name'));
            new bootstrap.Modal('#deleteModal').show();
        });

        /* confirm delete */
        $('#confirmDeleteBtn').click(() => {
            if (!deleteId) return;
            $.ajax({
                url:`/tasks/${deleteId}`,
                method:'DELETE',
                headers:{'X-CSRF-TOKEN':csrf}
            }).done(()=>{
                deleteId=null;
                loadTasks();
                bootstrap.Modal.getInstance('#deleteModal').hide();
            });
        });

        $('#showAllBtn').click(loadTasks);
    });
</script>
</body>
</html>
<?php /**PATH /home/u476265036/domains/darkturquoise-gorilla-686185.hostingersite.com/public_html/resources/views/tasks/index.blade.php ENDPATH**/ ?>