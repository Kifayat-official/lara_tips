<?php

$uniqid = uniqid();

?>



<?php $__env->startSection('content_header'); ?>
    <h1>
        Manage Companies
        <!-- <a class="btn btn-success pull-right" href="<?php echo e(url('roles/create')); ?>">
            <i class="fa fa-plus-circle"></i>
            Add New Role
        </a> -->
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box box-primary">
    
    <div class="box-body">
        <?php $__env->startComponent('components.datatable', [
            'uniqid' => $uniqid,
            'data_url' => url('companies/datatable'),
            'resource_url' => url('companies'),
            'columns' => [
                [ 'is_data_column' => true, 'title' => 'Name', 'data' => 'name', 'name' => 'name' ],
                [ 'is_data_column' => true, 'title' => 'Address', 'data' => 'address', 'name' => 'address' ],
                [ 'is_data_column' => true, 'title' => 'Phone', 'data' => 'phone', 'name' => 'phone' ],
                [ 'is_data_column' => true, 'title' => 'Email', 'data' => 'email', 'name' => 'email' ],
                [ 'is_data_column' => false, 'title' => 'Action', 'data' => 'action', 'name' => 'action', 'class' => 'text-center col-md-3' ],
            ]
        ]); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>

</div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xamp\htdocs\testing_suite\resources\views/companies/list.blade.php ENDPATH**/ ?>