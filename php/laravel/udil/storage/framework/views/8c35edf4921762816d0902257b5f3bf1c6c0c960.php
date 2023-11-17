<?php $__env->startSection('content_header'); ?>
    <h1>
        Dashboard
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">

    <div class="col-md-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3><?php echo e($tests->where('is_finished', 1)->count()); ?></h3>
                <p>Completed Tests</p>
            </div>
            <div class="icon">
                <i class="fa fa-stop-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="small-box bg-orange">
            <div class="inner">
                <h3><?php echo e($tests->where('is_finished', 0)->count()); ?></h3>
                <p>Tests in Progress</p>
            </div>
            <div class="icon">
                <i class="fa fa-play-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo e($tests->where('is_pass', 1)->count()); ?></h3>
                <p>Passed Tests</p>
            </div>
            <div class="icon">
                <i class="fa fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="small-box bg-red">
            <div class="inner">
            <h3><?php echo e($tests->where('is_pass', 0)->count()); ?></h3>
                <p>Failed Tests</p>
            </div>
            <div class="icon">
                <i class="fa fa-times-circle"></i>
            </div>
        </div>
    </div>

</div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xamp\htdocs\testing_suite\resources\views/dashboard.blade.php ENDPATH**/ ?>