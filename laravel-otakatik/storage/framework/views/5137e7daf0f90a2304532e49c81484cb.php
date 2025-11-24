
<?php $__env->startSection('title', 'Update Data'); ?>

<?php $__env->startSection('nav'); ?>
<?php echo $__env->make('layout.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h1>Update Data</h1>
            <form action="<?php echo e(route('user.updatedata.post')); ?>" method="post">
                <?php echo csrf_field(); ?>
                 <?php echo $__env->make('layout.notif', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="mb-2">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" disabled class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo e(Auth::user()->email); ?>">
                </div>
                  <div class="mb-2">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')?old('name'):Auth::user()->name); ?>">
                </div>
                <h3>Password</h3>
                <div class="form-text">Silakan masukkan password jika akan melakukan pergantian password</div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-2">
                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password-confirmation" id="password-confirmation">
                </div>
                <div class="d-inline">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Joandri Alkahfi K\Desktop\laravel\resources\views/user/update-data.blade.php ENDPATH**/ ?>