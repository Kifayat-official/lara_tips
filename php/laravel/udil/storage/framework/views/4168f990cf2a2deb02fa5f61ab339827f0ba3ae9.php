<?php

$uniqid = uniqid();

?>



<?php $__env->startSection('content_header'); ?>
    <h1>
        Manage Users
        <!-- <a class="btn btn-success pull-right" href="<?php echo e(url('users/create')); ?>">
            <i class="fa fa-plus-circle"></i>
            Add New User
        </a> -->
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box box-primary">
    
    <div class="box-body">
        <?php $__env->startComponent('components.datatable', [
            'uniqid' => $uniqid,
            'data_url' => url('users/datatable'),
            'resource_url' => url('users'),
            'columns' => [
                [ 'is_data_column' => true, 'title' => 'Name', 'data' => 'name', 'name' => 'name' ],
                [ 'is_data_column' => false, 'title' => 'Is Super Admin', 'data' => 'is_super_admin', 'name' => 'is_super_admin' ],
                [ 'is_data_column' => true, 'title' => 'Role', 'data' => 'role.name', 'name' => 'role.name' ],
                [ 'is_data_column' => true, 'title' => 'Role Level', 'data' => 'role.level', 'name' => 'role.level' ],
                [ 'is_data_column' => false, 'title' => 'Status', 'data' => 'status', 'name' => 'status' ],
                [ 'is_data_column' => false, 'title' => 'Action', 'data' => 'action', 'name' => 'action', 'class' => 'text-center col-md-3' ],
                
            ]
        ]); ?>
        <?php echo $__env->renderComponent(); ?>
    </div>

</div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\udil\htdocs\udil\resources\views/users/list.blade.php ENDPATH**/ ?>