<?php

$uniqid = uniqid();

?>



<?php $__env->startSection('content_header'); ?>
    <h1>
        Manage UDIL Checklists
        <!-- <a class="btn btn-success pull-right" href="<?php echo e(url('test_profiles/create')); ?>">
            <i class="fa fa-plus-circle"></i>
            Add New Test Profile
        </a> -->
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box box-primary">
    
    <div class="box-body">
        <?php $__env->startComponent('components.datatable', [
            'uniqid' => $uniqid,
            'data_url' => url('test_profiles/datatable'),
            'resource_url' => url('test_profiles'),
            'columns' => [
                [ 'is_data_column' => true, 'title' => 'Name', 'data' => 'name', 'name' => 'name' ],
                [ 'is_data_column' => false, 'title' => 'Action', 'data' => 'action', 'name' => 'action', 'class' => 'text-center col-md-4' ],
            ]
        ]); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>

</div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\udil\htdocs\udil\resources\views/test_profiles/list.blade.php ENDPATH**/ ?>