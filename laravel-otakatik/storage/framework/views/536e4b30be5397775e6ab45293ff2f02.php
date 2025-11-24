
<?php $__env->startSection('title', 'Reset Password'); ?>


<?php $__env->startSection('content'); ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h1>Reset Password</h1>
            <form action="<?php echo e(route('resetpassword.post')); ?>" method="post">
                <input type="hidden" name="token" value="<?php echo e($token); ?>" />
                <?php echo csrf_field(); ?>
                 <?php echo $__env->make('layout.notif', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-2">
                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password-confirmation" id="password-confirmation">
                </div>
                <div class="d-inline">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Joandri Alkahfi K\Desktop\laravel\resources\views/user/reset-password.blade.php ENDPATH**/ ?>