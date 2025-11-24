

<?php $__env->startSection('title', 'To Do List'); ?>

<?php $__env->startSection('nav'); ?>
<?php echo $__env->make('layout.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <!-- 01. Content-->
        <h1 class="text-center mb-4">To Do List</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
             <div class="card mb-3">
                <div class="card-body">
                   <?php echo $__env->make('layout.notif', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <!-- 02. Form input data -->
                    <form id="todo-form" action="<?php echo e(route('todo.post')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="task" id="todo-input"
                                placeholder="Tambah task baru" required value="<?php echo e(old('task')); ?>">
                            <button class="btn btn-primary" type="submit">
                                Simpan
                            </button>
                        </div>
                    </form>
                  </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- 03. Searching -->
                        <form id="todo-form" action="<?php echo e(route('todo')); ?>" method="get">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" value="<?php echo e(request ('search')); ?>" 
                                    placeholder="masukkan kata kunci">
                                <button class="btn btn-secondary" type="submit">
                                    Cari
                                </button>
                            </div>
                        </form>
                        
                        <ul class="list-group mb-4" id="todo-list">
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                            <!-- 04. Display Data -->
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="task-text">
                                    <?php echo $item->is_done == '1'?'<del>':''; ?>

                                        <?php echo e($item->task); ?>

                                        <?php echo $item->is_done == '1'?'</del>':''; ?>

                                </span>
                                <input type="text" class="form-control edit-input" style="display: none;"
                                    value="<?php echo e($item->task); ?>">
                                <div class="btn-group">
                                    <form action="<?php echo e(route('todo.delete',['id'=>$item->id])); ?>" method="POST" onsubmit="return confirm('Yakin akan menghapus data ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('delete'); ?>
                                        <button class="btn btn-danger btn-sm delete-btn">✕</button>
                                    </form>
                                    <button class="btn btn-primary btn-sm edit-btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-<?php echo e($loop->index); ?>" aria-expanded="false">✎</button>
                                </div>
                            </li>
                            <!-- 05. Update Data -->
                            <li class="list-group-item collapse" id="collapse-<?php echo e($loop->index); ?>">
                                <form action="<?php echo e(route('todo.update',['id'=>$item->id])); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('put'); ?>
                                    <div>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="task"
                                                value="<?php echo e($item->task); ?>">
                                            <button class="btn btn-outline-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="radio px-2">
                                            <label>
                                                <input type="radio" value="1" name="is_done" <?php echo e($item->is_done == '1'?'checked':''); ?>> Selesai
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" value="0" name="is_done"<?php echo e($item->is_done == '0'?'checked':''); ?>> Belum
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php echo e($data->links()); ?>

                        
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Joandri Alkahfi K\Desktop\laravel\resources\views/todo/app.blade.php ENDPATH**/ ?>