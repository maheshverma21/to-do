<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>To-Do List with Add Button Above Table</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f2f5;
        margin: 0;
        padding: 40px 20px;
        color: #333;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #444;
    }

    .add-btn {
        display: block;
        margin-bottom: 5px;
        margin-left: 953px;
        background: #667eea;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 6px 12px rgba(102, 126, 234, 0.6);
        transition: background 0.3s ease;
    }

    .add-btn:hover {
        background: #5563c1;
    }

    table {
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    thead {
        background: #667eea;
        color: white;
    }

    th, td {
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        vertical-align: middle;
    }

    tbody tr:hover {
        background: #f7f9ff;
    }

    .task-title {
        font-size: 16px;
    }

    .done {
        text-decoration: line-through;
        color: #999;
        font-style: italic;
    }

    /* Modal styles */
    .modal-bg {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-bg.active {
        display: flex;
    }

    .modal {
        background: white;
        padding: 30px 25px;
        border-radius: 10px;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .modal h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .modal form {
        display: flex;
        gap: 10px;
    }

    .modal input[type="text"] {
        flex-grow: 1;
        padding: 10px 12px;
        border: 1.5px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    .modal button {
        background: #667eea;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.2s ease;
    }

    .modal button:hover {
        background: #5563c1;
    }

    /* Action buttons in table */
    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        color: white;
    }

    .done-btn {
        background: #38a169;
    }

    .undo-btn {
        background: #ecc94b;
        color: #333;
    }

    .delete-btn {
        background: #e53e3e;
    }
</style>
</head>
<body>

<h1>My To-Do List</h1>

<button class="add-btn" onclick="openModal()">+ Add Task</button>

<table>
    <thead>
        <tr>
            <th>Task</th>
            <th>Status</th>
            <th style="width: 150px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="task-title <?php echo e($task->is_completed ? 'done' : ''); ?>"><?php echo e($task->title); ?></td>
            <td><?php echo e($task->is_completed ? 'Completed' : 'Pending'); ?></td>
            <td>
                <form method="POST" action="<?php echo e(route('tasks.update', $task)); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="btn <?php echo e($task->is_completed ? 'undo-btn' : 'done-btn'); ?>">
                        <?php echo e($task->is_completed ? 'Undo' : 'Done'); ?>

                    </button>
                </form>

                <form method="POST" action="<?php echo e(route('tasks.destroy', $task)); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal-bg" id="modal">
    <div class="modal">
        <h2>Add New Task</h2>
        <form method="POST" action="<?php echo e(route('tasks.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="text" name="title" placeholder="Enter task title" required />
            <button type="submit">Add</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modal');

    function openModal() {
        modal.classList.add('active');
    }

    function closeModal(e) {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    }

    modal.addEventListener('click', closeModal);

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            modal.classList.remove('active');
        }
    });
</script>

</body>
</html>
<?php /**PATH C:\Users\Lenovo\Desktop\todo\to-do\resources\views/tasks/index.blade.php ENDPATH**/ ?>