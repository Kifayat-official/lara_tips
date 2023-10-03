

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form action="<?php echo e(route('store')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3 row">
                            <label for="username" class="col-md-4 col-form-label text-md-end text-start">User Name</label>
                            <div class="col-md-6">
                                <input type="username" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="username" name="username" value="<?php echo e(old('username')); ?>">
                                <?php if($errors->has('username')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('username')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="region_code" class="col-md-4 col-form-label text-md-end text-start">Region
                                Code</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control <?php $__errorArgs = ['region_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="region_code" name="region_code" value="<?php echo e(old('region_code')); ?>">
                                <?php if($errors->has('region_code')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('region_code')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="region_name" class="col-md-4 col-form-label text-md-end text-start">Region
                                Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control <?php $__errorArgs = ['region_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="region_name" name="region_name" value="<?php echo e(old('region_name')); ?>">
                                <?php if($errors->has('region_name')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('region_name')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="password" name="password">
                                <?php if($errors->has('password')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password_confirmation"
                                class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Register">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Kifayat Ullah\Desktop\Code Squad\AppSquad\laravel\telco_sims\TelcoSims\resources\views/auth/register.blade.php ENDPATH**/ ?>