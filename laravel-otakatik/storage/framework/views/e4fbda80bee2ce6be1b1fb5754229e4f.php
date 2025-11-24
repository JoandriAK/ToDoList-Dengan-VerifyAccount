
<?php $__env->startSection('title', 'Reset Password'); ?>
<?php $__env->startSection('content'); ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h1>Reset Password</h1>
            <form action="<?php echo e(route('forgotpassword.post')); ?>" method="post">
                <?php echo csrf_field(); ?>
                 <?php echo $__env->make('layout.notif', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="mb-2">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo e(old('email')); ?>">
                </div>
                <div class="d-inline">
                    <a href="<?php echo e(route('login')); ?>">Login</a> | <a href="<?php echo e(route('register')); ?>">Register</a>
                    <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Joandri Alkahfi K\Desktop\laravel\resources\views/user/forgot-password.blade.php ENDPATH**/ ?>