<?php

$uniqid = uniqid();

?>



<?php $__env->startSection('content_header'); ?>
    <h1>
        <?php echo e(isset($obj) ? 'Edit' : 'Add'); ?> Role
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box box-primary">
    
    <div class="box-body">
        <form id="form_<?php echo e($uniqid); ?>" action="" method="POST">
            <?php echo csrf_field(); ?>
            <?php if(isset($obj)): ?>
            <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="row">
    
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo e(isset($obj) ? $obj->name : ''); ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Level</label>
                        <input type="number" class="form-control" aria-describedby="helpId" name="level" max="<?php echo e(\Auth::user()->is_super_admin == 1 ? 100 : \Auth::user()->role->level); ?>" value="<?php echo e(isset($obj) ? $obj->level : ''); ?>" required>
                        <small id="helpId" class="form-text text-muted">
                        Help: If a user has role level 10 then he can assign roles of level 10 or lower to other users.
                        </small>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">
                        Role Permissions
                    </h3>
                </div>

                <div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="col-md-10">Permission</th>
                                <th class="col-md-2 text-center">Allowed</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $additional_data['permissions']->groupBy('group'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $group_permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="bg-info">
                                    <td colspan="2"><b><?php echo e($group); ?></b></td>
                                </tr>
                                <?php $__currentLoopData = $group_permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(\Auth::user()->hasPermission($permission->idt)): ?>
                                    <tr>
                                        <td><?php echo e($permission->name); ?></td>
                                        <td class="text-center">

                                            <?php
                                            $checked = false;
                                            if(isset($obj)) {
                                                $role_permission = $obj->permissions->first(function($role_permission, $index) use($permission) {
                                                return $role_permission->id == $permission->id;
                                                });

                                                if($role_permission != null) {
                                                $checked = true;
                                                }
                                            }
                                            ?>

                                            <input type="checkbox" name="permission_id[]" value="<?php echo e($permission->id); ?>" <?php echo e($checked ? 'checked' : ''); ?>>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>

            <?php $__env->startComponent('components.submit_button'); ?>
            <?php echo $__env->renderComponent(); ?>

        </form>
    </div>

</div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function(){
        
        submitForm({
            formId: "#form_<?php echo e($uniqid); ?>",
            formDataFunction: function() {
                var formData = new FormData(document.querySelector('#form_<?php echo e($uniqid); ?>'));
                return formData;
            },
            submitUrl: "<?php echo e(isset($obj) ? url('roles') . '/' . $obj->id : url('roles')); ?>",
            successfulCallback: function() {
                window.location.href = "<?php echo e(url('roles')); ?>";
            },
            failureCallback: null,
            alwaysCallback: null,
        });

        
        $('.header-test-checkbox').change(function(){
            $('.test-checkbox').prop('checked', $(this).prop('checked'));
        });

    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\dev\htdocs\udil2\resources\views/roles/add_edit.blade.php ENDPATH**/ ?>